<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Traits\Monthly;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use Monthly;


    public function index()

    {
        $posts = Post::with(['likes', 'comments'])->withCount(['likes', 'comments'])->orderBy('likes_count', 'Desc')->orderBy('comments_count', 'Desc')->limit(5)->get();
        $users = User::count();
        $comments = Comment::count();
        $likes = Like::count();
        $postsChart = LarapexChart::lineChart()
            ->setTitle('Monthly Posts for 2021')
            ->addData(
                'Published posts',
                $this->Monthly(Post::class)
            )
            ->setColors(['#09c'])
            ->setColors(['#333'])
            ->setXAxis($this->allMonthes);
        // =====================================
        return view('admin.home.index', compact('posts', 'users', 'comments', 'likes', 'postsChart'));
    }
}