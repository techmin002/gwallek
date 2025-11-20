<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;
use Modules\OrderManager\Http\Controllers\OrderController;
use Modules\OrderManager\Http\Controllers\PurchaseController;
use Modules\OrderManager\Http\Controllers\PaymentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('orders', OrderController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('payments', PaymentController::class);
    Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('orders.dashboard');
    Route::put('/orders/{order}/items/{item}/status', [OrderController::class, 'updateItemStatus'])
        ->name('orders.items.status');
    Route::get('/approvedorders', [OrderController::class, 'index2'])
        ->name('orderss.index');
    Route::get('/showorders/{order}', [OrderController::class, 'show2'])
        ->name('orderss.show');
});

// Project Payment Routes
Route::get('/project/select-project', [PaymentController::class, 'selectProject'])->name('payments.select-project');
Route::post('/payments/project-items', [PaymentController::class, 'showProjectItems'])->name('payments.project-items');
// Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
// Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/success', [PaymentController::class, 'success'])->name('payments.success');
Route::get('/payments/project/{projectId}', [PaymentController::class, 'projectPayments'])->name('payments.project-payments');
Route::get('/payments/summary', [PaymentController::class, 'getPaymentSummary'])->name('payments.summary');

// Bill generation routes
Route::post('/payments/{payment}/generate-bill', [PaymentController::class, 'generateBill'])->name('payments.generate-bill');
Route::get('/payments/bill/{invoice}/download', [PaymentController::class, 'downloadBill'])->name('payments.download-bill');
Route::get('/payments/history', [PaymentController::class, 'paymentHistory'])->name('payments.history');
