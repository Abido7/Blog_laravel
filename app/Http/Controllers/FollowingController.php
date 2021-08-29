<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowingController extends Controller
{

    public function store(Request $request)
    {
        $user =  User::findOrFail($request->follow);
        Auth::user()->follow($user);
        return back();
    }

    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->unfollowed);
        Auth::user()->unfollow($user);
        return back();
    }

    public function followings(User $user)
    {
        $user = $user->load('followings');
        return view('web.profile.followings', compact('user'));
    }


    public function followers(User $user)
    {
        $user = $user->load('followers');
        return view('web.profile.followers', compact('user'));
    }
}