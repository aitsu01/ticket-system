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
    $this->authorize('view', $ticket);

    $ticket->load(['user', 'agent', 'comments.user']);

    return new TicketResource($ticket);
}
 public function update(UpdateTicketRequest $request, Ticket $ticket)
{
    $this->authorize('update', $ticket);

    return $this->service->update($ticket, $request->validated());
}

    public function destroy(Ticket $ticket)
{
    $this->authorize('delete', $ticket);

    $ticket->delete();

    return response()->json(['message' => 'Deleted']);
}
}
