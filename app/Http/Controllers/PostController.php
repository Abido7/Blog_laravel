<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function postDetails($id)
    {
        $data['post'] = Post::with(['user', 'comments', 'images'])->findOrFail($id);
        $data['user'] = $data['post']->user;
        return view('post.show-post')->with($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // dd($request->img);
        $request->validate([
            "imgs" => "nullable|array",
            "imgs.*" => 'nullable|mimes:jpeg,png,gif,svg|max:2048',
            'caption' => "required|string|max:5000"
        ]);

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
                // dd($request->imgs[0]);
                $imgPath = Storage::disk('uploads')->put('posts', $img);
                $post->images()->create([
                    'img' => $imgPath,
                ]);
            }
        }
        // $data['user'] = $user;
        return redirect(url("/profile"));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:posts,id',
            'caption' => 'required|string',
        ]);

        $post = Post::findOrFail($request->id);
        $post->update([
            'caption' => $request->caption
        ]);
        $request->session()->flash('msg', 'Post Updated Successfully');
        return back();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'postId' => "required|exists:posts,id",
        ]);
        $post = Post::with('images')->findOrFail($request->postId);

        if (count($post->images()->get()) > 1) {
            foreach ($post->images()->get() as $img) {
                $imgPath = $img->img;
                $post->images()->delete($post);
                Storage::disk('uploads')->delete($imgPath);
                $post->delete();
                // dd($img->img);
            }
        } else {
            $imgPath = $post->images()->first()->img;
            Storage::disk('uploads')->delete($imgPath);
            $post->images()->delete($post);
            $post->delete();
        }

        return back();
    }
}