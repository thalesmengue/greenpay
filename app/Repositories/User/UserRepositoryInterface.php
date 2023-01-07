<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function all();
    public function find($id);
    public function create($data);
    public function update($data, $id);
    public function destroy($id);
}
