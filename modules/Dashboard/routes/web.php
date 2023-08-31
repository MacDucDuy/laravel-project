<?php

use Illuminate\Support\Facades\Route;

use Modules\Dashboard\src\Http\Controllers\DashboardController;

Route::group(['namespace' => 'Modules\Dashboard\src\Http\Controllers'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    });
});
