<?php

namespace Features\Core\Http\V1\Controllers;

use App\Http\Controllers\Controller;
use Features\Core\Http\V1\Requests\TransferMoneyRequest;
use Features\Core\Http\V1\Resources\TransactionResource;
use Features\Core\Models\Wage;
use Features\Core\Rules\ValidCreditCart;
use Features\Core\Services\TransferMoneyService;
use Features\Core\Services\ValidateCartNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TransferMoneyController extends Controller
{

    public function transafer(TransferMoneyRequest $request)
    {
        $data = $request->validated();

        $transaction = TransferMoneyService::run($data['sender_cart_number'], $data['recipient_cart_number'], $data['amount']);

        return response()->json([
            'status' => 'ok',
            'transaction' => TransactionResource::make($transaction)
        ]);
    }

}
