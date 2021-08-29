<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait DeactiveAndPromote
{
    // $user->activate()
    // $user->deactivate()
    // $user->upgrade()
    // $user->degrade()

    public function activate()
    {
        return $this->update([
            'is_active' => 1
        ]);
    }
    public function deactivate()
    {
        return $this->update([
            'is_active' => 0
        ]);
    }

    public function promote()
    {
        return $this->update([
            'role_id' => 1
        ]);
    }

    public function demote()
    {
        return $this->update([
            'role_id' => 2
        ]);
    }
}