<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function index()
    {
        // dd();
        $data = [
            'user' => Auth::user(),
            'posts' => Auth::user()->posts()->with(['images', 'comments'])->orderBy('id', 'desc')->get(),
            'followers' => DB::table('followings')->distinct()->select('user_id')->distinct()->where('following_id', '=', Auth::user()->id)->count()
        ];
        return view('profile.index')->with($data);
    }


    public function showUser($id)
    {
        $data['user'] = User::with(['posts', 'posts.images', 'posts.comments'])->findOrFail($id);
        $data['authFollowing'] = Auth::user()->followings()->pluck('following_id')->toArray();
        $data['posts'] = $data['user']->posts;
        return view('profile.show')->with($data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'bio' => 'required|string|max:255',
            'img' => 'nullable|dimensions:min_width=500,min_height=500|mimes:jpeg,png,jpg|max:2048'
        ]);
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
            dd($request->img);
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
        // dd($request->all());
        $t = $request->validate([
            'unfollowed' => "required|exists:followings,following_id"
        ]);
        Auth::user()->followings()->detach($request->unfollowed);
        return back();
    }

    public function followings(User $user)
    {
        $data['user'] = $user;
        $data['followings'] = $user->followings()->orderBy('created_at', "DESC")->get();
        $data['authFollowing'] = Auth::user()->followings()->pluck('following_id')->toArray();
        return view('profile.followings')->with($data);
    }


    public function followers(User $user)
    {
        // dd($data['followers']);
        $data['user'] = $user;
        $followersId = DB::table('followings')->distinct()->select('*')
            ->distinct()->where('following_id', '=', $user->id)
            ->pluck('user_id')->toArray();
        $data['followers'] = User::whereIn('id', $followersId)->get();
        // dd($authFollowers);

        return view('profile.followers')->with($data);
    }
}