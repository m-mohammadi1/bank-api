<?php

namespace Features\Core\Services;

use Features\Core\Models\Account;
use Features\Core\Models\CreditCart;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class TransferMoneyService
{
    public static function run($sender_cart_number, $recipient_cart_number, $amount)
    {
        $user = auth('sanctum')->user();
        $creditCartAccount = Account::query()
            ->where('user_id', $user->id)
            ->whereHas('credit_carts', function ($q) use ($sender_cart_number) {
                $q->where('cart_number', $sender_cart_number);
            })->first();
        $creditCart = $creditCartAccount->credit_carts()->where('cart_number', $sender_cart_number)->first();


        if ($creditCartAccount->balance < $amount) {
            abort(422, __('Account Balance Is Not Enough'));
        }

        $recipientCreditCart = CreditCart::query()
            ->where('cart_number', $recipient_cart_number)
            ->firstOrFail();

        try {
            DB::beginTransaction();
            // 500 wage per transaction
            // cart number could be en, fa, ar

            $transaction = $creditCart->transactions()->create([
                'amount' => $amount,
                'status' => true,
            ]);

            $transaction->wage()->create([
                'amount' => 500
            ]);

            // sender account balance
            $creditCartAccount->balance -= $amount;
            $creditCartAccount->save();
            // recipient account balance
            $recipientAccount = $recipientCreditCart->account;
            abort_if(!$recipientAccount, Response::HTTP_BAD_REQUEST, __('Reception Account Not Found'));
            $recipientAccount->balance += $amount;
            $recipientAccount->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $transaction = $creditCart->transactions()->create([
                'amount' => $amount,
                'status' => false,
            ]);
        }
//        dd($recipientAccount->balance, $creditCartAccount->balance);

        return true;
    }
}
