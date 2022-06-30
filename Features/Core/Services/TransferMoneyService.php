<?php

namespace Features\Core\Services;

use Features\Core\Events\TransactionCompletedEvent;
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
        $senderCreditCartAccount = Account::query()
            ->where('user_id', $user->id)
            ->whereHas('credit_carts', function ($q) use ($sender_cart_number) {
                $q->where('cart_number', $sender_cart_number);
            })->firstOrFail();
        $creditCart = $senderCreditCartAccount->credit_carts()->where('cart_number', $sender_cart_number)->firstOrFail();


        if ($senderCreditCartAccount->balance < $amount) {
            abort(422, __('Account Balance Is Not Enough'));
        }

        $recipientCreditCart = CreditCart::query()
            ->where('cart_number', $recipient_cart_number)
            ->firstOrFail();

        try {
            DB::beginTransaction();
            $transaction = $creditCart->transactions()->create([
                'amount' => $amount,
                'status' => true,
            ]);

            $transaction->wage()->create([
                'amount' => config('core.transaction_wage')
            ]);

            // sender account balance
            $senderCreditCartAccount->balance -= $amount;
            $senderCreditCartAccount->save();
            // recipient account balance
            $recipientAccount = $recipientCreditCart->account;

            abort_if(!$recipientAccount, Response::HTTP_BAD_REQUEST, __('Reception Account Not Found'));

            $recipientAccount->balance += $amount;
            $recipientAccount->save();

            // transaction completed event
            TransactionCompletedEvent::dispatch($transaction, $user, $senderCreditCartAccount, $recipientAccount);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            $transaction = $creditCart->transactions()->create([
                'amount' => $amount,
                'status' => false,
            ]);

            throw new \HttpResponseException(__('Transaction Failed.', 400));
        }

        return $transaction;
    }

    public static function validateSituations()
    {

    }
}
