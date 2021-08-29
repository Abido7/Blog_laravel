<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class PostController extends Controller
{


    public function show(Post $post)
    {
        $post = $post->load(['comments.user', 'comments.images', 'likes']);
        if ($post->user == null) {
            return redirect(url('/'));
        }
        return view('web.post.show-post', compact('post'));
    }

    public function store(StorePostRequest $request)
    {
        $user = Auth::user();
        if (count($request->imgs) <= 1) {
            $post = Post::create([
                'caption' => $request->caption,
                'user_id' => $user->id,
            ]);
            $imgPath = $request->imgs[0];
            $imgPath = Storage::disk('uploads')->put('posts', $imgPath);
            $post->images()->create([
                'img' => $imgPath,
            ]);
        } else {
            $post = Post::create([
                'caption' => $request->caption,
                'user_id' => $user->id,
            ]);
            foreach ($request->imgs as $img) {
                $imgPath = Storage::disk('uploads')->put('posts', $img);
                $post->images()->create([
                    'img' => $imgPath,
                ]);
            }
        }
        return redirect(url("/profile"));
    }

    public function update(UpdatePostRequest $request)
    {
        $post = Post::findOrFail($request->id);
        $post->update([
            'caption' => $request->caption
        ]);
        $request->session()->flash('msg', 'Post Updated Successfully');
        return back();
    }

    public function destroy(DestroyPostRequest $request)
    {
        $post = Post::findOrFail($request->postId);
        //delete nested morph (images) relation
        // dd($post->deletedComment());
        // $post->deletedComment()->images()->delete();
        $post->delete();
        $post->deleteMorphResidual();

        return back();
    }
}