<?php

namespace NotificationChannels\WidepaySms;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\WidepaySms\WidepaySmsChannel;

class WidepaySmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.

    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
