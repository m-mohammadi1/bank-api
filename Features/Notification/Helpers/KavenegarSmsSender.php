<?php

namespace Features\Notification\Helpers;

use Illuminate\Support\Facades\Http;

class KavenegarSmsSender
{
    public function __construct(private string $api_key)
    {
        $this->api_key = config('notification.kavenegar_api_key');
    }

    public function sendSms(string $phone_number, string $text)
    {
        $baseUri = "https://api.kavenegar.com/v1/$this->api_key/sms/send.json";

        $result = Http::post($baseUri, [
            'receptor' => $phone_number,
            'message' => $text
        ]);
    }

}
