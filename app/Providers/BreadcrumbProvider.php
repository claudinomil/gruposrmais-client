<?php

namespace App\Providers;

use App\Services\Breadcrumb;
use Illuminate\Support\ServiceProvider;

class BreadcrumbProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('breadcrumb-sistema', function() {
            return new Breadcrumb();
        });
    }
}
