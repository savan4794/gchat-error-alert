<?php

namespace Savan\GchatErrorAlert;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Monolog\Logger;

class GChatAlertServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/gchat-alert.php',
            'gchat-alert'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/gchat-alert.php' => config_path('gchat-alert.php'),
        ], 'gchat-alert-config');

        Log::extend('gchat', function () {
            $handler = new GChatLogHandler(
                Logger::toMonologLevel(config('gchat-alert.level'))
            );

            return new Logger('gchat', [$handler]);
        });
    }
}
