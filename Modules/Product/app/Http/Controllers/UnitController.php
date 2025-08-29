<?php

namespace Modules\Product\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Product\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::latest()->get();
        return view('product::units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
            'description' => 'nullable|string',
            'status' => 'nullable|in:on,off',
        ]);

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->status = $request->status ?? 'off';
        $unit->save();

        return redirect()->back()->with('success', 'Unit created successfully!');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        return view('product::units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $id,
            'description' => 'nullable|string',
            'status' => 'nullable|in:on,off',
        ]);

        $unit = Unit::findOrFail($id);
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->status = $request->status ?? 'off';
        $unit->save();

        return redirect()->route('units.index')->with('success', 'Unit updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->back()->with('success', 'Unit deleted successfully!');
    }

    public function status($id)
    {
        $unit = Unit::findOrFail($id);

        // Toggle status
        $unit->status = $unit->status === 'on' ? 'off' : 'on';
        $unit->save();

        return redirect()->back()->with('success', 'Unit status updated successfully!');
    }
}
