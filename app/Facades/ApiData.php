<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ApiData extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'api-data';
    }
}
