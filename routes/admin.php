<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AdminAuthController;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){

    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');

});
