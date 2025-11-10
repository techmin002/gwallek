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
        $query = Site::with('payment')
            ->whereHas('payment', function ($q) {
                $q->where('due_amount', '>', 0);
            });

        if (auth()->user()->access_type !== 'Super Admin') {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        $sites = $query->get();

        return view('finance::site.index', compact('sites'));
    }


    public function cashcounter(Request $request)
    {
        $branchId = $request->branch_id ?? auth()->user()->branch_id;

        // 🟢 Get Cash Counter branch-wise
        $counter = CashCounter::where('branch_id', $branchId)->first();

        if (auth()->user()->access_type === 'Super Admin') {
            // Super Admin ko sab branches dikhengi
            $branches = Branch::where('status', 'on')->get();

            // 🟢 Super Admin ke liye banks bhi branch filter ke saath
            $banks = Bank::where('status', 'on')
                ->where('branch_id', $branchId)
                ->get();
        } else {
            // Normal user ko sirf uski branch
            $branches = Branch::where('id', $branchId)
                ->where('status', 'on')
                ->get();

            $banks = Bank::where('status', 'on')
                ->where('branch_id', $branchId)
                ->get();
        }

        // 🟢 Cash Deposits branch wise
        $data = CashDeposit::with(['bank', 'branch'])
            ->where('branch_id', $branchId)
            ->get();

        $grandTotal = $data->sum('amount');

        $today = Carbon::today()->toDateString();
        $todayCollection = CashDeposit::where('branch_id', $branchId)
            ->whereDate('date', $today)
            ->sum('amount');

        $expenses = Expenses::with('category')
            ->where('mode', 'cash')
            ->where('branch_id', $branchId)
            ->get();

        return view('finance::cash_counter.index', compact(
            'counter',
            'branches',
            'banks',
            'data',
            'grandTotal',
            'todayCollection',
            'expenses',
            'branchId'
        ));
    }




    public function deposite(Request $request)
    {
        $validated = $request->validate([
            'amount'    => 'required|numeric|min:1',
            'branch_id' => 'required|exists:branches,id',
            'bank_id'   => 'required|exists:banks,id',
            'date'      => 'required|date',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $imagePath = null;

        // Handle image upload if it exists
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('upload/images/deposits'), $imageName);
            $imagePath = $imageName;
        }

        // 🟢 Branch-wise Cash Counter fetch
        $cashCounter = CashCounter::where('branch_id', $validated['branch_id'])->latest()->first();

        if (!$cashCounter) {
            return back()->with('error', 'Cash counter not found for this branch!');
        }

        $amount = $validated['amount'];

        // Reduce amount from due_amount
        $cashCounter->due_amount = $cashCounter->due_amount - $amount;

        // Update reduce column
        $cashCounter->reduce_amount = ($cashCounter->reduce_amount ?? 0) + $amount;
        $cashCounter->save();

        // Store deposit
        CashDeposit::create([
            'amount'    => $validated['amount'],
            'branch_id' => $validated['branch_id'],
            'bank_id'   => $validated['bank_id'],
            'date'      => $validated['date'],
            'image'     => $imagePath,
        ]);

        // Update Bank Closing Amount
        $bank = Bank::find($validated['bank_id']);
        if ($bank) {
            if ($bank->closing_amount > 0) {
                $bank->closing_amount = $bank->closing_amount + $amount;
            } else {
                $bank->closing_amount = ($bank->opening_amount ?? 0) + $amount;
            }
            $bank->save();
        }

        return back()->with('success', 'Amount deposited successfully for branch!');
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
