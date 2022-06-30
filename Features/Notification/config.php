<?php

return [
    'kavenegar_api_key' => env('KAVENEGAR_API_KEY') ?? '',

    'gasedak_api_key' => env('GASEDAK_API_KEY') ?? '',
    'gasedak_sms_sender' => env('GASEDAK_SMS_SENDER') ?? '',

    'sms_provider' => 'gasedak', // kavenegar
];
