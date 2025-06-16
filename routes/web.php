<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth as Auth;

define('PROFILE', '/profile');
define('POSTS', '/posts');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'canViewPosts' => Route::has('posts.index'),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'canCreatePosts' => Route::has('posts.create'),
        'canViewPosts' => Route::has('posts.index'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'isAdmin' => User::find(Auth::user()->id)->level_id > 1,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get(PROFILE, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(PROFILE, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(PROFILE, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get(POSTS, [PostController::class, 'index'])->name('posts.index');

Route::resource('posts', PostController::class)->except(['update', 'show', 'edit']);

Route::get('/posts/create', [PostController::class, 'create'])->middleware(['auth', 'verified'])->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])->middleware(['auth', 'verified'])->name('posts.store');

Route::get('/posts/edit/{id}', [PostController::class, 'edit'])->middleware(['auth', 'verified'])->name('posts.edit');

Route::post('/posts/update', [PostController::class, 'update'])->middleware(['auth', 'verified'])->name('posts.update');

Route::get('/posts/destroy/{id}', [PostController::class, 'destroy'])->middleware(['auth', 'verified'])->name('posts.destroy');

Route::get('/users/index', [UsersController::class, 'index'])->middleware(['auth', 'verified'])->name('users.index');
Route::get('/users/{id}', [UsersController::class, 'edit'])->middleware(['auth', 'verified'])->name('users.edit');
Route::post('/users/update', [UsersController::class, 'update'])->middleware(['auth', 'verified'])->name('users.update');
Route::get('/users/destroy/{id}', [UsersController::class, 'destroy'])->middleware(['auth', 'verified'])->name('users.destroy');

require __DIR__.'/auth.php';
