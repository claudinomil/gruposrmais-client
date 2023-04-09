<?php

namespace App\Providers;

use App\Services\Permissoes;
use Illuminate\Support\ServiceProvider;

class PermissoesProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('permissoes-sistema', function() {
            return new Permissoes();
        });
    }
}
