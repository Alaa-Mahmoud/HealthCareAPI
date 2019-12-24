<?php

namespace App\Providers;

use App\Billing\PaymentGateway;
use App\Billing\PaymentProviderX;
use App\Billing\PaymentProviderY;
use Illuminate\Support\ServiceProvider;

class PaymentGatewayProvider extends ServiceProvider
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
        $this->app->singleton(PaymentGateway::class , function ($app) {
            if (request()->provider == 'ProviderX') {
                return new PaymentProviderX();
            }
            return new PaymentProviderY();
        });
    }
}
