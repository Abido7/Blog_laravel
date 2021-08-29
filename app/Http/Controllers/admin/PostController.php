<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\Monthly;
use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'DESC')->get();
        return view('admin.posts.index', compact('posts'));
    }
}