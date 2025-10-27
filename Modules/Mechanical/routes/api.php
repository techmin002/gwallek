<?php

use Illuminate\Support\Facades\Route;
use Modules\Mechanical\Http\Controllers\MechanicalController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('mechanicals', MechanicalController::class)->names('mechanical');
});
