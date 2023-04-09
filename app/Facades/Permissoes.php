<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Permissoes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'permissoes-sistema';
    }
}
