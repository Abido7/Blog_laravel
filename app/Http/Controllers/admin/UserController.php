<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToggleStatusRequest;
use App\Models\Role;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function index()
    {
        $users = User::with(['role', 'country'])->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user = $user->load(['role', 'country']);
        return view('admin.users.show', compact('user'));
    }


    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }

    // $user->deactivate()

    public function active(User $user)
    {
        $user->activate();
        return back();
    }

    public function deactive(User $user)
    {
        $user->deactivate();
        return back();
    }

    public function promote(User $user)
    {
        $user->promote();
        return back();
    }

    public function demote(User $user)
    {
        $user->demote();
        return back();
    }

    // public function toggleStatus(ToggleStatusRequest $request)
    // {
    //     $user = User::findOrFail($request->userId);
    //     $user->update([
    //         'status' => !$user->status
    //     ]);
    //     return back();
    // }

    // public function toggleRole(ToggleStatusRequest $request)
    // {
    //     $user = User::findOrFail($request->userId);

    //     $adminRoleId = Role::where('name', 'admin')->first()->id;
    //     $userRoleId = Role::where('name', 'user')->first()->id;
    //     $id = $user->role->id == $adminRoleId  ? $userRoleId : $adminRoleId;
    //     $user->update([
    //         'role_id' => $id
    //     ]);
    //     return back();
    // }
}