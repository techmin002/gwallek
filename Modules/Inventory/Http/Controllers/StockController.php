<?php

namespace Modules\Inventory\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\StockTransfer;
use Modules\Inventory\Entities\Branch;
use Modules\Inventory\Entities\Accessories;
use Modules\Inventory\Entities\Machineries;
use Modules\Inventory\Entities\StockTransferAccessories;
use Modules\Inventory\Entities\StockTransferMachineries;
use Modules\Inventory\Entities\Inventory;
use Modules\Inventory\Entities\User;
use Illuminate\Validation\ValidationException;
use Modules\Product\Models\Product;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $branches = Branch::all();
        $user = User::all();
        $stockTransfers = StockTransfer::with(['products', 'fromBranch', 'toBranch', 'creator'])->get();
        return view('inventory::stocktransfer.index', compact(
            'stockTransfers',
            'branches',
            'products',
            'user'
        ));
    }


    public function store(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'from_branch_id' => 'required|exists:branches,id',
                'to_branch_id'   => 'required|exists:branches,id|different:from_branch_id',
                'transfer_date'  => 'required|date',
                'remarks'        => 'nullable|string',
                'products'       => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity'   => 'required|integer|min:1',
                'products.*.serial_numbers' => 'nullable|string',
                'products.*.condition'  => 'required|in:new,used,refurbished,damaged',
            ]);

            // ✅ Stock availability check (still keeping)
            foreach ($validated['products'] as $product) {
                $inventory = Inventory::where('branch_id', $validated['from_branch_id'])
                    ->where('product_id', $product['product_id'])
                    ->first();

                if (!$inventory || $inventory->quantity < $product['quantity']) {
                    $productName = Product::find($product['product_id'])->name ?? 'Unknown Product';
                    $branchName  = Branch::find($validated['from_branch_id'])->name ?? 'Unknown Branch';
                    throw new \Exception("Not enough stock for {$productName} in {$branchName}");
                }
            }

            DB::beginTransaction();

            // ✅ Create the stock transfer
            $stockTransfer = StockTransfer::create([
                'from_branch_id' => $validated['from_branch_id'],
                'to_branch_id'   => $validated['to_branch_id'],
                'transfer_date'  => $validated['transfer_date'],
                'status'         => 'pending',
                'remarks'        => $validated['remarks'] ?? null,
                'created_by'     => Auth::id(),
            ]);

            // ✅ Attach products to stock transfer (no inventory changes)
            foreach ($validated['products'] as $product) {
                $stockTransfer->products()->attach($product['product_id'], [
                    'quantity'       => $product['quantity'],
                    'serial_numbers' => $product['serial_numbers'] ?? null,
                    'condition'      => $product['condition'],
                ]);
            }

            DB::commit();

            return redirect()->route('stock-transfers.index')
                ->with('success', 'Stock transfer created successfully!');
        } catch (ValidationException $e) {
            return redirect()->route('stock-transfers.index')
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('stock-transfers.index')
                ->with('error', 'Error creating stock transfer: ' . $e->getMessage())
                ->withInput();
        }
    }


    protected function validateStockAvailability($validatedData)
    {
        $errors = [];

        // Check accessories stock
        if (!empty($validatedData['accessories'])) {
            foreach ($validatedData['accessories'] as $index => $accessory) {
                $availableQuantity = $this->getAvailableAccessoryQuantity(
                    $accessory['accessory_id'],
                    $validatedData['from_branch_id']
                );

                if ($accessory['quantity'] > $availableQuantity) {
                    $accessoryName = Accessories::find($accessory['accessory_id'])->name;
                    $errors["accessories.$index.quantity"] = "Insufficient stock for $accessoryName. Available: $availableQuantity";
                }
            }
        }

        // Check machinery stock
        if (!empty($validatedData['machineries'])) {
            foreach ($validatedData['machineries'] as $index => $machinery) {
                $availableQuantity = $this->getAvailableMachineryQuantity(
                    $machinery['machinery_id'],
                    $validatedData['from_branch_id']
                );

                if ($machinery['quantity'] > $availableQuantity) {
                    $machineryName = Machineries::find($machinery['machinery_id'])->name;
                    $errors["machineries.$index.quantity"] = "Insufficient stock for $machineryName. Available: $availableQuantity";
                }
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    protected function getAvailableAccessoryQuantity($accessoryId, $branchId)
    {
        return Inventory::where('accessory_id', $accessoryId)
            ->where('branch_id', $branchId)
            ->value('quantity') ?? 0;
    }

    protected function getAvailableMachineryQuantity($machineryId, $branchId)
    {
        return Inventory::where('machinery_id', $machineryId)
            ->where('branch_id', $branchId)
            ->value('quantity') ?? 0;
    }

    protected function createTransferAccessory(StockTransfer $stockTransfer, array $accessoryData)
    {
        return StockTransferAccessories::create([
            'stock_transfer_id' => $stockTransfer->id,
            'accessory_id' => $accessoryData['accessory_id'],
            'quantity' => $accessoryData['quantity'],
            'serial_numbers' => $accessoryData['serial_numbers'] ?? null,
            'condition' => $accessoryData['condition'],
        ]);
    }

    protected function createTransferMachinery(StockTransfer $stockTransfer, array $machineryData)
    {
        return StockTransferMachineries::create([
            'stock_transfer_id' => $stockTransfer->id,
            'machinery_id' => $machineryData['machinery_id'],
            'quantity' => $machineryData['quantity'],
            'serial_numbers' => $machineryData['serial_numbers'] ?? null,
            'condition' => $machineryData['condition'],
        ]);
    }

    protected function updateInventory(?int $machineryId, ?int $accessoryId, int $branchId, int $quantityChange)
    {
        $inventory = Inventory::firstOrNew([
            'machinery_id' => $machineryId,
            'accessory_id' => $accessoryId,
            'branch_id' => $branchId,
        ]);

        if (!$inventory->exists) {
            $inventory->opening_quantity = 0;
            $inventory->quantity = 0;
        }

        $inventory->quantity += $quantityChange;

        if ($inventory->quantity < 0) {
            throw new \Exception("Insufficient stock for transfer");
        }

        $inventory->updated_by = Auth::id();
        $inventory->save();
    }

    // public function updateStatus(Request $request, StockTransfer $stockTransfer)
    // {
    //     $request->validate([
    //         'status' => 'required|in:pending,in_transit,completed,cancelled'
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $oldStatus = $stockTransfer->status;
    //         $newStatus = $request->status;

    //         $stockTransfer->update([
    //             'status' => $newStatus,
    //             'updated_by' => Auth::id()
    //         ]);

    //         // Handle inventory changes based on status
    //         if ($oldStatus !== $newStatus) {
    //             if ($newStatus === 'completed') {
    //                 // Add to destination branch
    //                 $this->processStatusChange($stockTransfer, $stockTransfer->to_branch_id, 1);
    //             } elseif ($newStatus === 'cancelled' && $oldStatus !== 'completed') {
    //                 // Return to source branch
    //                 $this->processStatusChange($stockTransfer, $stockTransfer->from_branch_id, 1);
    //             } elseif ($oldStatus === 'completed' && $newStatus !== 'completed') {
    //                 // Reverse from destination branch
    //                 $this->processStatusChange($stockTransfer, $stockTransfer->to_branch_id, -1);
    //             }
    //         }

    //         DB::commit();

    //         return back()->with('success', 'Status updated successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->with('error', 'Error updating status: ' . $e->getMessage());
    //     }
    // }

    protected function processStatusChange(StockTransfer $stockTransfer, int $branchId, int $multiplier)
    {
        // Process accessories
        foreach ($stockTransfer->accessories as $accessory) {
            $this->updateInventory(
                null,
                $accessory->accessory_id,
                $branchId,
                $accessory->quantity * $multiplier
            );
        }

        // Process machineries
        foreach ($stockTransfer->machineries as $machinery) {
            $this->updateInventory(
                $machinery->machinery_id,
                null,
                $branchId,
                $machinery->quantity * $multiplier
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'from_branch_id' => 'required|exists:branches,id',
                'to_branch_id'   => 'required|exists:branches,id|different:from_branch_id',
                'transfer_date'  => 'required|date',
                'remarks'        => 'nullable|string',
                'products'       => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity'   => 'required|integer|min:1',
                'products.*.serial_numbers' => 'nullable|string',
                'products.*.condition'  => 'required|in:new,used,refurbished,damaged',
            ], [
                'to_branch_id.different' => 'From branch and To branch must be different.',
            ]);

            DB::beginTransaction();

            $stockTransfer = StockTransfer::findOrFail($id);

            // ✅ Update stock transfer
            $stockTransfer->update([
                'from_branch_id' => $validated['from_branch_id'],
                'to_branch_id'   => $validated['to_branch_id'],
                'transfer_date'  => $validated['transfer_date'],
                'remarks'        => $validated['remarks'] ?? null,
                'updated_by'     => Auth::id(),
            ]);

            // ✅ Purane products hatao
            $stockTransfer->products()->detach();

            // ✅ Naye products add karo
            foreach ($validated['products'] as $product) {
                $stockTransfer->products()->attach($product['product_id'], [
                    'quantity'       => $product['quantity'],
                    'serial_numbers' => $product['serial_numbers'] ?? null,
                    'condition'      => $product['condition'],
                ]);
            }

            DB::commit();

            return redirect()->route('stock-transfers.index')
                ->with('success', 'Stock transfer updated successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating stock transfer: ' . $e->getMessage())
                ->withInput();
        }
    }




    protected function validateStockUpdate(StockTransfer $transfer, array $data)
    {
        $errors = [];
        $fromBranchId = $data['from_branch_id'];

        if (isset($data['accessories'])) {
            foreach ($data['accessories'] as $index => $accessory) {
                $originalQuantity = $transfer->accessories->where('id', $accessory['id'])->first()->pivot->quantity ?? 0;
                $quantityChange = $accessory['quantity'] - $originalQuantity;

                if ($quantityChange > 0) {
                    $inventory = Inventory::where([
                        'accessory_id' => $accessory['id'],
                        'branch_id' => $fromBranchId
                    ])->first();

                    if (!$inventory || $inventory->quantity < $quantityChange) {
                        $errors["accessories.$index.quantity"] = 'Insufficient stock for selected accessory';
                    }
                }
            }
        }

        if (isset($data['new_accessories'])) {
            foreach ($data['new_accessories'] as $index => $accessory) {
                $inventory = Inventory::where([
                    'accessory_id' => $accessory['id'],
                    'branch_id' => $fromBranchId
                ])->first();

                if (!$inventory || $inventory->quantity < $accessory['quantity']) {
                    $errors["new_accessories.$index.quantity"] = 'Insufficient stock for selected accessory';
                }
            }
        }

        if (isset($data['machineries'])) {
            foreach ($data['machineries'] as $index => $machinery) {
                $originalQuantity = $transfer->machineries->where('id', $machinery['id'])->first()->pivot->quantity ?? 0;
                $quantityChange = $machinery['quantity'] - $originalQuantity;

                if ($quantityChange > 0) {
                    $inventory = Inventory::where([
                        'machinery_id' => $machinery['id'],
                        'branch_id' => $fromBranchId
                    ])->first();

                    if (!$inventory || $inventory->quantity < $quantityChange) {
                        $errors["machineries.$index.quantity"] = 'Insufficient stock for selected machinery';
                    }
                }
            }
        }

        if (isset($data['new_machineries'])) {
            foreach ($data['new_machineries'] as $index => $machinery) {
                $inventory = Inventory::where([
                    'machinery_id' => $machinery['id'],
                    'branch_id' => $fromBranchId
                ])->first();

                if (!$inventory || $inventory->quantity < $machinery['quantity']) {
                    $errors["new_machineries.$index.quantity"] = 'Insufficient stock for selected machinery';
                }
            }
        }

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    protected function processRemovedItems(StockTransfer $transfer, array $data, $originalAccessories, $originalMachineries)
    {
        $currentAccessoryIds = collect($data['accessories'] ?? [])->pluck('id')->merge(
            collect($data['new_accessories'] ?? [])->pluck('id')
        )->toArray();

        foreach ($originalAccessories as $accessory) {
            if (!in_array($accessory->id, $currentAccessoryIds)) {
                $this->updateInventory(
                    null,
                    $accessory->id,
                    $transfer->from_branch_id,
                    $accessory->pivot->quantity
                );
            }
        }

        $currentMachineryIds = collect($data['machineries'] ?? [])->pluck('id')->merge(
            collect($data['new_machineries'] ?? [])->pluck('id')
        )->toArray();

        foreach ($originalMachineries as $machinery) {
            if (!in_array($machinery->id, $currentMachineryIds)) {
                $this->updateInventory(
                    $machinery->id,
                    null,
                    $transfer->from_branch_id,
                    $machinery->pivot->quantity
                );
            }
        }
    }

    public function edit($id)
    {
        $stockTransfer = StockTransfer::with('products')->findOrFail($id);
        $branches = Branch::all();
        $products = Product::all();

        return view('inventory::StockTransfer.edit', compact('stockTransfer', 'branches', 'products'));
    }



    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $transfer = StockTransfer::findOrFail($id);

            if ($transfer->status !== 'pending') {
                throw new \Exception('Only pending transfers can be deleted');
            }

            $transfer->accessories()->detach();
            $transfer->machineries()->detach();
            $transfer->delete();

            DB::commit();

            return redirect()->route('stock-transfers.index')
                ->with('success', 'Stock transfer deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error deleting transfer: ' . $e->getMessage());
        }
    }


    public function updateStatus(Request $request, $id)
    {
        $transfer = StockTransfer::with('products')->findOrFail($id);

        $newStatus = $request->input('status');

        if ($transfer->status == 'pending' && $newStatus == 'in_transit') {
            // Dispatch => deduct inventory from from_branch
            foreach ($transfer->products as $product) {
                $inventory = Inventory::where('branch_id', $transfer->from_branch_id)
                    ->where('product_id', $product->id)
                    ->first();

                if (!$inventory || $inventory->quantity < $product->pivot->quantity) {
                    return back()->with('error', "Not enough stock for {$product->name} in source branch");
                }

                $inventory->decrement('quantity', $product->pivot->quantity);

                // Update who modified
                $inventory->updated_by = auth()->id();
                $inventory->save();
            }

            $transfer->status = 'in_transit';
        } elseif ($transfer->status == 'in_transit' && $newStatus == 'completed') {
            // Receive => add inventory to to_branch
            foreach ($transfer->products as $product) {
                $inventory = Inventory::where('branch_id', $transfer->to_branch_id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($inventory) {
                    // Already exists, just increment
                    $inventory->increment('quantity', $product->pivot->quantity);
                    $inventory->updated_by = auth()->id();
                    $inventory->save();
                } else {
                    // Create new entry
                    Inventory::create([
                        'branch_id'  => $transfer->to_branch_id,
                        'product_id' => $product->id,
                        'quantity'   => $product->pivot->quantity,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                        'opening_quantity'   => $product->pivot->quantity,
                    ]);
                }
            }

            $transfer->status = 'completed';
        } else {
            return back()->with('error', 'Invalid status change.');
        }

        $transfer->save();

        return back()->with('success', 'Status updated successfully!');
    }
}
