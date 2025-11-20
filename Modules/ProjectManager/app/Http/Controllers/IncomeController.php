<?php

namespace Modules\ProjectManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ProjectManager\Models\Income;
use Modules\ProjectManager\Models\Site;

class IncomeController extends Controller
{
   public function index(Request $request)
{
    $projects = Site::all(); // for dropdown filter

    $query = Income::with('site');

    // Filter by project if selected
    if ($request->filled('site_id')) {
        $query->where('site_id', $request->site_id);
        $selectedProject = Site::find($request->site_id);
        $totalProjectCost = $selectedProject->amount ?? 0;
        $totalIncome = $query->sum('amount');
        $totalRemaining = $totalProjectCost - $totalIncome;
    } else {
        $selectedProject = null;
        $totalProjectCost = Site::sum('amount');
        $totalIncome = $query->sum('amount');
        $totalRemaining = $totalProjectCost - $totalIncome;
    }

    $incomes = $query->latest()->get();

    return view('projectmanager::income.index', compact(
        'incomes', 
        'projects', 
        'totalProjectCost', 
        'totalIncome', 
        'totalRemaining',
        'selectedProject'
    ));
}


    public function create()
    {
        $sites = Site::all();
        return view('projectmanager::income.create', compact('sites'));
    }

   public function store(Request $request)
{
    $request->validate([
        'site_id' => 'required|exists:sites,id',
        'title' => 'required|string',
        'amount' => 'required|numeric',
        'received_date' => 'required|date',
        'receipt_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->all();

    if ($request->hasFile('receipt_image')) {
        $filename = time() . '-' . $request->receipt_image->getClientOriginalName();
        $request->receipt_image->move(public_path('uploads/receipts'), $filename);
        $data['receipt_image'] = $filename;
    }

    Income::create($data);

    return redirect()->route('incomes.index')->with('success', 'Income Added Successfully.');
}


    public function edit(Income $income)
    {
        $sites = Site::all();
        return view('projectmanager::income.edit', compact('income', 'sites'));
    }

   public function update(Request $request, Income $income)
{
    $request->validate([
        'site_id' => 'required|exists:sites,id',
        'title' => 'required|string',
        'amount' => 'required|numeric',
        'received_date' => 'required|date',
        'receipt_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $data = $request->all();

    if ($request->hasFile('receipt_image')) {

        // delete old file
        if ($income->receipt_image && file_exists(public_path('uploads/receipts/'.$income->receipt_image))) {
            unlink(public_path('uploads/receipts/'.$income->receipt_image));
        }

        $filename = time() . '-' . $request->receipt_image->getClientOriginalName();
        $request->receipt_image->move(public_path('uploads/receipts'), $filename);
        $data['receipt_image'] = $filename;
    }

    $income->update($data);

    return redirect()->route('incomes.index')->with('success', 'Income Updated Successfully.');
}


    public function destroy(Income $income)
    {
        $income->delete();
        return redirect()->back()->with('success', 'Income Deleted.');
    }
}