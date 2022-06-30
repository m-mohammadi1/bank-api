<?php

namespace Features\Notification\Helpers;

use Illuminate\Support\Facades\Http;

class GasedakSmsSender
{
    public function __construct(private string $api_key = '', private string $sender_number = '')
    {
        $this->api_key = config('notification.kavenegar_api_key');
        $this->sender_number = config('notification.gasedak_sms_sender');
    }

    public function sendSms(string $phone_number, string $text)
    {
        $baseUri = "http://api.iransmsservice.com/v2/sms/send/simple";

        $result = Http::post($baseUri, [
            'apikey' => $this->api_key,
            'sender' => $this->sender_number,
            'receptor' => $phone_number,
            'message' => $text
        ]);
    }

}
