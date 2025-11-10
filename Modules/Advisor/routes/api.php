<?php

use Illuminate\Support\Facades\Route;
use Modules\Advisor\Http\Controllers\AdvisorController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('advisors', AdvisorController::class)->names('advisor');
});
