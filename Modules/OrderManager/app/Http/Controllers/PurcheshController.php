<?php

namespace Modules\OrderManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\OrderManager\Models\Order;

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
        // dd('hello');
        $orders = Order::with('project.branch')->where('status', 'onloading')->orderBy('id', 'desc')->get();
        return view('ordermanager::dispatch.index', compact('orders'));
    }
    // public function tracking()
    // {

    //     // $orders = Order::with('project.branch')->where('status', 'dispatch') ->orderBy('id', 'desc')->get();
    //     return view('ordermanager::tracking.index');
    // }
    public function rejected()
    {

        $orders = Order::with('project.branch')->where('status', 'reject')->orderBy('id', 'desc')->get();
        return view('ordermanager::reject.index', compact('orders'));
    }
    public function completed()
    {

        $orders = Order::with('project.branch')->where('status', 'completed')->orderBy('id', 'desc')->get();
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
}
