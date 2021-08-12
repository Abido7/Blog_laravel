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
        $user = Auth::user();
        $data['followings'] = $user->followings()->with(['posts.images', 'posts.comments'])->get();
        return view('main')->with($data);
    }
}