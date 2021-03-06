<?php

use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Permission', 'prefix' => 'permission', 'as' => 'permission.', 'middleware' => 'permission:' . ADMIN_DASHBOARD], function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::post('/add', [PermissionController::class, 'add'])->name('add');
    Route::post('/update', [PermissionController::class, 'update'])->name('update');
    Route::post('/listing', [PermissionController::class, 'listing'])->name('listing');
    Route::post('/{id}/delete', [PermissionController::class, 'deteleById'])->name('delete');
});
