<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function create($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'document' => $data['document'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function update($data, $id)
    {
        return User::query()
            ->find($id)
            ->update($data);
    }

    public function destroy($id)
    {
        return User::destroy($id);
    }
}
