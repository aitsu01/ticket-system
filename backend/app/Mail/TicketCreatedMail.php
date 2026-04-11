<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TicketCreatedMail extends Mailable
{
    public $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this
            ->subject(' Ticket Created #' . $this->ticket->ticket_number)
            ->view('emails.ticket_created');
    }
}