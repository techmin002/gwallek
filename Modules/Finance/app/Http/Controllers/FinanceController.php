<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Branch\Entities\Branch;
use Modules\Expenses\Entities\Expenses;
use Modules\Finance\Models\Bank;
use Modules\Finance\Models\CashCounter;
use Modules\Finance\Models\CashDeposit;
use Modules\ProjectManager\Models\Site;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // dd('hello');
        $sites = Site::with('payment')
            ->whereHas('payment', function ($q) {
                $q->where('due_amount', '>', 0);
            })
            ->get();

        return view('finance::site.index', compact('sites'));
    }

    public function cashcounter()
    {
        $counter = CashCounter::first();

        if (auth()->user()->access_type === 'Super Admin') {
            $branches = Branch::where('status', 'on')->get();
            $banks = Bank::where('status', 'on')->get(); // initially all banks
        } else {
            $branches = Branch::where('id', auth()->user()->branch_id)->get();
            $banks = Bank::where('status', 'on')
                ->where('branch_id', auth()->user()->branch_id)
                ->get();
        }



        $data = CashDeposit::with('bank')->get();
        $grandTotal = $data->sum('amount');

        $today = Carbon::today()->toDateString();
        $todayCollection = CashDeposit::whereDate('date', $today)->sum('amount');

        $expenses = Expenses::with('category')
            ->where('mode', 'cash')
            ->get();

        return view('finance::cash_counter.index', compact('counter', 'branches', 'banks','data', 'grandTotal', 'todayCollection', 'expenses'));
    }


    public function deposite(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'branch_id' => 'required|exists:branches,id',
            'bank_id' => 'required|exists:banks,id',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);
        // dd("hello");
        $imagePath = null;

        // Handle image upload if it exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('upload/images/deposits'), $imageName);
            $imagePath = $imageName;
        }

        $cashCounter = CashCounter::latest()->first();

        if (!$cashCounter) {
            return back()->with('error', 'Cash counter not found!');
        }

        $amount = $request->amount;
        // Reduce amount from due amount
        $cashCounter->due_amount = $cashCounter->due_amount - $amount;
        // Update reduce column
        $cashCounter->reduce_amount = ($cashCounter->reduce_amount ?? 0) + $amount;
        $cashCounter->save();

        CashDeposit::create([
            'amount' => $validated['amount'],
            'branch_id' => $validated['branch_id'],
            'bank_id' => $validated['bank_id'],
            'date' => $validated['date'],
            'image' => $imagePath,
        ]);

        $bank = Bank::find($validated['bank_id']);

        if ($bank) {
            if ($bank->closing_amount > 0) {
                $bank->closing_amount = $bank->closing_amount + $amount;
            } else {
                $bank->closing_amount = ($bank->opening_amount ?? 0) + $amount;
            }

            $bank->save();
        }
        return back()->with('success', 'Amount deposited successfully!');
    }

    public function depositedetails()
    {
        $data = CashDeposit::with('bank')->get();
        $grandTotal = $data->sum('amount');

        $today = Carbon::today()->toDateString();
        $todayCollection = CashDeposit::whereDate('date', $today)->sum('amount');

        $expenses = Expenses::with('category')
            ->where('mode', 'cash')
            ->get();

        return view('finance::cash_counter.depositdetails', compact('data', 'grandTotal', 'todayCollection', 'expenses'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('finance::show');
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
    public function destroy($id) {}


    public function getBanks($branchId)
    {
        $banks = Bank::where('branch_id', $branchId)->where('status', 'on')->get();
        return response()->json($banks);
    }
}
