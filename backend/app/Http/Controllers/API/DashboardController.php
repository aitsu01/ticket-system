<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'total' => Ticket::count(),

            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),

            'by_agent' => $this->ticketsByAgent()
        ]);
    }

    protected function ticketsByAgent()
    {
        return User::where('role', 'agent')
            ->withCount('assignedTickets')
            ->get()
            ->map(function ($user) {
                return [
                    'agent' => $user->name,
                    'count' => $user->assigned_tickets_count
                ];
            });
    }
}