<?php

namespace Features\Notification\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Facade;


/**
 * @method static sendSms(string $phone, string $text)
 */
class SmsSender extends Facade
{
    protected static function getFacadeAccessor()
    {
        if (App::runningUnitTests()) {
            $class =  FakeSmsSender::class;
        } else {
            $class = match (config('notification.sms_provider')) {
                'gasedak' => GasedakSmsSender::class,
                'kavenegar' => KavenegarSmsSender::class,
                default => FakeSmsSender::class,
            };
        }

        return $class;
    }
}
