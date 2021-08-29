<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Followable
{
    // Auth::user()->follow($user)
    // Auth::user()->unfollow($user)

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followings', 'user_id', "following_id")->where('is_active', '=', 1)->withPivot('is_following')->withTimestamps()->orderByPivot('id', 'DESC');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followings', "following_id", 'user_id')->where('is_active', '=', 1)->withTimestamps()->orderByPivot('id', 'DESC');
    }

    public function follow($user)
    {
        return $this->followings()->attach($user->id);
    }

    public function unfollow($user)
    {
        // dd($user);
        return $this->followings()->detach($user->id);
    }

    public function isFollowing(Model $user)
    {
        $followingsList =  $this->followings()->pluck('following_id')->toArray();

        return in_array($user->id, $followingsList);
    }
}