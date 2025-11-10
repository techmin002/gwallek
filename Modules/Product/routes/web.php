<?php

use Illuminate\Support\Facades\Route;
use Modules\Product\Http\Controllers\BrandController;
use Modules\Product\Http\Controllers\CategoriesController;
use Modules\Product\Http\Controllers\ProductController;
use Modules\Product\Http\Controllers\UnitController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('units', UnitController::class)->names('units');
    Route::get('units/status/{id}', [UnitController::class, 'status'])->name('units.status');
    Route::resource('brands', BrandController::class)->names('brands');
    Route::get('brands/status/{id}', [BrandController::class, 'status'])->name('brands.status');
    Route::resource('categories', CategoriesController::class)->names('categories');
    Route::get('categories/status/{id}', [CategoriesController::class, 'status'])->name('categories.status');
    Route::resource('products', ProductController::class)->names('products');
    Route::get('products/status/{id}', [ProductController::class, 'status'])->name('products.status');
});
