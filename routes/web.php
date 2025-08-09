<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/data', [UserController::class, 'users'])->name('admin.users.data');
    Route::get('/categories', [ CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('admin.category.store');
});

Route::prefix('auth')->group(function () {
   Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
   Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
   Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});
