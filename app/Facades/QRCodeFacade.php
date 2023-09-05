<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class QRCodeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'facade-qrcode';
    }
}
