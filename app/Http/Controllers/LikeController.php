<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    public function like(Post $post, Request $request)
    {
        $request->validate(['postId' => 'required|exists:posts,id']);
        $post = Post::findOrFail($request->postId);
        $authLikes = Auth::user()->likes()->select('likeable_id')->Pluck('likeable_id')->toArray();
        if (in_array($post->id, $authLikes)) {
            return back();
        }
        $post->likes()->create(['user_id' => Auth::user()->id, $post]);
        session()->put('islike', 1);
        return back();
    }

    public function unLike(Post $post)
    {
        // dd($post);
        $post->likes()->where(['user_id' => Auth::user()->id])->delete($post);
        session()->put('islike', 0);
        return back();
    }
}