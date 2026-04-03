<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    protected $service;

    public function __construct(TicketService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Ticket::with(['user', 'agent'])->latest()->get();
    }

    public function store(Request $request)
    {
        $ticket = $this->service->create($request->all());

        return response()->json($ticket, 201);
    }

    public function show(Ticket $ticket)
    {
        return $ticket->load(['user', 'agent', 'comments.user']);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $ticket = $this->service->update($ticket, $request->all());

        return response()->json($ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
