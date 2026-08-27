<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);
Route::resource('issues', BookIssueController::class);

Route::prefix('search')->group(function () {
    Route::get('authors', [SearchController::class, 'searchAuthors'])->name('search.authors');
    Route::get('books', [SearchController::class, 'searchBooks'])->name('search.books');
    Route::get('readers', [SearchController::class, 'searchReaders'])->name('search.readers');
});

Route::get('modal-issue', [BookIssueController::class, 'renderModal'])->name('issues.modal');


