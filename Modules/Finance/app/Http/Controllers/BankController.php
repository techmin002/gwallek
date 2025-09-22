<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Branch\Entities\Branch;
use Modules\Expenses\Entities\Expenses;
use Modules\Finance\Models\Bank;
use Modules\Finance\Models\CashDeposit;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banks = Bank::with('branch')->get();
        $branches = Branch::where('status', 'on')->get();
        return view('finance::bank.index', compact('banks', 'branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::bank.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // ✅ Validation
        $request->validate([
            'bank_name'        => 'required|string|max:255',
            'bank_holder_name' => 'required|string|max:255',
            'account_number'   => 'required|string|max:50|unique:banks,account_number',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'mobile_no'        => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
            'opening_amount'   => 'required|numeric|min:0',
            'status'           => 'nullable|string|in:on,off',
        ]);

        // ✅ Store
        Bank::create([
            'bank_name'        => $request->bank_name,
            'bank_holder_name' => $request->bank_holder_name,
            'account_number'   => $request->account_number,
            'branch_id'           => $request->branch_id,
            'mobile_no'        => $request->mobile_no,
            'address'          => $request->address,
            'opening_amount'   => $request->opening_amount,
            'closing_amount'   => 0,
            'status'           => $request->status ?? 'inactive',
        ]);

        return redirect()->back()->with('success', 'Bank created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // dd('sdfsdfsd');
        $today = Carbon::today()->toDateString();

        $bank = Bank::findOrFail($id);
        // dd($bank->bank_name);
        $deposits = CashDeposit::where('bank_id', $id)->get();
        $grandTotal = $deposits->sum('amount');

        $OpeningAmount = $bank->opening_amount;
        $ClosingAmount = $bank->closing_amount;

        $todayCollection = CashDeposit::where('bank_id', $id)
            ->whereDate('date', $today)
            ->sum('amount');

        $expenses = Expenses::with('category')->where('bank_id', $id)->get();

        return view('finance::bank.details', compact(
            'deposits',
            'grandTotal',
            'todayCollection',
            'OpeningAmount',
            'ClosingAmount',
            'bank',
            'expenses'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        $bank->delete();

        return back()->with('success', 'Bank deleted successfully!');
    }

    public function status($id)
    {
        $bank = Bank::findOrFail($id);

        // Toggle status
        $bank->status = ($bank->status === 'on') ? 'off' : 'on';
        $bank->save();

        return back()->with('success', 'Bank status updated successfully!');
    }
}
