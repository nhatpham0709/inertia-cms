<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'permission:' . ADMIN_DASHBOARD], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});
