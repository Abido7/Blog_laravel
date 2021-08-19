<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => !$user->status
        ]);
        return back();
    }
}