<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;

use App\Models\Ticket;



class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, $ticketId)
{
    $this->authorize('create', Comment::class);

    $ticket = \App\Models\Ticket::findOrFail($ticketId);

    $comment = $ticket->comments()->create([
        'user_id' => auth()->id(),
        'message' => $request->validated()['message']
    ]);

    $comment->load('user');

    return new CommentResource($comment);
}
}