<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $comment = Comment::create([
            'ticket_id' => $ticketId,
            'user_id' => auth()->id(),
            'message' => $request->message
        ]);

        return response()->json($comment, 201);
    }
}