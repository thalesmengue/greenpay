<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->id = Str::uuid();
    }
}
