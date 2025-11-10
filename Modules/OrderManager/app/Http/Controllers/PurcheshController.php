<?php

namespace Modules\OrderManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\Inventory;
use Modules\OrderManager\Models\Order;
use Modules\OrderManager\Models\ReturnOrder;
use Modules\OrderManager\Models\ReturnOrderproduct;
use Modules\Product\Models\Product;
use Modules\ProjectManager\Models\Site;

class PurcheshController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('ordermanager::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ordermanager::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('ordermanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('ordermanager::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    public function dispatched()
    {
        $user = auth()->user();

        // 🧑‍💼 Super Admin sees all orders
        if ($user->name === 'Super Admin') {
            $orders = Order::with('project.branch')
                ->where('status', 'onloading')
                ->orderBy('id', 'desc')
                ->get();
        }
        // 👤 Other users see only their branch's orders
        else {
            $orders = Order::whereHas('project', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })
                ->with('project.branch')
                ->where('status', 'onloading')
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('ordermanager::dispatch.index', compact('orders'));
    }

    public function rejected()
    {

        $user = auth()->user();

        if ($user->name === 'Super Admin') {
            // 🧑‍💼 Super Admin: See all rejected orders
            $orders = Order::with('project.branch')
                ->where('status', 'reject')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            // 👤 Other Users: See only orders from their branch
            $orders = Order::whereHas('project', function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })
                ->with('project.branch')
                ->where('status', 'reject')
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('ordermanager::reject.index', compact('orders'));
    }
    public function completed()
    {

        $user = auth()->user();

        if ($user->name === 'Super Admin' || $user->hasRole('Super Admin')) {
            // Super Admin can see all completed orders
            $orders = Order::with('project.branch')
                ->where('status', 'completed')
                ->orderBy('id', 'desc')
                ->get();
        } else {
            // Other users only see orders from their own branch
            $orders = Order::with('project.branch')
                ->where('status', 'completed')
                ->whereHas('project', function ($query) use ($user) {
                    $query->where('branch_id', $user->branch_id);
                })
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('ordermanager::completed.index', compact('orders'));
    }

    public function tracking()
    {
        return view('ordermanager::tracking.index');
    }

    public function trackingSearch(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
        ]);

        $order = Order::with('project.branch')->find($request->order_id);
        if (!$order) {
            // Redirect back to tracking page with error
            return redirect()->route('orders.tracking')
                ->with('error', 'Order not found!');
        }
        return view('ordermanager::tracking.index', compact('order'));
    }

    public function return()
    {
        $query = Site::whereHas('orders')->with('branch');

        if (auth()->user()->access_type !== 'Super Admin') {
            // agar normal user hai to sirf uske branch ke site dikhenge
            $query->where('branch_id', auth()->user()->branch_id);
        }

        $projects = $query->get();

        // ✅ Branch-wise filter returns
        $returnQuery = ReturnOrder::with('site.branch');

        if (auth()->user()->access_type !== 'Super Admin') {
            $returnQuery->whereHas('site', function ($q) {
                $q->where('branch_id', auth()->user()->branch_id);
            });
        }

        $returns = $returnQuery->latest()->get();

        $products = Product::all();

        return view('ordermanager::return.index', compact('returns', 'projects', 'products'));
    }

    public function returnstore(Request $request)
    {
        $request->validate([
            'site_id' => 'required|exists:sites,id',
            'remarks' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // ✅ Site fetch karo
            $site = Site::with('branch')->findOrFail($request->site_id);

            // ✅ Return Order create
            $return = ReturnOrder::create([
                'site_id'   => $site->id,
                'branch_id' => $site->branch_id,
                'remarks'   => $request->remarks,
            ]);

            // ✅ Product loop
            foreach ($request->products as $productData) {
                $productId = $productData['product_id'];
                $qty = $productData['quantity'];

                // 1. return_products table
                ReturnOrderProduct::create([
                    'return_order_id' => $return->id,
                    'product_id'      => $productId,
                    'quantity'        => $qty,
                ]);

                // 2. Inventory update
                $inventory = Inventory::where('product_id', $productId)
                    ->where('branch_id', $site->branch_id)
                    ->first();

                if ($inventory) {
                    $inventory->quantity += $qty;
                    $inventory->save();
                } else {
                    Inventory::create([
                        'product_id' => $productId,
                        'branch_id'  => $site->branch_id,
                        'quantity'   => $qty,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Return order created successfully and inventory updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function returndetails($id)
    {
        $return = ReturnOrder::with(['site.branch', 'products.product'])->findOrFail($id);

        return view('ordermanager::return.details', compact('return'));
    }
    public function returnupdate(Request $request, $id)
    {
        $request->validate([
            'site_id' => 'required|exists:sites,id',
            'remarks' => 'nullable|string',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            // ✅ Fetch existing return order
            $return = ReturnOrder::with('products')->findOrFail($id);
            $site   = Site::with('branch')->findOrFail($request->site_id);

            // ✅ Step 1: Inventory rollback (remove old quantities)
            foreach ($return->products as $oldProduct) {
                $inventory = Inventory::where('product_id', $oldProduct->product_id)
                    ->where('branch_id', $return->branch_id)
                    ->first();

                if ($inventory) {
                    $inventory->quantity -= $oldProduct->quantity; // rollback
                    if ($inventory->quantity < 0) {
                        $inventory->quantity = 0; // negative safe guard
                    }
                    $inventory->save();
                }
            }

            // ✅ Step 2: Delete old product records
            ReturnOrderProduct::where('return_order_id', $return->id)->delete();

            // ✅ Step 3: Update main return order
            $return->update([
                'site_id'   => $site->id,
                'branch_id' => $site->branch_id,
                'remarks'   => $request->remarks,
            ]);

            // ✅ Step 4: Insert new products & update inventory
            foreach ($request->products as $productData) {
                $productId = $productData['product_id'];
                $qty       = $productData['quantity'];

                // Save return products
                ReturnOrderProduct::create([
                    'return_order_id' => $return->id,
                    'product_id'      => $productId,
                    'quantity'        => $qty,
                ]);

                // Update inventory
                $inventory = Inventory::where('product_id', $productId)
                    ->where('branch_id', $site->branch_id)
                    ->first();

                if ($inventory) {
                    $inventory->quantity += $qty;
                    $inventory->save();
                } else {
                    Inventory::create([
                        'product_id' => $productId,
                        'branch_id'  => $site->branch_id,
                        'quantity'   => $qty,
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Return order updated successfully and inventory managed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function dashboard()
{
    $user = auth()->user();

    if ($user->access_type == 'Super Admin') {
        // Count all orders by status
        $totalorders = Order::count();
        $dispatchorders = Order::where('status', 'onloading')->count();
        $completeorders = Order::where('status', 'completed')->count();
        $rejectedorders = Order::where('status', 'reject')->count();

        // ✅ Show only pending orders in dashboard table
        $orders = Order::where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

    } else {
        // For branch-specific users
        $totalorders = Order::whereHas('project', function ($q) use ($user) {
            $q->where('branch_id', $user->branch_id);
        })->count();

        $dispatchorders = Order::whereHas('project', function ($q) use ($user) {
            $q->where('branch_id', $user->branch_id);
        })->where('status', 'onloading')->count();

        $completeorders = Order::whereHas('project', function ($q) use ($user) {
            $q->where('branch_id', $user->branch_id);
        })->where('status', 'completed')->count();

        $rejectedorders = Order::whereHas('project', function ($q) use ($user) {
            $q->where('branch_id', $user->branch_id);
        })->where('status', 'reject')->count();

        // ✅ Pending orders only, filtered by user's branch
        $orders = Order::whereHas('project', function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            })
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();
    }

    return view('ordermanager::dashboard.index', compact(
        'totalorders',
        'dispatchorders',
        'completeorders',
        'rejectedorders',
        'orders'
    ));
}
}
