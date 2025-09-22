<?php

namespace Modules\ProjectManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Finance\Models\CashCounter;
use Modules\ProjectManager\Models\Site;
use Modules\ProjectManager\Models\SitePayment;
use Modules\ProjectManager\Models\SitePaymentDetails;

class PaymentDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($site_id)
    {
        // dd("hello");
        $site = Site::with('payment', 'paymentDetails')->findOrFail($site_id);

        $totalPaid = $site->payment ? $site->payment->paid_amount : 0;
        $totalDue = $site->payment ? $site->payment->due_amount : 0;
        $totalAmount = $site->payment ? $site->payment->amount : 0;

        // dd('hello');

        return view('projectmanager::site.payment_details', compact('site', 'totalPaid', 'totalDue', 'totalAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projectmanager::create');
    }

    public function pay($site_id)
    {
        dd('pay');
        $site = Site::with('payment')->findOrFail($site_id);
        $totalDue  = $site->payment ? $site->payment->due_amount : 0;

        return view('projectmanager::site.pay_amount', compact('site', 'totalDue'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd('hello');
        // 1️⃣ Fetch project
        $site = Site::findOrFail($request->site_id);

        // 2️⃣ Validate request safely
        $request->validate([
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'date' => 'required|date',
            'check_number' => 'nullable|required_if:payment_method,check|string',
            'online_image' => 'nullable|required_if:payment_method,online|image|max:2048',
        ]);
        // dd('Check');

        // 3️⃣ Handle online image upload
        $onlineImagePath = null;
        if ($request->hasFile('online_image')) {
            $onlineImage = $request->file('online_image'); // get the uploaded file
            $onlineImagePath = time() . '.' . $onlineImage->getClientOriginalExtension(); // generate unique name
            $onlineImage->move(public_path('upload/images/Payment'), $onlineImagePath); // move to public folder
        }

        // 4️⃣ Update or create Payment record
        $payment = SitePayment::firstOrNew(['site_id' => $site->id]);

        $payment->paid_amount = ($payment->paid_amount ?? 0) + $request->paid_amount;
        $payment->due_amount = max(0, ($payment->due_amount ?? $site->total_due) - $request->paid_amount);
        $payment->save();

        // 5️⃣ Store PaymentDetails record
        SitePaymentDetails::create([
            'payment_id' => $payment->id,
            'site_id' => $site->id,
            'amount' => $request->paid_amount,
            'payment_method' => $request->payment_method,
            'check_number' => $request->check_number,
            'online_image' => $onlineImagePath,
            'date' => $request->date,
        ]);

        $paidAmount =  $request->paid_amount;
        if ($request->payment_method === 'cash') {
            $cashCounter = CashCounter::first();
            if ($cashCounter) {
                $cashCounter->opening_amount = ($cashCounter->opening_amount ?? 0) + $paidAmount;
                $cashCounter->due_amount = ($cashCounter->due_amount ?? 0) + $paidAmount;
                $cashCounter->save();
            } else {
                CashCounter::create([
                    'opening_amount' => $paidAmount,
                    'due_amount'     => $paidAmount,
                ]);
            }
        }

        return redirect()->route('paymentdetails.index', $site->id)
            ->with('success', 'Payment recorded successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('projectmanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('projectmanager::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
