<?php

use Inertia\Inertia;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'canViewPosts' => Route::has('posts.index'),
    ]);
});

Route::resource('posts', PostController::class);
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'canCreatePosts' => Route::has('posts.create'),
            'canViewPosts' => Route::has('posts.index'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'isAdmin' => User::find(Auth::user()->id)->level_id > 1,
        ]);
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/upload', [PostController::class, 'upload'])->name('posts.upload');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts/update', [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/destroy/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/users/index', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UsersController::class, 'edit'])->name('users.edit');
    Route::post('/users/update', [UsersController::class, 'update'])->name('users.update');
    Route::get('/users/destroy/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
});

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

require __DIR__.'/auth.php';
