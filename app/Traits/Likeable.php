<?php

namespace App\Traits;



trait Likeable
{

    public function isLiked($user)
    {
        return ($this->likes()->where('user_id', $user->id)->first() != null);
    }
}