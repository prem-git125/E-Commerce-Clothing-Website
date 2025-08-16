<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProductController as UserProductController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('product')->group(function () {
    Route::get('/{id}', [UserProductController::class, 'index'])->name('user.product.index');
    Route::get('/single/{id}', [UserProductController::class, 'show'])->name('user.product.show');
});

Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/data', [UserController::class, 'users'])->name('admin.users.data');

    Route::prefix('category')->group(function () {
        Route::get('/', [ CategoryController::class, 'index'])->name('admin.categories');
        Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('/data', [CategoryController::class, 'categories'])->name('admin.categories.data');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    });
    
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/data', [ProductController::class, 'products'])->name('admin.product.data');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    });
});

Route::prefix('auth')->group(function () {
   Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
   Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
   Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
   Route::get('/profile', [AuthController::class, 'profile'])->name('auth.profile');
   Route::post('/profile-image/update', [AuthController::class, 'updateProfileImage'])->name('auth.profile.image.update');
});
