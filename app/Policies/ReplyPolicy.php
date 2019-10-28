<?php

namespace App\Policies;

use App\Reply;
use App\User;

class ReplyPolicy extends Policy
{

    public function destroy(User $user, Reply $reply)
    {
        return $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
