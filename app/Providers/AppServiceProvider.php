<?php

namespace App\Providers;

use App\Services\SuporteService;
use App\Services\QRCodeService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Facade SuporteFacade
        $this->app->bind('facade-suporte', function () {
            return new SuporteService();
        });

        //Facade QRCodeFacade
        $this->app->bind('facade-qrcode', function () {
            return new QRCodeService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
