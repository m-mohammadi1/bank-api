<?php

namespace Features\Notification\Helpers;

use Illuminate\Support\Facades\Log;

class FakeSmsSender
{
    public function sendSms(string $phone, string $text)
    {
        Log::info("SMS SENT : $phone - $text");
    }
}
