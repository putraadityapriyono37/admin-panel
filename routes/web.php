<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MicrositeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware('role:super_admin')->group(function () {
            Route::get('super', [DashboardController::class, 'superAdmin'])->name('super.dashboard');
            Route::resource('microsites', MicrositeController::class)->except('show');
            Route::resource('admins', AdminAccountController::class)->except('show');
        });

        Route::get('m/{microsite:slug}', [DashboardController::class, 'microsite'])->name('dashboard');
    });
});