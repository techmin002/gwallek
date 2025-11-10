<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Branch\Entities\Branch;
use Modules\Inventory\Entities\Inventory;
use Modules\Product\Models\Product;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $query = Inventory::with([
            'product:id,name',
            'branch:id,name',
            'user:id,name'
        ])->latest();

        // Super admin (id = 1) ko sab dikhna hai
        if ($user->id != 1) {
            // Baaki users ko sirf apni branch ka data
            $query->where('branch_id', $user->branch_id);
        }

        $inventories = $query->get();

        return view('inventory::inventories.index', compact('inventories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('inventory::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inventory = Inventory::with('product', 'branch', 'user')->findOrFail($id);

        $products = Product::pluck('name', 'id');
        $branches = Branch::pluck('name', 'id');

        return view('inventory::inventories.edit', compact('inventory', 'products', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'branch_id' => 'required|exists:branches,id',
            'quantity' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        $inventory = Inventory::findOrFail($id);

        $inventory->update([
            'product_id' => $request->product_id,
            'branch_id' => $request->branch_id,
            'quantity' => $request->quantity,
            'status' => $request->status,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->delete();

        return redirect()->route('inventories.index')
            ->with('success', 'Inventory deleted successfully.');
    }
}
