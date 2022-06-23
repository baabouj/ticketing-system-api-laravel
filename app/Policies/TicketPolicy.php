<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function owner(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id;
    }

    /**
     * @param User $user
     * @param Ticket $ticket
     * @return bool
     */
    public function adminOrOwner(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id || $user->role == "admin";
    }


}
