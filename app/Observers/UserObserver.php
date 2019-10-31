<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    public function saving(User $user)
    {
        if (empty($user->avatar)) {
            $user->avatar = 'https://www.mi360.cn/imgs/default/face.jpg';
        }
    }
}
