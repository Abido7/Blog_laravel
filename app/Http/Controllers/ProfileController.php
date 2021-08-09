<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {

        $data = [
            'user' => Auth::user(),
            'posts' => Auth::user()->posts()->with('comments')->orderBy('id', 'desc')->get(),
        ];
        return view('profile.index')->with($data);
    }


    public function showUser(User $user)
    {
        $data['user'] = $user;
        return view('profile.show')->with($data);
    }

    public function followings(User $user)
    {
        $data['followings'] = $user->followings()->orderBy('created_at', "DESC")->get();
        return view('profile.followings')->with($data);
    }
}