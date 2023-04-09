<?php

namespace App\Providers;

use App\Services\ApiData;
use Illuminate\Support\ServiceProvider;

class ApiDataProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('api-data', function() {
            return new ApiData();
        });
    }
}
