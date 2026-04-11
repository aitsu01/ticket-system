<?php

namespace App\Http\Controllers\API;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\TicketService;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

use App\Http\Resources\TicketResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketCreatedMail;
use App\Helpers\Audit;
use App\Models\User;

class TicketController extends Controller
{
    protected $service;

    public function __construct(TicketService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
{
    $query = Ticket::query()->with(['user', 'agent']);

    

    if ($request->filled('search')) {

    $search = trim($request->search);

    $query->where(function ($q) use ($search) {

        //  testo
        $q->where('title', 'like', "%{$search}%")
          ->orWhere('description', 'like', "%{$search}%");

        //  numero puro
        if (is_numeric(str_replace('#', '', $search))) {
            $id = (int) str_replace('#', '', $search);
            $q->orWhere('id', $id);
        }
    });
}
   

   




    //  STATUS
    if ($request->status) {
        $query->where('status', $request->status);
    }

    //  MY TICKETS
    if ($request->my_tickets) {
        $query->where('user_id', auth()->id());
    }

    //  ASSIGNED TO ME
    if ($request->assigned_to_me) {
        $query->where('assigned_to', auth()->id());
    }

    $tickets = $query->latest()->get();

    return TicketResource::collection($tickets);
}

   




public function store(Request $request)
{
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'priority' => 'required'
    ]);

    $ticket = Ticket::create([
        'title' => $request->title,
        'description' => $request->description,
        'priority' => $request->priority,
        'user_id' => auth()->id(),
        'status' => 'open'
    ]);

    // 🔥 recupera utente corrente (più sicuro)
    $user = auth()->user();

    // ========================
    // EMAIL USER
    // ========================
    Mail::to($user->email)
        ->queue(new TicketCreatedMail($ticket));

    // ========================
    // EMAIL ADMIN
    // ========================
    $admins = User::where('role', 'admin')
        ->where('is_active', true)
        ->get();

    foreach ($admins as $admin) {

        // 🚫 evita mandare email a se stesso
        if ($admin->id === $user->id) continue;

        Mail::to($admin->email)
            ->queue(new TicketCreatedMail($ticket));
    }

    // ========================
    // AUDIT
    // ========================
    Audit::log($user, 'ticket_created', [
        'ticket_id' => $ticket->id
    ]);

    return response()->json([
        'message' => 'Ticket created successfully',
        'data' => $ticket
    ]);
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
