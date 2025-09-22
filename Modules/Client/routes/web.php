<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Http\Controllers\ClientController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('clients', ClientController::class)->names('client');
    Route::resource('clients', ClientController::class);
    Route::get('clients/status/{id}', [ClientController::class, 'status'])->name('clients.status');
});
