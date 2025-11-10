<?php

use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;
use Modules\Service\Http\Controllers\ServiceController;
use Modules\Service\Http\Controllers\ServiceTypeController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('services', ServiceController::class)->names('services');
    Route::get('services/status/{id}', [ServiceController::class, 'status'])->name('services.status');

    // Create page per service
    Route::get('/create/{service}', [ServiceTypeController::class, 'create'])
        ->name('type.create');

    // Store new Why Choose
    Route::post('/store', [ServiceTypeController::class, 'store'])
        ->name('type.store');

    // Edit Why Choose
    Route::get('/edit/{id}', [ServiceTypeController::class, 'edit'])
        ->name('type.edit');

    // Update Why Choose
    Route::put('/update/{id}', [ServiceTypeController::class, 'update'])
        ->name('type.update');

    // Delete Why Choose
    Route::delete('/delete/{id}', [ServiceTypeController::class, 'destroy'])
        ->name('type.delete');

    // Status toggle
    Route::get('/status/{id}', [ServiceTypeController::class, 'status'])
        ->name('type.status');

    Route::get('/galleries', [ServiceTypeController::class, 'galleries'])
        ->name('galleries.index');
});
Route::get('services/details/{id}', [FrontendController::class, 'details'])->name('services.details');
