<?php

use Illuminate\Support\Facades\Route;
use App\Utils\UIUtils;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    UIUtils::includeRouteFiles(__DIR__ . '/admin/');
});
