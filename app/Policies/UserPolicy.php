<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     *
     * @param User $user
     * @return bool
     */
    public function admin(User $user): bool
    {
        return $user->role == "admin";
    }

    /**
     *
     * @param User $user
     * @return bool
     */
    public function tickets(User $user,User $model): bool
    {
        return $user->role == "admin" || $user->id == $model->id;
    }


}
