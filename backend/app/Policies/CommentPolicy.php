<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->isAdmin() || $comment->user_id === $user->id;
    }
}