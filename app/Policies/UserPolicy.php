<?php

namespace App\Policies;

use App\User;

class UserPolicy extends Policy
{

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
