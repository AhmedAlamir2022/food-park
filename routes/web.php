<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\FrontEnd\DashboardController;

/** Admin Auth Routes */
Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::get('admin/forget-password', [AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');
});

Route::group(['middleware' => 'auth'], function () {
    /** dashboard routes */
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // profile routes
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});

require __DIR__ . '/auth.php';

/** Show Home page */
Route::get('/', [FrontendController::class, 'index'])->name('home');








Route::fallback(function () {
    return response()->view('page404');
});
