<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\AssignFreeMembership;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            AssignFreeMembership::class,
        ],
    ];
}
