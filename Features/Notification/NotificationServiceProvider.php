<?php

namespace Features\Notification;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'user');
    }


    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'Database/Migrations/');

        Route::prefix('api/v1/')
            ->middleware('api')
            ->group(__DIR__ . '/Routes/Api/api.v1.php');
    }
}
