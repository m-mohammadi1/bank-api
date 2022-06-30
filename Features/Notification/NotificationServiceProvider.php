<?php

namespace Features\Notification;


use Features\Core\Events\TransactionCompletedEvent;
use Features\Notification\Listeners\SendTransactionNotificationListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'notification');
    }


    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'Database/Migrations/');

        Route::prefix('api/v1/')
            ->middleware('api')
            ->group(__DIR__ . '/Routes/Api/api.v1.php');

        Event::listen(
            TransactionCompletedEvent::class,
            [SendTransactionNotificationListener::class, 'handle']
        );
    }
}
