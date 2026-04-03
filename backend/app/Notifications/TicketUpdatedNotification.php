<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ticket;

use Illuminate\Contracts\Queue\ShouldQueue;



class TicketUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ticket;
    protected $message;

    public function __construct(Ticket $ticket, string $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    \Log::info('EMAIL TRIGGERED', [
        'ticket' => $this->ticket->id,
        'message' => $this->message
    ]);

    return (new MailMessage)
        ->subject('Ticket Update')
        ->line($this->message)
        ->line('Ticket: ' . $this->ticket->title);
}
}