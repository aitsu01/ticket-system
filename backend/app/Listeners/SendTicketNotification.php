<?php



namespace App\Listeners;

use App\Events\TicketUpdated;
use App\Notifications\TicketUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTicketNotification implements ShouldQueue
{
    public function handle(TicketUpdated $event)
    {
        $ticket = $event->ticket;

        $ticket->user->notify(
            new TicketUpdatedNotification($ticket, $event->message)
        );

        if ($ticket->agent) {
            $ticket->agent->notify(
                new TicketUpdatedNotification($ticket, $event->message)
            );
        }
    }
}