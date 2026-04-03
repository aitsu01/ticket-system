<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
{
    //  View singolo ticket
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->user_id === $user->id
            || $ticket->assigned_to === $user->id;
    }

    //  View list
    public function viewAny(User $user): bool
    {
        return true;
    }

    //  Create
    public function create(User $user): bool
    {
        return true;
    }

    // ✏️ Update
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->user_id === $user->id
            || $ticket->assigned_to === $user->id;
    }

    //  Delete
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin();
    }

    // ‍💻 Assign (extra importante)
    public function assign(User $user): bool
    {
        return $user->isAdmin();
    }

    //  Change status
    public function changeStatus(User $user, Ticket $ticket): bool
    {
        return $user->isAdmin()
            || $ticket->assigned_to === $user->id;
    }
}
