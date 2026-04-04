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

        //  ticket number
        'ticket_number' => '#' . $this->id,

        //  date
        'created_at' => $this->created_at?->format('d/m/Y H:i'),

        //  creator (SAFE + CONSISTENTE)
        'user' => $this->whenLoaded('user', function () {
            return [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ];
        }),

        //  agent (coerente con user)
        'agent' => $this->whenLoaded('agent', function () {
            return [
                'id' => $this->agent->id,
                'name' => $this->agent->name,
            ];
        }),

        //  commenti (ONLY IF LOADED)
        'comments' => CommentResource::collection(
            $this->whenLoaded('comments')
        ),
    ];
}
}
