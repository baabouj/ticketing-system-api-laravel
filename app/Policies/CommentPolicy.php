<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function author(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }
}
