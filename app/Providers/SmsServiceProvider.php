<?php

namespace App\Providers;

use App\Sms\NexemoService;
use App\Sms\SmsService;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(SmsService::class , function ($app) {
            return new NexemoService();
        });
    }
}
