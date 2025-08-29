<?php

use Illuminate\Support\Facades\Route;
use Modules\ProjectManager\Http\Controllers\ProjectManagerController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('projectmanagers', ProjectManagerController::class)->names('projectmanager');

});
