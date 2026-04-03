<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'message' => $this->message,

        'user' => [
            'id' => $this->user->id,
            'name' => $this->user->name,
        ],
    ];
}
}
