<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Ticket;
use App\Policies\TicketPolicy;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::policy(Ticket::class, TicketPolicy::class);
    }
}