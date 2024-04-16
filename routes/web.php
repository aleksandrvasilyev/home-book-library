<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/book/{id}', [BookController::class, 'show'])->name('book');

Route::get('/search', [BookController::class, 'search'])->name('search');

Route::get('/genres', [BookController::class, 'genres'])->name('genres');
Route::get('/genre/{genre}', [BookController::class, 'genre'])->name('genre');

Route::get('/authors', [BookController::class, 'authors'])->name('authors');
Route::get('/author/{author}', [BookController::class, 'author'])->name('author');


Route::get('/series', [BookController::class, 'series'])->name('series');
Route::get('/series/{series}', [BookController::class, 'oneSeries'])->name('oneSeries');


Route::get('/dashboard', [ProfileController::class, 'dashboard'])->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/download/{folder}/{file}/{book_id}', [BookController::class, 'download'])->name('download');


    Route::get('/profile/want_to_read', [ProfileController::class, 'wantToRead'])->name('profile.want_to_read');
    Route::get('/profile/read_now', [ProfileController::class, 'readNow'])->name('profile.readNow');
    Route::get('/profile/completed', [ProfileController::class, 'completed'])->name('profile.completed');
    Route::get('/profile/uncompleted', [ProfileController::class, 'uncompleted'])->name('profile.uncompleted');
    Route::get('/profile/liked', [ProfileController::class, 'liked'])->name('profile.liked');
    Route::get('/profile/starred', [ProfileController::class, 'starred'])->name('profile.starred');
    Route::get('/profile/commented', [ProfileController::class, 'commented'])->name('profile.commented');
    Route::get('/profile/downloaded', [ProfileController::class, 'downloaded'])->name('profile.downloaded');


    Route::post('/book/{id}/like', [BookController::class, 'like'])->name('like');

    Route::post('/book/{id}/comment', [BookController::class, 'comment'])->name('comment');

    Route::post('/book/{id}/star', [BookController::class, 'star'])->name('star');


    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{comment}/abuse', [CommentController::class, 'abuse'])->name('comments.abuse');
    Route::put('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');


    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/book/{id}/status', [BookController::class, 'status'])->name('status');

});

require __DIR__ . '/auth.php';
