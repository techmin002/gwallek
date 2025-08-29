<?php

use Illuminate\Support\Facades\Route;
use Modules\ProjectManager\Http\Controllers\CustomerController;
use Modules\ProjectManager\Http\Controllers\ManagerController;
use Modules\ProjectManager\Http\Controllers\ProjectManagerController;
use Modules\ProjectManager\Http\Controllers\SiteController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('projectmanagers', ProjectManagerController::class)->names('projectmanager');
    Route::resource('customers', CustomerController::class)->names('customers');
    Route::get('customers/status/{id}', [CustomerController::class, 'status'])->name('customer.status');

    Route::resource('sites', SiteController::class)->names('sites');
    // Route::get('/get-staff-by-branch', [SiteController::class, 'getStaff'])->name('get.staff.by.branch');
    Route::get('/get-customers-by-branch', [SiteController::class, 'getCustomers'])->name('get.customers.by.branch');
    Route::get('site/status/{id}', [SiteController::class, 'status'])->name('site.status');
    Route::get('/branch/{id}/managers', [SiteController::class, 'getBranchManagers'])->name('branch.managers');

    Route::get('/branch/{id}/staff', [SiteController::class, 'getBranchStaff'])->name('branch.staff');


    Route::post('/assign-staff/{id}', [ProjectManagerController::class, 'assignStaff'])->name('sites.assignStaff');

    Route::get('/sites/{id}/details', [ProjectManagerController::class, 'viewSiteDetails'])->name('sites.details');

    Route::delete('/assignments/{id}', [ProjectManagerController::class, 'removeStaff'])->name('assignments.removeStaff');


    Route::resource('managers', ProjectManagerController::class)->names('managers');
});
