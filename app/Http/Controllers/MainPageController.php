<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;

class MainPageController extends Controller
{
    public function index()
    {
        $user = Auth::user()
            ->load('followings', 'followings.posts', 'followings.posts.images', 'followings.posts.latestComment', 'followings.posts.latestComment.user');

        return view('main', compact('user'));
    }
}