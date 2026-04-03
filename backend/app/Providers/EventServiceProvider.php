<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\TicketUpdated;
use App\Listeners\SendTicketNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
    \App\Events\TicketUpdated::class => [
        \App\Listeners\SendTicketNotification::class,
    ],
];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
