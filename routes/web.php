<?php

use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\MicrositeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PromoController;
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

        Route::prefix('m/{microsite:slug}')
            ->middleware('microsite.access')
            ->scopeBindings()
            ->group(function () {
                Route::get('/', [DashboardController::class, 'microsite'])->name('dashboard');

                Route::get('info', [MicrositeController::class, 'editInfo'])->name('info.edit');
                Route::patch('info', [MicrositeController::class, 'updateInfo'])->name('info.update');

                Route::resource('categories', CategoryController::class)->except('show');

                Route::resource('galleries', GalleryController::class)->except('show');

                Route::resource('promos', PromoController::class)->except('show');

                Route::patch('menu-items/{menuItem}/toggle', [MenuItemController::class, 'toggle'])
                    ->name('menu-items.toggle');
                Route::resource('menu-items', MenuItemController::class)
                    ->except('show')
                    ->parameters(['menu-items' => 'menuItem']);

                Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
                Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
                Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
            });
    });
});
