<?php

use Illuminate\Support\Facades\Route;

$namespace = 'Khapu\CurlPlatform\Http\Controllers';

Route::namespace($namespace)->group(function()
{
    Route::get('khapu/curl-platform/test', 'TestController@index');
});