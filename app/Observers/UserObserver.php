<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user): void
    {
        $document = request()->input('document');

        $role = match (strlen($document)) {
            11 => 'common',
            14 => 'shopkeeper'
        };

        $user->role = $role;
        $user->id = Str::uuid();
    }

    public function created(User $user): void
    {
        $user->wallet()->create([
            'id' => Str::uuid(),
            'balance' => rand(10, 1000),
            'keeper_id' => $user->id
        ]);
    }
}
