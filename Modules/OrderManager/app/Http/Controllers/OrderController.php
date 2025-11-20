<?php

namespace Modules\OrderManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\OrderManager\Models\Order;
use Modules\OrderManager\Models\OrderItem;
use Modules\ProjectManager\Models\Site as Project;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display orders dashboard with statistics
     */
   public function dashboard()
{
    // Base query for orders with relationships
    $query = Order::with(['project', 'project.branch']);
    
    // Get latest orders for the table
    $orders = $query->latest()->get();
    
    // Get statistics
    $totalorders = Order::count();
    $dispatchorders = Order::where('status', 'dispatched')->count();
    $rejectedorders = Order::where('status', 'rejected')->count();
    $completeorders = Order::where('status', 'approved')->count();
    
    return view('ordermanager::dashboard.index', compact(
        'totalorders',
        'dispatchorders', 
        'rejectedorders',
        'completeorders',
        'orders'
    ));
}

   public function index(Request $request)
{
    $status = $request->get('status'); // e.g. ?status=approved

    $orders = Order::with('project')
        ->when($status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->latest()
        ->get();

    return view('ordermanager::orders.index', compact('orders', 'status'));
}
  public function index2(Request $request)
{
    $status = $request->get('status'); // e.g. ?status=approved

    $orders = Order::with('project')
        ->when($status, function ($query, $status) {
            $query->where('status', $status);
        })
        ->latest()
        ->get();

    return view('ordermanager::orders.index2', compact('orders', 'status'));
}


    public function create()
    {
        $projects = Project::all();
        $userRole = Auth::user()->role; // assuming 'role' column exists
        return view('ordermanager::orders.create', compact('projects', 'userRole'));
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'project_id' => $request->project_id,
            'ordered_by' => Auth::id(),
            'status' => 'pending',
        ]);

        foreach ($request->products as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
            ]);

            // ✅ Only Purchase Team uploads images
            if (Auth::user()->role === 'purchase' && isset($item['images'])) {
                foreach ($item['images'] as $img) {
                    if (isset($img['file'])) {
                        $path = $img['file']->store('order_images', 'public');

                        $orderItem->images()->create([
                            'title' => $img['title'] ?? null,
                            'price' => $img['price'] ?? 0,
                            'file_path' => $path,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        // Eager load relations
        $order->load(['project.branch', 'items']); 
        return view('ordermanager::orders.details', compact('order'));
    }
    public function show2(Order $order)
    {
        // Eager load relations
        $order->load(['project.branch', 'items']); 
        return view('ordermanager::orders.details2', compact('order'));
    }

    public function updateItemStatus(Request $request, Order $order, OrderItem $item)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,partial_purchased,full_purchased',
        ]);

        // Ensure the item belongs to the order
        if ($item->order_id != $order->id) {
            abort(403, 'Unauthorized action.');
        }

        // Update the item status
        $item->update(['status' => $request->status]);

        // **Update order status if any item is approved**
        if ($request->status === 'approved') {
            $order->update(['status' => 'approved']);
        } else {
            // Optional: if all items are rejected, you can mark order as rejected
            $allRejected = $order->items()->where('status', '!=', 'rejected')->count() === 0;
            if ($allRejected) {
                $order->update(['status' => 'rejected']);
            }
        }

        return back()->with('success', 'Item status updated successfully!');
    }
}