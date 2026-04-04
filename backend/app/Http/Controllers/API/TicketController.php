<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

use App\Http\Resources\TicketResource;

class TicketController extends Controller
{
    protected $service;

    public function __construct(TicketService $service)
    {
        $this->service = $service;
    }

    public function index()
{
    $tickets = Ticket::with(['user', 'agent'])->latest()->get();

    return TicketResource::collection($tickets);
}

    public function store(StoreTicketRequest $request)
{
    $data = $request->validated();

    $data['user_id'] = auth()->id();

    $ticket = $this->service->create($data);

    /*return response()->json($ticket, 201);*/
    return new TicketResource($ticket);
}







public function show(Ticket $ticket)
{
    return new TicketResource(
    $ticket->load(['user', 'agent', 'comments.user'])
);
}



 public function update(UpdateTicketRequest $request, Ticket $ticket)
{
    $this->authorize('update', $ticket);

    return $this->service->update($ticket, $request->validated());
}

  public function destroy(Ticket $ticket)
{
    if (auth()->user()->role !== 'admin') {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    $ticket->delete();

    return response()->json([
        'message' => 'Ticket deleted'
    ]);
}

public function changeStatus(Request $request, Ticket $ticket)
{
    $request->validate([
        'status' => 'required|in:open,in_progress,resolved,closed'
    ]);

    $ticket->update([
        'status' => $request->status
    ]);

    return new TicketResource($ticket);
}

public function assign(Request $request, Ticket $ticket)
{
    $request->validate([
        'assigned_to' => 'required|exists:users,id'
    ]);

    $ticket->update([
        'assigned_to' => $request->assigned_to
    ]);

    return new TicketResource($ticket->load('agent'));
}



}
