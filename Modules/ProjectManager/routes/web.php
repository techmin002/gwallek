<?php

use Illuminate\Support\Facades\Route;
use Modules\ProjectManager\Http\Controllers\CustomerController;
use Modules\ProjectManager\Http\Controllers\ManagerController;
use Modules\ProjectManager\Http\Controllers\PaymentDetailsController;
use Modules\ProjectManager\Http\Controllers\ProjectManagerController;
use Modules\ProjectManager\Http\Controllers\RelatedProjectController;
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
    Route::get('/sites/{id}/images', [ProjectManagerController::class, 'Siteimages'])->name('sites.images');
    Route::post('/sites/{id}/images/store', [ProjectManagerController::class, 'storeSiteImages'])
        ->name('sites.images.store');
    Route::get('/site-images/{id}/status', [ProjectManagerController::class, 'siteImageStatus'])->name('siteimages.status');
    Route::delete('/site-images/{id}', [ProjectManagerController::class, 'destroySiteImage'])->name('siteimages.destroy');


    Route::resource('managers', ProjectManagerController::class)->names('managers');

    Route::get('/sites/{site}/related-projects', [RelatedProjectController::class, 'index'])->name('relatedproject.index');
    Route::get('/relatedproject/create/{site}', [RelatedProjectController::class, 'create'])->name('relatedproject.create');
    Route::post('/relatedproject/store/{site}', [RelatedProjectController::class, 'store'])->name('relatedproject.store');
    Route::get('relatedproject/{id}/edit', [RelatedProjectController::class, 'edit'])->name('relatedproject.edit');
    Route::put('relatedproject/{id}', [RelatedProjectController::class, 'update'])->name('relatedproject.update');
    Route::delete('relatedproject/{id}', [RelatedProjectController::class, 'destroy'])->name('relatedproject.destroy');
    Route::get('relatedproject/{id}/status', [RelatedProjectController::class, 'status'])->name('relatedproject.status');

    Route::get('projects/{project}/payment-details', [PaymentDetailsController::class, 'index'])
        ->name('paymentdetails.index');

    Route::post('projects/payment-details/store', [PaymentDetailsController::class, 'store'])
        ->name('paymentdetails.store');
});
