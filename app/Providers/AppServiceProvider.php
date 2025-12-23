<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

   public function boot(): void
    {
    Blade::if('membership', function ($name) {
        return auth()->check() && auth()->user()->hasMembership($name);
    });

    Blade::if('notMembership', function ($name) {
        return auth()->check() && ! auth()->user()->hasMembership($name);
    });
    }
}
