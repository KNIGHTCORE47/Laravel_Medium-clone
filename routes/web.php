<?php

use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\LikeController;

Route::get('/', function () {
    return view('welcome');
});

// Public Profile Route [Public Route - Not Authenticated]
Route::get('/@{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');

Route::get('/posts', [PostController::class, 'index'])->name('posts');

Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories/{category}', [PostController::class, 'category'])->name('posts.byCategory');


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

    Route::post('/posts/create', [PostController::class, 'store'])->name('posts.store');

    Route::get('/posts/@myPosts', [PostController::class, 'myPosts'])->name('posts.myPosts');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // AJAX Routes
    Route::post('/follow/{user}', [FollowerController::class, 'followUnfollow'])->name('follow.unfollow');

    Route::post('like/{post}', [LikeController::class, 'likeDislike'])->name('like.dislike');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
