<?php

namespace App\Policies;

use App\Topic;
use App\User;

class TopicPolicy extends Policy
{

    public function update(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->isAuthorOf($topic);
    }
}
