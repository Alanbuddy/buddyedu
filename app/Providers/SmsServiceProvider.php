<?php

namespace App\Providers;

use App\Services\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extend('sms', function ($attribute, $value, $parameters) {
            return sms_check($value);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sms', function ($app) {
            return new SmsService(app('hash'),5);
        });
    }
}
