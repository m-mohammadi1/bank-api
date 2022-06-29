<?php

namespace Features\Core\Http\V1\Requests;

use Features\Core\Rules\ValidCreditCart;
use Illuminate\Foundation\Http\FormRequest;

class TransferMoneyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $transactionMaxAmount = config('core.transaction_max_amount');
        $transactionMinAmount = config('core.transaction_min_amount');
        return [
            'sender_cart_number' => ['required', 'min:16', 'max:16', 'exists:credit_carts,cart_number', new ValidCreditCart],
            'recipient_cart_number' => ['required', 'min:16', 'max:16', 'exists:credit_carts,cart_number', new ValidCreditCart],
            'amount' => ['required', 'numeric', 'min:' . $transactionMinAmount, 'max:' . $transactionMaxAmount],
        ];
    }

}
