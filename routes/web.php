<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('super', [DashboardController::class, 'superAdmin'])
            ->middleware('role:super_admin')
            ->name('super.dashboard');

        Route::get('m/{microsite:slug}', [DashboardController::class, 'microsite'])
            ->name('dashboard');
    });
});