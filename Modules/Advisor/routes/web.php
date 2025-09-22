<?php

use Illuminate\Support\Facades\Route;
use Modules\Advisor\Http\Controllers\AdvisorController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::resource('advisors', AdvisorController::class)->names('advisor');
    Route::resource('advisors', AdvisorController::class)->names('advisors');
    Route::get('advisors/status/{id}',[AdvisorController::class,'status'])->name('advisors.status');

});
