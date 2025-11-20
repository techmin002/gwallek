<?php

namespace Modules\OrderManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OrderManager\Models\PurchaseItem;
use Modules\OrderManager\Models\Payment;
use Modules\OrderManager\Models\Order;
use Modules\OrderManager\Models\Invoice;
use Modules\OrderManager\Models\PaymentItem;
use Modules\ProjectManager\Models\Site;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class PaymentController extends Controller
{
    /**
     * Show recent payments on project selection page
     */
    public function selectProject()
{
    $projects = Site::with(['customer', 'branch'])->get();
    
    // Get recent payments with related data
    $recentPayments = Payment::with([
        'project.customer',
        'paymentItems.purchaseItem',
        'invoice',
        'paidBy'
    ])
    ->latest()
    
    ->get();

    return view('ordermanager::payments.select-project', compact('projects', 'recentPayments'));
}
    /**
     * Show purchase items for selected project
     */
    public function showProjectItems(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:sites,id'
    ]);

    $project = Site::with(['customer', 'branch'])->findOrFail($request->project_id);

    // Get purchase items through orders with payment items
    $purchaseItems = PurchaseItem::whereHas('orderItem.order', function ($query) use ($request) {
        $query->where('project_id', $request->project_id);
    })->with([
        'orderItem.order', 
        'paymentItems' // Load payment items
    ])->get();

    return view('ordermanager::payments.project-items', compact('project', 'purchaseItems'));
}
    /**
     * Show payment form for multiple purchase items
     */
    public function create(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:sites,id',
        'purchase_items' => 'required|array',
        'purchase_items.*' => 'exists:purchase_items,id'
    ]);

    $project = Site::with(['customer'])->findOrFail($request->project_id);
    
    // Load purchase items with payment items instead of payment
    $purchaseItems = PurchaseItem::whereIn('id', $request->purchase_items)
        ->with(['orderItem.order', 'paymentItems'])
        ->get();

    // Calculate totals using the new accessor methods
    $totals = $this->calculateTotals($purchaseItems);

    return view('ordermanager::payments.create', compact('project', 'purchaseItems', 'totals'));
}

/**
 * Calculate totals for purchase items using new accessors
 */
private function calculateTotals($purchaseItems)
{
    $totalAmount = 0;
    $totalPaid = 0;
    $totalRemaining = 0;

    foreach ($purchaseItems as $item) {
        $totalAmount += $item->total_price;
        $totalPaid += $item->paid_amount; // Using accessor
        $totalRemaining += $item->remaining_amount; // Using accessor
    }

    return [
        'total_amount' => $totalAmount,
        'total_paid' => $totalPaid,
        'total_remaining' => $totalRemaining
    ];
}

    /**
     * Process payment for multiple items
     */
