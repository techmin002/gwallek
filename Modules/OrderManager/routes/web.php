<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use Modules\OrderManager\Http\Controllers\OrderManagerController;
use Modules\OrderManager\Http\Controllers\PurcheshController;
use Modules\Product\Models\Product;
use Modules\ProjectManager\Models\Site;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('ordermanagers', OrderManagerController::class)->names('ordermanager');
    Route::resource('orders', OrderManagerController::class)->names('orders');

    // Route::get('/ajax/projects', [OrderManagerController::class, 'ajaxProjects'])->name('ajax.projects');
    // Route::get('/ajax/products', [OrderManagerController::class, 'ajaxProducts'])->name('ajax.products');

    // AJAX routes directly in web.php
    Route::get('ajax/projects', function (Request $request) {
        $search = $request->search ?? '';
        $projects = Site::where('name', 'like', "%{$search}%")->get();
        return response()->json([
            'results' => $projects->map(fn($p) => ['id' => $p->id, 'text' => $p->name])
        ]);
    })->name('ajax.projects');

    Route::get('ajax/products', function (Request $request) {
        $search = $request->search ?? '';
        $products = Product::with('unit')
            ->where('name', 'like', "%{$search}%")
            ->get();

        return response()->json([
            'results' => $products->map(fn($p) => [
                'id' => $p->id,
                'text' => $p->name,
                'price' => $p->price,
                'unit' => $p->unit?->name ?? 'N/A'
            ])
        ]);
    })->name('ajax.products');

    Route::put('/history/store/{id}', [OrderManagerController::class, 'history'])->name('orderhistory.store');
    Route::get('/history/{id}', [OrderManagerController::class, 'historydetails'])->name('order.history');

    Route::get('dispatched', [PurcheshController::class, 'dispatched'])->name('orders.dispatched');
    Route::get('tracking', [PurcheshController::class, 'tracking'])->name('orders.tracking');
    Route::post('/orders/tracking/search', [PurcheshController::class, 'trackingSearch'])->name('orders.tracking.search');
    Route::get('rejected', [PurcheshController::class, 'rejected'])->name('orders.rejected');
    Route::get('completed', [PurcheshController::class, 'completed'])->name('orders.completed');
    Route::get('return', [PurcheshController::class, 'return'])->name('orders.return');
    Route::post('return/store', [PurcheshController::class, 'returnstore'])->name('returns.store');
    Route::get('returns/{id}', [PurcheshController::class, 'returndetails'])->name('returns.details');
    Route::get('returns/destroy/{id}', [PurcheshController::class, 'returndestroy'])->name('returns.destroy');
    Route::put('returns/update/{id}', [PurcheshController::class, 'returnupdate'])->name('returns.update');

});
