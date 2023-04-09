<?php

namespace App\Providers;

use App\Services\Menu;
use Illuminate\Support\ServiceProvider;

class MenuProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('menu-sistema', function() {
            return new Menu();
        });
    }
}
