<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', [BookController::class, 'index']);
Route::get('/book/{id}', [BookController::class, 'show']);
Route::get('/download/{id}', [BookController::class, 'download']);

Route::get('/search', [BookController::class, 'search'])->name('search');

Route::get('/genres', [BookController::class, 'genres'])->name('genres');
Route::get('/genre/{genre}', [BookController::class, 'genre'])->name('genre');

Route::get('/authors', [BookController::class, 'authors'])->name('authors');
Route::get('/author/{author}', [BookController::class, 'author'])->name('author');


Route::get('/series', [BookController::class, 'series'])->name('series');
Route::get('/series/{series}', [BookController::class, 'oneSeries'])->name('oneSeries');

