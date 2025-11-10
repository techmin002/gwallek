<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontendController::class, 'index'])->name('frontend.index');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/aboutus', [FrontendController::class, 'aboutus'])->name('frontend.aboutus');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
// Route::get('/details_blog', [FrontendController::class, 'details_blog'])->name('frontend.details_blog');
Route::get('/details_service/{id}', [FrontendController::class, 'details_service'])->name('frontend.details_service');
Route::get('/faq', [FrontendController::class, 'faq'])->name('frontend.faq');
Route::get('/project', [FrontendController::class, 'project'])->name('frontend.project');
Route::get('/project_details/{id}', [FrontendController::class, 'project_details'])->name('frontend.project_details');
Route::get('/project_gallery/{id}', [FrontendController::class, 'project_gallery'])->name('frontend.project_gallery');

Route::get('/blog', [FrontendController::class, 'blog'])->name('frontend.blog');
Route::get('/details_blog/{id}', [FrontendController::class, 'details_blog'])->name('frontend.details_blog');

Route::get('/service/{id}', [FrontendController::class, 'service'])->name('frontend.service');

