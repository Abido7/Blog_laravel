<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function addLike(Request $request, $id)
    {

        $post = Post::findOrFail($id);
        $authLikes = Auth::user()->likes()->select('likeable_id')->Pluck('likeable_id')->toArray();
        if (in_array($id, $authLikes)) {
            return back();
        }
        $post->likes()->create(['user_id' => Auth::user()->id, $post]);
        $request->session()->put('islike', 1);
        return back();
    }

    public function disLike(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->likes()->where(['user_id' => Auth::user()->id])->delete($post);
        $request->session()->put('islike', 0);
        return back();
    }
}