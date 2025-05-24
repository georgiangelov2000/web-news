<?php

namespace App\Repository;

use App\Database\Models\User;

class UserRepository
{
    public function paginate(int $page = 1, int $perPage = 10): array
    {
        return User::paginate($page, $perPage);
    }

    public function getUserByUsernameOrEmail(string $username, string $email): ?User
    {
        return User::getUserByUsernameOrEmail($username, $email);
    }

    public function createUser(array $data): User
    {
        return User::createUser($data);
    }

    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }
}
