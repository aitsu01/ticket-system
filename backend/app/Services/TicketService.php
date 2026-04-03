<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function update(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);
        return $ticket;
    }

    public function assign(Ticket $ticket, int $agentId): Ticket
    {
        $ticket->update([
            'assigned_to' => $agentId
        ]);

        return $ticket;
    }

    public function changeStatus(Ticket $ticket, string $status): Ticket
    {
        $ticket->update([
            'status' => $status
        ]);

        return $ticket;
    }
}