public function store(Request $request)
{
    Log::info('=== PAYMENT STORE REQUEST START ===');
    Log::info('All Request Data:', $request->all());
    Log::info('Paid Amounts:', $request->paid_amounts ?: []);

    // Check if paid_amounts is empty
    if (empty($request->paid_amounts)) {
        Log::warning('paid_amounts is empty or not set');
        return redirect()->back()->with('error', 'No payment amounts provided.');
    }

    // Manual validation
    $errors = [];

    if (!$request->project_id) {
        $errors[] = 'Project ID is required';
    }

    if (!$request->payment_type) {
        $errors[] = 'Payment type is required';
    }

    if (!$request->paid_by) {
        $errors[] = 'Paid by is required';
    }

    if (!$request->paid_at) {
        $errors[] = 'Payment date is required';
    }

    if (!empty($errors)) {
        Log::warning('Validation errors:', ['errors' => $errors]);
        return redirect()->back()
            ->with('error', implode(', ', $errors))
            ->withInput();
    }

    Log::info('Basic validation passed');

    try {
        DB::beginTransaction();
        Log::info('Transaction started');

        $totalPaid = 0;
        $hasProcessedPayments = false;
        $paymentItemsData = [];

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentPath = $attachment->store('payment-attachments', 'public');
            Log::info('Attachment stored:', ['path' => $attachmentPath]);
        }

        // Auto-generate receipt number if not provided
        $receiptNumber = $request->receipt_number;
        if (empty($receiptNumber)) {
            $receiptNumber = 'RCPT-' . date('YmdHis') . '-' . rand(1000, 9999);
        }

        // Generate unique transaction ID
        $transactionId = 'TXN-' . date('YmdHis') . '-' . rand(1000, 9999);

        // Get current user info for remarks
        $currentUser = auth()->user();
        $userInfo = "Processed by: " . $currentUser->name . " (User ID: " . $currentUser->id . ")";

        // Combine user info with custom remarks
        $combinedRemark = $userInfo;
        if (!empty($request->remark)) {
            $combinedRemark .= "\n\nAdditional Remarks:\n" . $request->remark;
        }

        Log::info('Processing paid amounts:', ['count' => count($request->paid_amounts)]);

        // First, validate all items and calculate totals
        foreach ($request->paid_amounts as $purchaseItemId => $paidAmount) {
            $paidAmount = floatval($paidAmount);
            
            if ($paidAmount > 0) {
                // Load purchase item with payment items instead of payment
                $purchaseItem = PurchaseItem::with('paymentItems')->find($purchaseItemId);
                
                if (!$purchaseItem) {
                    throw new \Exception("Purchase item not found: " . $purchaseItemId);
                }

                $totalPrice = $purchaseItem->total_price;
                
                // Calculate previous paid amount from payment items
                $previousPaid = $purchaseItem->paymentItems->sum('paid_amount');
                
                // Validate payment amount
                $maxAllowed = $totalPrice - $previousPaid;
                if ($paidAmount > $maxAllowed) {
                    throw new \Exception("Payment amount for '{$purchaseItem->title}' exceeds remaining amount. Max allowed: ₹" . number_format($maxAllowed, 2));
                }

                $newPaidAmount = $previousPaid + $paidAmount;
                $remainingAmount = $totalPrice - $newPaidAmount;
                $paymentStatus = $remainingAmount <= 0 ? 'paid' : ($paidAmount > 0 ? 'partial' : 'unpaid');

                $paymentItemsData[] = [
                    'purchase_item_id' => $purchaseItemId,
                    'paid_amount' => $paidAmount,
                    'previous_paid' => $previousPaid,
                    'new_paid_amount' => $newPaidAmount,
                    'remaining_amount' => $remainingAmount,
                    'payment_status' => $paymentStatus,
                ];

                $totalPaid += $paidAmount;
                $hasProcessedPayments = true;
            }
        }

        if (!$hasProcessedPayments) {
            throw new \Exception('No payments processed. Please enter payment amounts greater than 0.');
        }

        // Create the main payment record
        $paymentData = [
            'receipt_number' => $receiptNumber,
            'payment_type' => $request->payment_type,
            'remark' => $combinedRemark,
            'total_paid_amount' => $totalPaid,
            'paid_by' => $request->paid_by,
            'project_id' => $request->project_id,
            'transaction_id' => $transactionId,
            'paid_at' => $request->paid_at,
        ];

        if ($attachmentPath) {
            $paymentData['attachment'] = $attachmentPath;
        }

        Log::info("Creating main payment record:", $paymentData);
        $payment = Payment::create($paymentData);

        // Create payment items
        foreach ($paymentItemsData as $itemData) {
            PaymentItem::create(array_merge($itemData, ['payment_id' => $payment->id]));
            
            // No need to update purchase item separately as we're using accessors
            // The paid_amount and remaining_amount accessors will calculate from payment items
        }

        Log::info("Payment processing summary:", [
            'total_paid' => $totalPaid,
            'payment_id' => $payment->id,
            'items_processed' => count($paymentItemsData)
        ]);

        DB::commit();
        Log::info('Transaction committed successfully');

        return redirect()->route('payments.success')
            ->with('success', 'Payment processed successfully!')
            ->with('total_paid', $totalPaid)
            ->with('receipt_number', $receiptNumber)
            ->with('payment_id', $payment->id)
            ->with('project_id', $request->project_id);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Payment processing failed:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return redirect()->back()
            ->with('error', 'Payment failed: ' . $e->getMessage())
            ->withInput();
    }
}

   /**
 * Generate bill for a payment
 */
