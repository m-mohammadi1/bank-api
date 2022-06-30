<?php

namespace Features\Notification\Listeners;

use Features\Core\Events\TransactionCompletedEvent;
use Features\Notification\Helpers\SmsSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendTransactionNotificationListener
{
    public function handle(TransactionCompletedEvent $event)
    {
        // send sms for sender
        $text = __('messages.transaction_decrease_money', [
            'account_number' => $event->senderAccount->account_number,
            'amount' => $event->transaction->amount,
        ]);
        SmsSender::sendSms($event->user->phone_number, $text);
        // send sms for reception
        $textRecipient = __('messages.transaction_increase_money', [
            'account_number' => $event->recipientAccount->account_number,
            'amount' => $event->transaction->amount,
        ]);

        SmsSender::sendSms($event->recipientAccount->user->phone_number, $textRecipient);
    }
}
