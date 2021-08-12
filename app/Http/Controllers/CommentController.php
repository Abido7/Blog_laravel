<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:png,jpg,gif,svg|max:2048'
        ]);

        $post = Post::findorFail($id);
        $user = Auth::user();
        if ($request->hasFile('img')) {
            $comment =  $post->Comments()->create(['user_id' => $user->id, 'body' => $request->comment]);
            $imgPath = Storage::disk('uploads')->put('comments', $request->img);
            Comment::findOrFail($comment->id)->images()->create(['img' => $imgPath, $comment]);
        } else {

            $comment = $post->Comments()->create(['user_id' => $user->id, 'body' => $request->comment]);
            // dd($comment->id);
        }
        return back();
    }
}