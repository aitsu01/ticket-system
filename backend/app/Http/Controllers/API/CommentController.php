<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Ticket;



class CommentController extends Controller
{
    use AuthorizesRequests;
   public function store(StoreCommentRequest $request, $ticketId)
{
    $this->authorize('create', Comment::class);

    $ticket = Ticket::findOrFail($ticketId);

    // 🚫 BLOCCO COMMENTI
    if (in_array($ticket->status, ['resolved', 'closed'])) {
        return response()->json([
            'message' => 'Cannot add comments to closed/resolved tickets'
        ], 403);
    }

    $comment = Comment::create([
        'ticket_id' => $ticketId,
        'user_id' => auth()->id(),
        'message' => $request->validated()['message']
    ]);

    return new CommentResource($comment);
}



}