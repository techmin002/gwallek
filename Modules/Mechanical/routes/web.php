<?php

use Illuminate\Support\Facades\Route;
use Modules\Mechanical\Http\Controllers\MechanicalCategoryController;
use Modules\Mechanical\Http\Controllers\MechanicalController;
use Modules\Mechanical\Http\Controllers\MechanicalExpenseController;
use Modules\Mechanical\Http\Controllers\MechanicalReportController;
use Modules\Mechanical\Http\Controllers\MechanicalServiceController;

Route::middleware(['auth', 'verified'])->prefix('mechanicals')->name('mechanicals.')->group(function () {

    // Categories
    Route::resource('categories', MechanicalCategoryController::class);
    Route::get('categories/status/{id}', [MechanicalCategoryController::class, 'status'])
        ->name('categories.status');
    // Mechanicals (items)
    Route::resource('items', MechanicalController::class);

    // Expenses
    Route::resource('expenses', MechanicalExpenseController::class);

    // Reports
    Route::resource('reports', MechanicalReportController::class);


    // Services
    Route::resource('services', MechanicalServiceController::class);
});
Route::get('reports/details/{id}', [MechanicalReportController::class, 'expenseShow'])->name('report.details');
