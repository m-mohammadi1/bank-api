<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('test1', function () {
    return 'ok sdas';
});
