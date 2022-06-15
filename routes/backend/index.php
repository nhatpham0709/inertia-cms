<?php

use Illuminate\Support\Facades\Route;
use App\Utils\UIUtils;

Route::middleware('auth', 'verified')->group(function () {
    UIUtils::includeRouteFiles(__DIR__ . '/admin/');
});
