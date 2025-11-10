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
use Modules\OrderManager\Models\Product;
use Modules\OrderManager\Models\ProductItem;
use Modules\ProjectManager\Models\Site;

class OrderManagerController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->access_type == 'Super Admin') {
            $orders = Order::with('project.branch')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $orders = Order::whereHas('project', function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            })
                ->with('project.branch')
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('ordermanager::orders.index', compact('orders'));
    }


    public function create()
    {
        $user = auth()->user();

        $products = Product::with('unit')
            ->where('status', 'on')
            ->get();

        if ($user->access_type == 'Super Admin') {
            $projects = Site::where('status', 'on')
                ->get();
        } else {
            $projects = Site::where('status', 'on')
                ->where('branch_id', $user->branch_id)
                ->get();
        }

        return view('ordermanager::orders.create', compact('projects', 'products'));
    }



    public function store(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'project_id' => 'required|exists:projects,id',
        //     'products' => 'required|array|min:1',
        //     'products.*.product_name' => 'required|string|max:255',
        //     'products.*.quantity' => 'required|integer|min:1',
        //     'products.*.unit' => 'nullable|string|max:50',
        // ]);

        DB::beginTransaction();

        try {
            // 🧾 Step 1: Create Order
            $order = Order::create([
                'project_id' => $request->project_id,
                'status' => 'pending',
            ]);

            // 🧰 Step 2: Loop through products
            foreach ($request->products as $productData) {
                $product = Product::create([
                    'order_id' => $order->id,
                    'product_name' => $productData['product_name'],
                    'quantity' => $productData['quantity'],
                    'unit' => $productData['unit'] ?? null,
                ]);

                // 🖼️ Step 3: Handle product images
                if (isset($productData['images'])) {
                    foreach ($productData['images'] as $imgData) {
                        $path = null;

                        if (isset($imgData['file'])) {
                            $path = $imgData['file']->store('product_images', 'public');
                        }

                        ProductItem::create([
                            'project_id' => $request->project_id,
                            'product_id' => $product->id,
                            'image' => $path,
                            'title' => $imgData['title'],
                            'price' => $imgData['price'],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
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

            // 🔹 Pending → Accept
            if ($oldStatus === 'pending' && $newStatus === 'accept') {
            }

            // 🔹 Accept → Dispatch
            if ($oldStatus === 'accept' && $newStatus === 'onloading') {
                foreach ($request->products as $item) {
                    $inventory = Inventory::where('branch_id', $request->branch_id)
                        ->where('product_id', $item['product_id'])
                        ->first();

                    $productName = Product::find($item['product_id'])->name ?? 'Unknown Product';
                    $branchName = Branch::find($request->branch_id)->name ?? 'Unknown Branch';

                    if (!$inventory || $inventory->quantity < $item['quantity']) {
                        throw new \Exception("Not enough stock for {$productName} in branch {$branchName}");
                    }

                    // ✅ Stock reduce
                    $inventory->decrement('quantity', $item['quantity']);
                }
            }

            // ✅ Update order status
            $order->update([
                'status' => $newStatus,
            ]);

            // ✅ Save in history
            OrderHistory::create([
                'order_id' => $id,
                'status'   => $newStatus,
                'date'     => $request->action_date,
                'message'  => $request->message,
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
