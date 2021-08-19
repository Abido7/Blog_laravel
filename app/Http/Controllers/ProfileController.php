<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user()->load(['posts', 'posts.images', 'posts.latestComment', 'posts.latestComment.user', 'followers', 'followings']);
        return view('profile.index', compact('user'));
    }

    public function show($id)
    {
        $user = User::with(['followers', 'posts', 'posts.images', 'posts.latestComment', 'posts.latestComment.user'])->findOrFail($id);
        $authFollowings = Auth::user()->followings()->pluck('following_id')->toArray();
        return view('profile.show', compact('user', 'authFollowings'));
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

    public function follow(Request $request)
    {
        $request->validate([
            'follow' => "required|exists:users,id",
        ]);
        Auth::user()->followings()->attach($request->follow);
        return back();
    }

    public function unfollow(Request $request)
    {
        $request->validate([
            'unfollowed' => "required|exists:followings,following_id"
        ]);
        Auth::user()->followings()->detach($request->unfollowed);
        return back();
    }

    public function followings(User $user)
    {
        $user = $user->load('followings');
        $authFollowings = Auth::user()->followings()->pluck('following_id')->toArray();
        return view('profile.followings', compact('user', 'authFollowings'));
    }


    public function followers(User $user)
    {
        $user = $user->load('followers');
        $authFollowings = Auth::user()->followings()->pluck('following_id')->toArray();
        return view('profile.followers', compact('user', 'authFollowings'));
    }
}