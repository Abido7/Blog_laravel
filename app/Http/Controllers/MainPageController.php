<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainPageController extends Controller
{
    public function index()
    {
        $currentUserId = Auth::user()->id;
        $data['followings'] = User::findOrFail($currentUserId)->followings;
        // dd($data['followings']);
        // $data['posts'] = Post::with('comments')->whereIn('user_id', $data['followings']);

        // dd($data['posts']);
        return view('main')->with($data);
    }
}