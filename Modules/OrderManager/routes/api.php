<?php

use Illuminate\Support\Facades\Route;
use Modules\OrderManager\Http\Controllers\OrderManagerController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('ordermanagers', OrderManagerController::class)->names('ordermanager');
});
