<?php

namespace Modules\OrderManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\OrderManager\Models\Order;
use Modules\OrderManager\Models\OrderItem;
use Modules\OrderManager\Models\PurchaseItem;
class PurchaseController extends Controller
{
    public function index()
{
    $orders = Order::with('project')
        ->whereNotIn('status', ['pending', 'rejected'])
        ->latest()
        ->get();

    return view('ordermanager::purchases.index', compact('orders'));
}


public function show(Request $request, $id)
{
    // Load the order with its project, branch, items, and purchases
    $order = Order::with([
        'project.branch', 
        'items.purchases'  // eager load purchases for each item
    ])->find($id);

    if (!$order) {
        abort(404);
    }

    // Only approved items (exclude pending and rejected)
    $approvedItems = $order->items->filter(function($item) {
        return $item->status !== 'pending' && $item->status !== 'rejected';
    });

    return view('ordermanager::purchases.show', compact('order', 'approvedItems'));
}


 public function create(Order $order)
    {
        // Only approved items
        $approvedItems = $order->items()->where('status', 'approved')->get();

        return view('ordermanager::purchases.create', compact('order', 'approvedItems'));
    }

public function store(Request $request, Order $order)
{
    $order = Order::findOrFail($request->order_id);

    try {
        \DB::beginTransaction();

        foreach ($request->products as $index => $productData) {
            // Skip if no images provided
            if (!isset($productData['images']) || empty($productData['images'])) {
                continue;
            }

            $orderItem = OrderItem::findOrFail($productData['id']);

            // Safety check
            if ($orderItem->order_id !== $order->id) {
                \DB::rollBack();
                return back()->withErrors(['error' => 'Invalid order item.'])->withInput();
            }

            // Calculate remaining quantity
            $purchasedQty = $orderItem->purchases()->sum('purchased_qty');
            $remainingQty = $orderItem->quantity - $purchasedQty;

            // Calculate total purchase quantity
            $totalPurchaseQty = collect($productData['images'])->sum('quantity');

            if ($totalPurchaseQty > $remainingQty) {
                \DB::rollBack();
                return back()->withErrors([
                    'quantity' => "Total purchased quantity for {$orderItem->product_name} ({$totalPurchaseQty}) exceeds remaining approved quantity ({$remainingQty})."
                ])->withInput();
            }

            // Loop through each brand/image entry
            foreach ($productData['images'] as $key => $imgData) {
                $quantity = $imgData['quantity'] ?? 0;
                $price = $imgData['price'] ?? 0;
                $brand = $imgData['brand'] ?? 'No brand';
                $totalPrice = $quantity * $price;

                // File input name
                $fileInputName = "products.{$index}.images.{$key}.file";
                $imagePath = null;

                // ✅ Correct way to handle file upload
                if ($request->hasFile($fileInputName)) {
                    $file = $request->file($fileInputName);
                    if ($file && $file->isValid()) {
                        $imagePath = $file->store('purchase_images', 'public');
                    }
                }

                // ✅ Create Purchase Item with image path
                PurchaseItem::create([
                    'order_item_id' => $orderItem->id,
                    'purchased_qty' => $quantity,
                    'remaining_qty' => max(0, $remainingQty - $totalPurchaseQty),
                    'purchased_by' => Auth::id(),
                    'per_unit_price' => $price,
                    'total_price' => $totalPrice,
                    'title' => $brand,
                    'image' => $imagePath,
                ]);
            }

            // ✅ Update order item status
            $newRemainingQty = $remainingQty - $totalPurchaseQty;
            $orderItem->update([
                'status' => $newRemainingQty <= 0 ? 'full_purchased' : 'partial_purchased'
            ]);
        }

        \DB::commit();
        return redirect()->route('purchases.index')->with('success', 'Purchase saved successfully!');

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('Purchase store error: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to save purchase: ' . $e->getMessage()])->withInput();
    }
}

}
