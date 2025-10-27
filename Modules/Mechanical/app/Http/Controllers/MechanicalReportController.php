<?php

namespace Modules\Mechanical\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branch\Entities\Branch;
use Modules\Mechanical\Models\Mechanical;
use Modules\Mechanical\Models\MechanicalCategory;
use Modules\Mechanical\Models\MechanicalExpense;

class MechanicalReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->access_type == 'Super Admin') {
            $mechanicals = Mechanical::with(['category', 'branch'])->latest()->get();
            $branches = Branch::all();
        } else {
            $mechanicals = Mechanical::with(['category', 'branch'])
                ->where('branch_id', auth()->user()->branch_id)
                ->latest()
                ->get();
            $branches = Branch::where('id', auth()->user()->branch_id)->get();
        }

        $categories = MechanicalCategory::where('status', 'on')->get();

        return view('mechanical::report.index', compact('mechanicals', 'categories', 'branches'));
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
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // Mechanical with branch info
        $mechanical = Mechanical::with(['branch', 'category'])->findOrFail($id);

        // Get all expenses of this mechanical with products
        $expenses = MechanicalExpense::where('mechanical_id', $id)
            ->with(['products', 'mechanical.branch'])
            ->latest()
            ->get();

        if ($expenses->isEmpty()) {
            return redirect()->back()->with('error', 'No expenses found for this mechanical.');
        }

        // Calculate grand total of all expenses
        $grandTotal = $expenses->sum('amount');

        return view('mechanical::report.details', compact('mechanical', 'expenses', 'grandTotal'));
    }


    public function expenseShow($id)
    {
        $expense = MechanicalExpense::with('products')->findOrFail($id);

        return view('mechanical::report.expense_details', compact('expense'));
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
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
