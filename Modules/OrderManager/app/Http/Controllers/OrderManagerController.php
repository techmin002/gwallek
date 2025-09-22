<?php

namespace Modules\OrderManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Branch\Entities\Branch;
use Modules\Inventory\Entities\Inventory;
use Modules\OrderManager\Models\Order;
use Modules\OrderManager\Models\OrderHistory;
use Modules\OrderManager\Models\OrderItems;
use Modules\Product\Models\Product;
use Modules\ProjectManager\Models\Site;

class OrderManagerController extends Controller
{
    public function index()
    {

        $orders = Order::with('project.branch')->orderBy('id', 'desc')->get();
        return view('ordermanager::orders.index', compact('orders'));
    }

    public function create()
    {
        // Preload first 20 projects & products
        $projects = Site::where('status', 'on')->orderBy('name')->get();
        $products = Product::with('unit')
            ->where('status', 'on')
            ->orderBy('name')
            ->get();

        return view('ordermanager::orders.create', compact('projects', 'products'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate request
        $request->validate([
            'project_id' => 'required|exists:sites,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            // 'products.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Create the main order
            $order = Order::create([
                'project_id' => $request->project_id,
                'status' => 'pending', // from your input field
            ]);

            // Create order items
            foreach ($request->products as $item) {
                OrderItems::create([
                    'order_id' => $order->id,
                    'project_id' => $request->project_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    // 'price' => $item['price'],// optional if you want r  ow total
                ]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('products.product', 'project'); // load products and project
        return view('ordermanager::orders.details', compact('order'));
    }

    public function edit($id)
    {
        return view('ordermanager::edit');
    }

    public function update(Request $request, $id)
    {
        // Update logic
    }

    public function destroy($id)
    {
        // Destroy logic
    }

    // 🔹 AJAX Projects
    public function ajaxProjects(Request $request)
    {
        $search = $request->get('search', '');
        $projects = Site::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json([
            'results' => $projects->map(fn($p) => [
                'id'   => $p->id,
                'text' => $p->name ?? 'Unnamed Project',
            ])
        ]);
    }

    // 🔹 AJAX Products
    public function ajaxProducts(Request $request)
    {
        $search = $request->get('search', '');
        $products = Product::with('unit')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json([
            'results' => $products->map(fn($p) => [
                'id'    => $p->id,
                'text'  => $p->name ?? 'Unnamed Product',
                'price' => (float) ($p->price ?? 0),
                'unit'  => optional($p->unit)->name ?? '',
            ])
        ]);
    }

    public function history(Request $request, $id)
    {
        // dd('hello');
        $request->validate([
            'status' => 'required|string',
            'message' => 'nullable|string',
            'action_date' => 'required|date',
            'products' => 'required|array',
            'products.*.product_id' => 'required|integer|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'branch_id' => 'required|integer|exists:branches,id',
        ]);

        $order = Order::findOrFail($id);

        DB::transaction(function () use ($request, $order, $id) {
            $oldStatus = $order->status;
            $newStatus = $request->status;


            if ($oldStatus === 'pending' && $newStatus === 'accept') {
                // dd('accept');
                foreach ($request->products as $item) {
                    $inventory = Inventory::where('branch_id', $request->branch_id)
                        ->where('product_id', $item['product_id'])
                        ->first();

                    $productName = Product::find($item['product_id'])->name ?? 'Unknown Product';
                    $branchName = Branch::find($request->branch_id)->name ?? 'Unknown Branch';

                    if (!$inventory || $inventory->quantity < $item['quantity']) {
                        return back()->withErrors([
                            "Not enough stock for {$productName} in branch {$branchName}"
                        ])->withInput();
                    }

                    $inventory->decrement('quantity', $item['quantity']);
                }
            }

            if ($oldStatus === 'accept' && $newStatus === 'reject') {
                // dd('reject');
                foreach ($request->products as $item) {
                    $inventory = Inventory::where('branch_id', $request->branch_id)
                        ->where('product_id', $item['product_id'])
                        ->first();

                    if ($inventory) {
                        $inventory->increment('quantity', $item['quantity']);
                    }
                }
            }

            // ✅ Update order status
            $order->update([
                'status' => $newStatus,
            ]);

            // ✅ Save in history
            OrderHistory::create([
                'order_id' => $id,
                'status' => $newStatus,
                'date' => $request->action_date,
                'message' => $request->message,
            ]);
        });

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }





    public function historydetails($id)
    {
        // dd($id);
        $data = Order::with(['project', 'histories'])->findOrFail($id);
        return view('ordermanager::orders.history', compact('data'));
    }
}
