<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,
            'description' => $this->description,

            'status' => $this->status,
            'priority' => $this->priority,

            'created_at' => $this->created_at,

            //  creator
            'user' => new UserResource($this->whenLoaded('user')),

            //  agent
            'agent' => new UserResource($this->whenLoaded('agent')),

            //  commenti
            'comments' => CommentResource::collection(
                $this->whenLoaded('comments')
            ),
        ];
    }
}
