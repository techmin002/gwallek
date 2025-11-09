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
use Modules\OrderManager\Models\ProductItem;
use Modules\Product\Models\Product;
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
            ->orderBy('name')
            ->get();

        if ($user->access_type == 'Super Admin') {
            $projects = Site::where('status', 'on')
                ->orderBy('name')
                ->get();
        } else {
            $projects = Site::where('status', 'on')
                ->where('branch_id', $user->branch_id)
                ->orderBy('name')
                ->get();
        }

        return view('ordermanager::orders.create', compact('projects', 'products'));
    }



public function store(Request $request)
{
    dd($request->all());
    // $request->validate([
    //     'project_id' => 'required|exists:projects,id',
    //     'products' => 'required|array|min:1',
    //     'products.*.product_name' => 'required|string|max:255',
    //     'products.*.quantity' => 'required|numeric|min:1',
    //     'products.*.unit' => 'required|string|max:50',
    //     'products.*.images' => 'required|array|min:1',
    //     'products.*.images.*.file' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
    //     'products.*.images.*.price' => 'required|numeric|min:0',
    // ]);

    // DB::beginTransaction();

    // try {
        // ✅ Create the order
        $order = Order::create([
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        // ✅ Loop over each product
        foreach ($request->products as $productData) {

            $productName = $productData['product_name'];
            $quantity = $productData['quantity'];
            $unit = $productData['unit'];

            // ✅ Loop over each image for this product
            foreach ($productData['images'] as $imageData) {

                $price = $imageData['price'];
                // $total = $quantity * $price;

                // ✅ Handle image upload
                $imagePath = null;
                if (isset($imageData['file']) && $imageData['file'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $imageData['file']->store('order_images', 'public');
                }

                // ✅ Save each image as a separate OrderItem
                ProductItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productName,
                    'title' => $title,
                    'price' => $price,
                    'image' => $imagePath,
                ]);
            }
        }

    //     DB::commit();

    //     return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    // } catch (\Exception $e) {
    //     DB::rollBack();
        return back()->with('error', 'Failed to create order: ' . $e->getMessage())->withInput();
    // }
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
