<?php

namespace Modules\Expenses\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Modules\Expenses\Entities\ExpenseCategory;
use Modules\Expenses\Entities\Expenses;
use Modules\Finance\Models\Bank;
use Modules\Finance\Models\CashCounter;
use Modules\Pettycash\Entities\PettyCashAdd;
use Modules\Pettycash\Entities\PettyCashTransaction;
use Yajra\DataTables\DataTables;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $user = auth()->user();

        // Expenses fetch based on access_type
        if ($user->access_type === 'Super Admin') {
            $expenses = Expenses::with('category', 'branch', 'bank')
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $expenses = Expenses::with('category', 'branch', 'bank')
                ->where('branch_id', $user->branch_id)
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        // Fetch active categories
        $categories = ExpenseCategory::where('status', 'on')->get();

        // Fetch branches
        if ($user->access_type === 'Super Admin') {
            $branches = Branch::where('status', 'on')->get();
        } else {
            $branches = Branch::where('id', $user->branch_id)->get();
        }

        // Fetch banks
        if ($user->access_type === 'Super Admin') {
            $banks = Bank::where('status', 'on')->get();
        } else {
            $banks = Bank::where('branch_id', $user->branch_id)
                ->where('status', 'on')
                ->get();
        }

        return view('expenses::expenses.index', compact('expenses', 'categories', 'branches', 'banks'));
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('expenses::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $image = '';
        if ($request->hasFile('receipt')) {
            $image = time() . '.' . $request->receipt->extension();
            $request->receipt->move(public_path('upload/images/expenses-receipt'), $image);
        }

        $branchId = $request->branchId ?? auth()->user()->branch_id;

        // Save the expense
        $expense = new Expenses();
        $expense->expense_category_id = $request->categoryId;
        $expense->title = $request->title;
        $expense->amount = $request->amount;
        $expense->bank_id = $request->bank_id;
        $expense->branch_id = $branchId;
        $expense->created_by = auth()->user()->id;
        $expense->date = $request->date;
        $expense->mode = $request->mode;
        $expense->description = $request->description;
        $expense->status = 'on';
        $expense->receipt = $image;
        $expense->save();

        if (in_array($request->mode, ['cheque', 'online'])) {
            // 🟢 Bank logic
            $bank = Bank::where('id', $request->bank_id)
                ->where('branch_id', $branchId)
                ->first();

            if (!$bank) {
                return back()->with('error', 'Selected bank not found for this branch!');
            }

            if ((float)$request->amount > (float)$bank->closing_amount) {
                return back()->with('error', 'Not enough balance in the selected bank!');
            }

            $before = $bank->closing_amount;
            $after  = $before - (float)$request->amount;

            // Update bank balance
            $bank->closing_amount = $after;
            $bank->save();
        } elseif ($request->mode === 'cash') {
            // 🟢 Cash Counter branch specific
            $cashCounter = CashCounter::where('branch_id', $branchId)->first();

            if (!$cashCounter) {
                return back()->with('error', 'Cash counter not found for this branch!');
            }

            if ($request->amount > (float)$cashCounter->due_amount) {
                return back()->with('error', 'Insufficient cash in counter!');
            }

            // Update due_amount and reduce_amount
            $cashCounter->due_amount    -= $request->amount;
            $cashCounter->reduce_amount = ($cashCounter->reduce_amount ?? 0) + $request->amount;
            $cashCounter->save();
        }

        return back()->with('success', 'Expense Added Successfully');
    }





    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('expenses::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('expenses::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    //
    public function update(Request $request, $id)
    {
        $expense = Expenses::findOrFail($id);

        // Handle receipt upload
        $image = $expense->receipt;
        if ($request->hasFile('receipt')) {
            $image = time() . '.' . $request->receipt->extension();
            $request->receipt->move(public_path('upload/images/expenses-receipt'), $image);
        }

        $branchId = $request->branchId ?? $expense->branch_id;

        // 🔄 Restore old balance first (before updating new values)
        if (in_array($expense->mode, ['cheque', 'online'])) {
            $oldBank = Bank::where('id', $expense->bank_id)
                ->where('branch_id', $expense->branch_id)
                ->first();

            if ($oldBank) {
                $oldBank->closing_amount += (float)$expense->amount;
                $oldBank->save();
            }
        } elseif ($expense->mode === 'cash') {
            $cashCounter = CashCounter::where('branch_id', $expense->branch_id)->first();
            if ($cashCounter) {
                $cashCounter->due_amount    += (float)$expense->amount;
                $cashCounter->reduce_amount = max(0, ($cashCounter->reduce_amount ?? 0) - (float)$expense->amount);
                $cashCounter->save();
            }
        }

        // ✅ Update expense fields
        $bankId = in_array($request->mode, ['online', 'cheque']) ? $request->bank_id : null;

        $expense->update([
            'expense_category_id' => $request->categoryId,
            'title'       => $request->title,
            'amount'      => $request->amount,
            'bank_id'     => $bankId,
            'branch_id'   => $branchId,
            'created_by'  => auth()->user()->id,
            'date'        => $request->date,
            'mode'        => $request->mode,
            'description' => $request->description,
            'status'      => 'on',
            'receipt'     => $image,
        ]);

        // ✅ Apply new balance changes (after update)
        if (in_array($request->mode, ['cheque', 'online'])) {
            $bank = Bank::where('id', $request->bank_id)
                ->where('branch_id', $branchId)
                ->first();

            if (!$bank) {
                return back()->with('error', 'Selected bank not found for this branch!');
            }
            if ((float)$request->amount > (float)$bank->closing_amount) {
                return back()->with('error', 'Not enough balance in the selected bank!');
            }

            $bank->closing_amount -= (float)$request->amount;
            $bank->save();
        } elseif ($request->mode === 'cash') {
            $cashCounter = CashCounter::where('branch_id', $branchId)->first();

            if (!$cashCounter) {
                return back()->with('error', 'Cash counter not found for this branch!');
            }
            if ($request->amount > (float)$cashCounter->due_amount) {
                return back()->with('error', 'Insufficient cash in counter!');
            }

            $cashCounter->due_amount    -= (float)$request->amount;
            $cashCounter->reduce_amount = ($cashCounter->reduce_amount ?? 0) + (float)$request->amount;
            $cashCounter->save();
        }

        return back()->with('success', 'Expense Updated Successfully');
    }



    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $expense = Expenses::findOrFail($id);

        // Reverse petty cash if mode was 'petty cash'
        if ($expense->mode === 'petty cash') {
            $pettyCash = PettyCashAdd::where('branch_id', $expense->branch_id)->first();
            if ($pettyCash) {
                $pettyCash->remaining_cash += (float)$expense->amount;
                $pettyCash->save();
            }

            // Delete associated petty cash transaction
            PettyCashTransaction::where('reference_id', $expense->id)
                ->where('type', 'expense')
                ->delete();
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Expense Deleted!');
    }


    public function Status($id)
    {
        $categorys = Expenses::findOrfail($id);
        if ($categorys->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $categorys->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Expense Status Updated!');
    }
    public function getExpense(Request $request)
    {
        $expenses = Expenses::all();

        return response()->json($expenses);
    }

    public function getBanksByBranch($branchId)
    {
        $banks = Bank::where('branch_id', $branchId)
            ->where('status', 'on')
            ->select('id', 'bank_name', 'closing_amount')
            ->get();

        return response()->json($banks);
    }
}
