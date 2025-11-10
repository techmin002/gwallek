<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class DueOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dueOrders = Order::where('status', 'accepted')->get();
        return view('finance::due_orders.index');
    }

    // public function pay(Request $request, $id)
    // {
    //     $request->validate([
    //         'payment_method' => 'required|in:cash,bill',
    //     ]);

    //     $order = Order::findOrFail($id);
    //     $order->payment_method = $request->payment_method;
    //     $order->status = 'paid';
    //     $order->save();

    //     // Generate PDF
    //     $pdf = Pdf::loadView('finance::pdf.due_order', compact('order'));
    //     $pdfPath = storage_path("app/public/due_order_{$order->id}.pdf");
    //     $pdf->save($pdfPath);

    //     return redirect()->route('finance.due_orders.index')
    //                      ->with('success', 'Payment successful and PDF generated!');
    
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
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
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
