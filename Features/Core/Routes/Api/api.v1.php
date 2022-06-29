<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('transfer', [\Features\Core\Http\V1\Controllers\TransferMoneyController::class, 'transafer'])
        ->name('v1.transfer_money');
});
