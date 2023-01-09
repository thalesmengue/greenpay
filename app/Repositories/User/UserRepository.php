<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::all();
    }

    public function find($id): Collection
    {
        return User::find($id);
    }

    public function destroy($id): int
    {
        return User::destroy($id);
    }
}
