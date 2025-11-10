<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\DevicePurchase;
use Modules\Inventory\Entities\DevicePurchaseAccessory;
use Modules\Inventory\Entities\DevicePurchaseMachinery;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Machineries;
use Modules\Inventory\Entities\Supplier;
use Modules\Inventory\Entities\Branch;
use Modules\Inventory\Entities\User;
use Modules\Inventory\Entities\DevicePurchaseProduct;
use Modules\Product\Models\Product;

class DevicePurchaseController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $suppliers = Supplier::all();
        $branches = Branch::all();
        $users = User::all();
        $products = Product::all();

        $query = DevicePurchase::with('supplier');

        // Branch filter
        if ($user->name !== 'Super Admin' && $user->branch_id) {
            $query->where('branch_id', $user->branch_id);
        }

        $devicepurchases = $query->get();

        return view('inventory::DevicePurchase.index', compact(
            'devicepurchases',
            'suppliers',
            'branches',
            'users',
            'products'
        ));
    }



    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'bill_no' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required|boolean',
            'description' => 'nullable|string',

            'products' => 'required|array|min:1',
            'products.*product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.total' => 'required|numeric|min:0',
        ]);

        // dd($request->all());
        DB::transaction(function () use ($request) {
            $receiptPath = null;
            if ($request->hasFile('receipt')) {
                $imageName = time() . '.' . $request->receipt->extension();
                $request->receipt->move(public_path('upload/images/receipts'), $imageName);
                $receiptPath = 'upload/images/receipts/' . $imageName;
            }

            // Create Device Purchase
            $devicePurchase = DevicePurchase::create([
                'supplier_id' => $request->supplier_id,
                'branch_id' => $request->branch_id,
                'bill_no' => $request->bill_no,
                'total_amount' => $request->total_amount,
                'receipt' => $receiptPath,
                'status' => $request->status,
                'description' => $request->description,
                'created_by' => auth()->id(),
            ]);

            // Save Products
            foreach ($request->products as $prod) {
                $productPurchase = DevicePurchaseProduct::create([
                    'device_purchase_id' => $devicePurchase->id,
                    'product_id' => $prod['product_id'],
                    'quantity' => $prod['quantity'],
                    'unit_price' => $prod['price'],
                    'total' => $prod['total'],
                ]);

                // Update Inventory
                $inventory = Inventory::firstOrNew([
                    'product_id' => $prod['product_id'],
                    'branch_id' => $request->branch_id,
                ]);

                // Opening qty update
                $inventory->opening_quantity = ($inventory->opening_quantity ?? 0) + $prod['quantity'];

                // Current stock update
                if ($inventory->exists) {
                    $inventory->quantity += $prod['quantity'];
                } else {
                    $inventory->quantity = $prod['quantity'];
                    $inventory->status = true;
                }

                $inventory->updated_by = auth()->id();
                $inventory->save();
            }
        });

        return back()->with('success', 'Device purchase stored successfully.');
    }


    public function edit(DevicePurchase $devicePurchase)
    {
        $devicePurchase->load('accessories', 'machineries');

        $suppliers = Supplier::all();
        $branches = Branch::all();
        $users = User::all();
        $products = Product::all();
        $purchaseproduct = DevicePurchaseProduct::where('device_purchase_id', $devicePurchase->id)->with('product')->get();

        return view('inventory::DevicePurchase.edit', compact(
            'devicePurchase',
            'suppliers',
            'branches',
            'users',
            'purchaseproduct',
            'products'
        ));
    }

    public function update(Request $request, DevicePurchase $devicePurchase): RedirectResponse
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'bill_no' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'status' => 'required|boolean',
            'description' => 'nullable|string',

            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'products.*.total' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $devicePurchase) {
            // ✅ Handle receipt update
            $receiptPath = $devicePurchase->receipt;
            if ($request->hasFile('receipt')) {
                if ($receiptPath && file_exists(public_path($receiptPath))) {
                    unlink(public_path($receiptPath));
                }
                $imageName = time() . '.' . $request->receipt->extension();
                $request->receipt->move(public_path('upload/images/receipts'), $imageName);
                $receiptPath = 'upload/images/receipts/' . $imageName;
            }

            // ✅ Update Device Purchase main data
            $devicePurchase->update([
                'supplier_id' => $request->supplier_id,
                'branch_id' => $request->branch_id,
                'bill_no' => $request->bill_no,
                'total_amount' => $request->total_amount,
                'receipt' => $receiptPath,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            // ✅ Reset old products & adjust inventory
            $oldProducts = DevicePurchaseProduct::where('device_purchase_id', $devicePurchase->id)->get();
            foreach ($oldProducts as $old) {
                $inventory = Inventory::where('product_id', $old->product_id)
                    ->where('branch_id', $old->branch_id ?? $devicePurchase->branch_id)
                    ->first();
                if ($inventory) {
                    $inventory->opening_quantity -= $old->quantity;
                    $inventory->quantity -= $old->quantity;
                    $inventory->save();
                }
            }
            DevicePurchaseProduct::where('device_purchase_id', $devicePurchase->id)->delete();

            // ✅ Insert new products & adjust inventory
            foreach ($request->products as $prod) {
                DevicePurchaseProduct::create([
                    'device_purchase_id' => $devicePurchase->id,
                    'product_id' => $prod['product_id'],
                    'quantity' => $prod['quantity'],
                    'unit_price' => $prod['price'],
                    'total' => $prod['total'],
                    'branch_id' => $prod['branch_id'] ?? $request->branch_id,
                ]);

                $inventory = Inventory::firstOrNew([
                    'product_id' => $prod['product_id'],
                    'branch_id' => $prod['branch_id'] ?? $request->branch_id,
                ]);

                if ($inventory->exists) {
                    $inventory->opening_quantity += $prod['quantity'];
                    $inventory->quantity += $prod['quantity'];
                } else {
                    $inventory->opening_quantity = $prod['quantity'];
                    $inventory->quantity = $prod['quantity'];
                    $inventory->status = true;
                }

                $inventory->updated_by = auth()->id();
                $inventory->save();
            }
        });

        return redirect()->route('device-purchases.index')->with('success', 'Device purchase updated successfully.');
    }


    public function destroy(DevicePurchase $devicePurchase): RedirectResponse
    {
        DB::transaction(function () use ($devicePurchase) {
            // Get all related products
            $products = DevicePurchaseProduct::where('device_purchase_id', $devicePurchase->id)->get();

            foreach ($products as $product) {
                $inventory = Inventory::where('product_id', $product->product_id)
                    ->where('branch_id', $devicePurchase->branch_id)
                    ->first();

                if ($inventory) {
                    $inventory->quantity -= $product->quantity;

                    if ($inventory->quantity < 0) {
                        $inventory->quantity = 0;
                    }

                    $inventory->save();
                }
            }

            // Delete receipt file if exists
            if ($devicePurchase->receipt && file_exists(public_path($devicePurchase->receipt))) {
                unlink(public_path($devicePurchase->receipt));
            }

            // Delete related products
            DevicePurchaseProduct::where('device_purchase_id', $devicePurchase->id)->delete();

            // Delete the device purchase record
            $devicePurchase->delete();
        });

        return redirect()->route('device-purchases.index')->with('success', 'Device purchase deleted successfully.');
    }


    public function showproducts($id)
    {
        $purchase = DevicePurchase::with(['supplier'])->findOrFail($id);

        $products = DevicePurchaseProduct::with(['product', 'branch'])
            ->where('device_purchase_id', $id)
            ->get();

        return view('inventory::DevicePurchase.show_products', [
            'supplier' => $purchase->supplier,
            'bill_no' => $purchase->bill_no,
            'products' => $products,
        ]);
    }


    public function getInventories()
    {
        $user = auth()->user();

        $query = Inventory::with([
            'product:id,name',
            'branch:id,name',
            'user:id,name'
        ])->latest();

        if ($user->branch_id) {
            $query->where('branch_id', $user->branch_id);
        }

        $inventories = $query->get();

        return view('inventory::inventories.index', compact('inventories'));
    }
}
