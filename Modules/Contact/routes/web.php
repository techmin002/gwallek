<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\BlogCommentController;
use Modules\Contact\Http\Controllers\ContactController;
use Modules\Contact\Http\Controllers\InquiryController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('contacts', ContactController::class)->names('contact');
    Route::get('messages/index', [ContactController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}/toggle-status', [ContactController::class, 'toggleStatus'])->name('messages.toggleStatus');
    Route::delete('/messages/{id}/destroy', [ContactController::class, 'destroy'])->name('messages.destroy');

    Route::get('inquiry/index', [InquiryController::class, 'index'])->name('inquiry.index');
    Route::get('/inquiry/{id}/toggle-status', [InquiryController::class, 'toggleStatus'])->name('inquiry.toggleStatus');
    Route::delete('/inquiry/{id}/destroy', [InquiryController::class, 'destroy'])->name('inquiry.destroy');

    Route::get('blogs/comment/index', [BlogCommentController::class, 'index'])->name('blogscomment.index');
    Route::post('blogs/comments/{comment}/accept', [BlogCommentController::class, 'accept'])->name('blogscomment.accept');
    Route::post('blogs/comments/{comment}/reject', [BlogCommentController::class, 'reject'])->name('blogscomment.reject');
});
Route::post('messages/store', [ContactController::class, 'store'])->name('messages.store');
Route::post('inquiry/store', [InquiryController::class, 'store'])->name('inquiry.store');

Route::get('messages/ed/index', [ContactController::class, 'messagefromed'])->name('messages.ed.index');
Route::get('messages/md/index', [ContactController::class, 'messagefrommd'])->name('messages.md.index');

// Route::get('messagefrom/create', [ContactController::class, 'messagefromcreate'])->name('messagesfrom.create');
Route::put('messagefrom/update/{id}', [ContactController::class, 'messagefromupdate'])->name('messagesfrom.update');

Route::post('blogs/comment', [BlogCommentController::class, 'store'])->name('blogscomment.store');
