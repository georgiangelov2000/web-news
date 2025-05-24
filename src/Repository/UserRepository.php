<?php

namespace App\Repository;

use App\Database\Models\User;

class UserRepository
{
    public function paginate($page = 1, $perPage = 10, $filters = [])
    {
        return User::paginate($page, $perPage, $filters);
    }

    // Add this method to your UserRepository
    public function getUserByUsernameOrEmail($username, $email)
    {
        return User::getUserByUsernameOrEmail($username, $email);
    }

    public function createUser($data)
    {
        return User::createUser($data);
    }
}