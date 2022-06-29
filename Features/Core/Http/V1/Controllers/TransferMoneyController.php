<?php

namespace Features\Core\Http\V1\Controllers;

use Features\Core\Models\Wage;
use Features\Core\Rules\ValidCreditCart;
use Features\Core\Services\TransferMoneyService;
use Features\Core\Services\ValidateCartNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TransferMoneyController
{

    public function transafer(Request $request)
    {
        $data = $request->validate([
            'sender_cart_number' => ['required', 'min:16', 'max:16', 'exists:credit_carts,cart_number', new ValidCreditCart],
            'recipient_cart_number' => ['required', 'min:16', 'max:16', 'exists:credit_carts,cart_number', new ValidCreditCart],
            'amount' => ['required', 'numeric', 'min:500', 'max:50000000'],
        ]);

        $result = TransferMoneyService::run($data['sender_cart_number'], $data['recipient_cart_number'], $data['amount']);


        return response()->json([
            'status' => 'ok'
        ]);
    }

}
