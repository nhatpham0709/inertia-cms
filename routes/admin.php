<?php

use Illuminate\Support\Facades\Route;
use App\Utils\UIUtils;

Route::middleware('web')->group(function () {
    UIUtils::includeRouteFiles(__DIR__ . '/admin/');
});
