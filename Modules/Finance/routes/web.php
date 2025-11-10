<?php

use Illuminate\Support\Facades\Route;
use Modules\Finance\Http\Controllers\BankController;
use Modules\Finance\Http\Controllers\FinanceController;
use Modules\Finance\Http\Controllers\DueOrderController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('finances', FinanceController::class)->names('finance');

    Route::get('/due-sites', [FinanceController::class, 'index'])->name('due.sites');
    Route::get('/cash-counter', [FinanceController::class, 'cashcounter'])->name('cash-counter.index');
    Route::get('/get-banks/{branch}', [FinanceController::class, 'getBanks']);
    Route::post('/cash/deposite', [FinanceController::class, 'deposite'])->name('cash.deposite');
    Route::get('/deposite/details', [FinanceController::class, 'depositedetails'])->name('finance.depositedetails');

    Route::resource('banks', BankController::class)->names('banks');
    Route::get('banks/status/{id}', [BankController::class, 'status'])->name('banks.status');
    Route::resource('due_orders', DueOrderController::class)->names('due_orders');
});
