<?php

namespace Modules\Mechanical\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Finance\Models\Bank;
use Modules\Finance\Models\CashCounter;
use Modules\Mechanical\Models\Mechanical;
use Modules\Mechanical\Models\MechanicalExpense;
use Modules\Mechanical\Models\MechanicalExpenseProduct;

class MechanicalExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->access_type == 'Super Admin') {
            $expenses = MechanicalExpense::with(['mechanical', 'products'])
                ->latest()
                ->get();

            $mechanicals = Mechanical::all();
            $banks = Bank::all();
        } else {
            $branchId = auth()->user()->branch_id;

            $expenses = MechanicalExpense::with(['mechanical', 'products'])
                ->whereHas('mechanical', function ($q) use ($branchId) {
                    $q->where('branch_id', $branchId);
                })
                ->latest()
                ->get();

            $mechanicals = Mechanical::where('branch_id', $branchId)->get();
            $banks = Bank::where('branch_id', $branchId)->get();
        }

        return view('mechanical::expenses.index', compact('expenses', 'mechanicals', 'banks'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mechanical::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'mechanical_id' => 'required|exists:mechanicals,id',
            'title'         => 'required|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'date'          => 'required|date',
            'payment_method' => 'required|in:Cash,Online,Cheque',
            'bank_id'       => 'nullable|exists:banks,id',
            'cheque_number' => 'nullable|string|max:255',
            'receipt'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description'   => 'nullable|string',
            'products'      => 'nullable|array',
            'products.*.name'     => 'nullable|string|max:255',
            'products.*.title'    => 'nullable|string|max:255',
            'products.*.amount'   => 'nullable|numeric|min:0',
            'products.*.quantity' => 'nullable|numeric|min:1',
            'products.*.total'    => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Handle Receipt Upload
            $receiptName = null;
            if ($request->hasFile('receipt')) {
                $receiptName = time() . '.' . $request->receipt->getClientOriginalExtension();
                $request->receipt->move(public_path('upload/images/mechanical_expenses/receipts'), $receiptName);
            }

            $mechanical = Mechanical::findOrFail($request->mechanical_id);
            $branchId   = $mechanical->branch_id;

            // ✅ Payment Validation
            if (in_array($request->payment_method, ['Online', 'Cheque'])) {
                $bank = Bank::where('id', $request->bank_id)->where('branch_id', $branchId)->first();
                if (!$bank) {
                    return back()->with('error', 'Selected bank not found for this branch.');
                }
                if ($request->amount > $bank->closing_amount) {
                    return back()->with('error', 'Not enough balance in the selected bank!');
                }
                // Deduct Bank Balance
                $bank->closing_amount -= $request->amount;
                $bank->save();
            } elseif ($request->payment_method === 'Cash') {
                $cashCounter = CashCounter::where('branch_id', $branchId)->first();
                if (!$cashCounter) {
                    return back()->with('error', 'Cash counter not found for this branch.');
                }
                if ($request->amount > $cashCounter->due_amount) {
                    return back()->with('error', 'Insufficient cash in counter!');
                }
                // Deduct Cash Balance
                $cashCounter->due_amount    -= $request->amount;
                $cashCounter->reduce_amount += $request->amount;
                $cashCounter->save();
            }

            // ✅ Save Expense
            $expense = MechanicalExpense::create([
                'mechanical_id' => $request->mechanical_id,
                'title'         => $request->title,
                'amount'        => $request->amount,
                'payment_method' => $request->payment_method,
                'bank_id'       => $request->bank_id ?? null,
                'cheque_number' => $request->cheque_number ?? null,
                'receipt'       => $receiptName,
                'date'          => $request->date,
                'description'   => $request->description,
                'status'        => 'on',
            ]);

            // ✅ Save Products
            if ($request->has('products')) {
                foreach ($request->products as $product) {
                    if (!empty($product['name']) || !empty($product['title'])) {
                        MechanicalExpenseProduct::create([
                            'mechanical_expense_id' => $expense->id,
                            'name'       => $product['name'] ?? null,
                            'title'      => $product['title'] ?? null,
                            'amount'     => $product['amount'] ?? 0,
                            'quantity'   => $product['quantity'] ?? 0,
                            'total'      => $product['total'] ?? 0,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Mechanical Expense created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $expense = MechanicalExpense::with('mechanical', 'products')->findOrFail($id);

        return view('mechanical::expenses.details', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('mechanical::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'mechanical_id' => 'required|exists:mechanicals,id',
            'title'         => 'required|string|max:255',
            'amount'        => 'required|numeric|min:0',
            'date'          => 'required|date',
            'payment_method' => 'required|in:Cash,Online,Cheque',
            'bank_id'       => 'nullable|exists:banks,id',
            'cheque_number' => 'nullable|string|max:255',
            'receipt'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description'   => 'nullable|string',
            'products'      => 'nullable|array',
            'products.*.name'     => 'nullable|string|max:255',
            'products.*.title'    => 'nullable|string|max:255',
            'products.*.amount'   => 'nullable|numeric|min:0',
            'products.*.quantity' => 'nullable|numeric|min:1',
            'products.*.total'    => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            $expense = MechanicalExpense::with('products')->findOrFail($id);
            $mechanical = Mechanical::findOrFail($request->mechanical_id);
            $branchId   = $mechanical->branch_id;

            $oldAmount        = $expense->amount;
            $oldMethod        = $expense->payment_method;
            $oldBankId        = $expense->bank_id;
            $oldChequeNumber  = $expense->cheque_number;

            // ✅ Revert Old Transaction
            if (in_array($oldMethod, ['Online', 'Cheque']) && $oldBankId) {
                $oldBank = Bank::where('id', $oldBankId)->where('branch_id', $branchId)->first();
                if ($oldBank) {
                    $oldBank->closing_amount += $oldAmount; // wapas add
                    $oldBank->save();
                }
            } elseif ($oldMethod === 'Cash') {
                $cashCounter = CashCounter::where('branch_id', $branchId)->first();
                if ($cashCounter) {
                    $cashCounter->due_amount    += $oldAmount; // wapas add
                    $cashCounter->reduce_amount -= $oldAmount;
                    $cashCounter->save();
                }
            }

            // ✅ Handle Receipt Upload (replace if new uploaded)
            $receiptName = $expense->receipt;
            if ($request->hasFile('receipt')) {
                if ($receiptName && file_exists(public_path('upload/images/mechanical_expenses/receipts/' . $receiptName))) {
                    unlink(public_path('upload/images/mechanical_expenses/receipts/' . $receiptName));
                }
                $receiptName = time() . '.' . $request->receipt->getClientOriginalExtension();
                $request->receipt->move(public_path('upload/images/mechanical_expenses/receipts'), $receiptName);
            }

            // ✅ Apply New Transaction
            if (in_array($request->payment_method, ['Online', 'Cheque'])) {
                $bank = Bank::where('id', $request->bank_id)->where('branch_id', $branchId)->first();
                if (!$bank) {
                    return back()->with('error', 'Selected bank not found for this branch.');
                }
                if ($request->amount > $bank->closing_amount) {
                    return back()->with('error', 'Not enough balance in the selected bank!');
                }
                $bank->closing_amount -= $request->amount;
                $bank->save();
            } elseif ($request->payment_method === 'Cash') {
                $cashCounter = CashCounter::where('branch_id', $branchId)->first();
                if (!$cashCounter) {
                    return back()->with('error', 'Cash counter not found for this branch.');
                }
                if ($request->amount > $cashCounter->due_amount) {
                    return back()->with('error', 'Insufficient cash in counter!');
                }
                $cashCounter->due_amount    -= $request->amount;
                $cashCounter->reduce_amount += $request->amount;
                $cashCounter->save();
            }

            // ✅ Update Expense
            $expense->update([
                'mechanical_id' => $request->mechanical_id,
                'title'         => $request->title,
                'amount'        => $request->amount,
                'payment_method' => $request->payment_method,
                'bank_id'       => $request->bank_id ?? null,
                'cheque_number' => $request->cheque_number ?? null,
                'receipt'       => $receiptName,
                'date'          => $request->date,
                'description'   => $request->description,
            ]);

            // ✅ Update Products
            $expense->products()->delete(); // purane hatao
            if ($request->has('products')) {
                foreach ($request->products as $product) {
                    if (!empty($product['name']) || !empty($product['title'])) {
                        MechanicalExpenseProduct::create([
                            'mechanical_expense_id' => $expense->id,
                            'name'       => $product['name'] ?? null,
                            'title'      => $product['title'] ?? null,
                            'amount'     => $product['amount'] ?? 0,
                            'quantity'   => $product['quantity'] ?? 0,
                            'total'      => $product['total'] ?? 0,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Mechanical Expense updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