/**
 * Generate bill for a payment
 */
public function generateBill($paymentId)
{
    try {
        $payment = Payment::with([
            'project.customer',
            'project.branch',
            'paymentItems.purchaseItem.orderItem.order',
            'paidBy',
            'invoice'
        ])->findOrFail($paymentId);

        // Check if invoice already exists
        $invoice = $payment->invoice;
        
        if (!$invoice) {
            $invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad($payment->id, 6, '0', STR_PAD_LEFT);
            
            $invoice = Invoice::create([
                'payment_id' => $payment->id,
                'invoice_no' => $invoiceNo,
                'file_path' => null,
                'generated_by' => auth()->id(),
                'generated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bill generated successfully',
            'invoice_id' => $invoice->id,
            'invoice_no' => $invoice->invoice_no
        ]);

    } catch (\Exception $e) {
        Log::error('Bill generation failed:', [
            'payment_id' => $paymentId,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to generate bill: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Download bill as PDF
 */
/**
 * Download bill as PDF
 */
public function downloadBill($invoiceId)
{
    try {
        $invoice = Invoice::with([
            'payment.project.customer',
            'payment.project.branch',
            'payment.paymentItems.purchaseItem.orderItem.order',
            'payment.paidBy',
            'generatedBy'
        ])->findOrFail($invoiceId);

        $payment = $invoice->payment;
        $project = $payment->project;
        $paymentItems = $payment->paymentItems;

        // Get company information
        $company = \Modules\Setting\Entities\CompanyProfile::first();
        if (!$company) {
            // Create default company info if not exists
            $company = new \stdClass();
            $company->company_name = config('app.name', 'Laravel');
            $company->company_email = 'info@company.com';
            $company->company_phone = '+1 (555) 123-4567';
            $company->company_address = '123 Business Street, City, State 12345';
            $company->logo = null;
        }

        $data = [
            'invoice' => $invoice,
            'payment' => $payment,
            'project' => $project,
            'paymentItems' => $paymentItems,
            'company' => $company,
        ];

        // Return HTML view (you can convert to PDF later)
        return view('ordermanager::payments.bill', $data);

    } catch (\Exception $e) {
        Log::error('Bill download failed:', [
            'invoice_id' => $invoiceId,
            'error' => $e->getMessage()
        ]);

        return redirect()->back()->with('error', 'Failed to download bill: ' . $e->getMessage());
    }
}

    /**
     * View payment details
     */
    public function show($paymentId)
{
    $payment = Payment::with([
        'project.customer',
        'project.branch',
        'paymentItems.purchaseItem',
        'invoice',
        'paidBy'
    ])->findOrFail($paymentId);

    return view('ordermanager::payments.show', compact('payment'));
}

    /**
     * View all payments history
     */
    public function paymentHistory()
    {
        $payments = Payment::with([
            'purchaseItem.orderItem.order.project.customer',
            'purchaseItem.orderItem.order.project.branch',
            'invoice',
            'paidBy'
        ])
            ->latest()
            ->paginate(25);

        return view('ordermanager::payments.history', compact('payments'));
    }

    /**
     * Payment success page
     */
    public function success()
    {
        return view('ordermanager::payments.success');
    }

    /**
     * Calculate totals for purchase items
     */
   
    /**
     * Generate invoice for individual payment
     */
    private function generateInvoice(Payment $payment)
    {
        $existingInvoice = Invoice::where('payment_id', $payment->id)->first();

        if (!$existingInvoice) {
            $invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad($payment->id, 6, '0', STR_PAD_LEFT);

            Invoice::create([
                'payment_id' => $payment->id,
                'invoice_no' => $invoiceNo,
                'file_path' => null,
                'generated_by' => auth()->id() ?? 1,
                'generated_at' => now(),
            ]);
        }
    }
    
}
