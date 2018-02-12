<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('FORCE_HTTPS'))
            URL::forceScheme('https');
//        监听查询事件
        DB::listen(function ($query) {
            Log::debug($query->sql);
            Log::debug($query->time);
            Log::debug($query->bindings);
        });

        View::composer(
//            '*',
            ['mobile.*'],
            'App\Http\ViewComposers\WxComposer'
        );
        $this->app['validator']->extend('sms', function ($attribute, $value, $parameters) {
            return sms_check($value);
        });
    }

    public function sms_check($value)
    {
        if (!$this->session->has('captcha')) {
            return false;
        }

        $key = $this->session->get('captcha.key');

        if (!$this->session->get('captcha.sensitive')) {
            $value = $this->str->lower($value);
        }

        $this->session->remove('captcha');

        return $this->hasher->check($value, $key);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
