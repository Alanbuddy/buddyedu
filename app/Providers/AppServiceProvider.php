<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
//        监听查询事件
        DB::listen(function ($query) {
            Log::debug($query->sql);
//            Log::info($query->time);
            Log::debug($query->bindings);
        });

        View::composer(
//            '*',
            ['mobile.course-show',],
            'App\Http\ViewComposers\WxComposer'
        );
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
