<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Foundation\Events\Dispatchable;

class TicketUpdated
{
    use Dispatchable;

    public $ticket;
    public $message;

    public function __construct(Ticket $ticket, string $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }
}
