<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('transfer-money', [\Features\Core\Http\V1\Controllers\TransferMoneyController::class, 'transfer'])
        ->name('v1.transfer_money');

    Route::get('transactions', [\Features\Core\Http\V1\Controllers\UserTransactionsController::class, 'getTransactions'])
        ->name('v1.transactions');
});
