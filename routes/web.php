<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\FrontEnd\DashboardController;

/** Admin Auth Routes */
Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::get('admin/forget-password', [AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__ . '/auth.php';

/** Show Home page */
Route::get('/', [FrontendController::class, 'index'])->name('home');










Route::fallback(function () {
    // يمكنك عرض صفحة 404 مخصصة
    return response()->view('page404', [], 404);

    // أو ببساطة:
    // abort(404);
});