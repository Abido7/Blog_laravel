<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user()->load(['posts', 'posts.images', 'posts.latestComment', 'posts.latestComment.user', 'followers', 'followings']);
        return view('web.profile.index', compact('user'));
    }

    public function show($id)
    {
        $user = User::with(['followers', 'posts', 'posts.images', 'posts.latestComment', 'posts.latestComment.user'])->findOrFail($id);
        $authFollowings = Auth::user()->followings()->pluck('following_id')->toArray();
        return view('web.profile.show', compact('user', 'authFollowings'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        if ($request->hasFile('img')) {
            $imgPath = Storage::disk('uploads')->put('users', $request->img);
            $user->update([
                'bio' => $request->bio,
                'img' => $imgPath
            ]);
            // dd($request->img);
        } else {
            $user->update([
                'bio' => $request->bio,
            ]);
            // dd($request->img);
        }
        $request->session()->flash('msg', 'Your Info Updated Successfully');
        return back();
    }
}