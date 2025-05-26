<?php

namespace App\Repository;

use App\Database\Models\User;
use App\Repository\BaseRepository;
class UserRepository extends BaseRepository
{
    protected $model;
    /**
     * UserRepository constructor.
     */
    public function __construct($model = User::class)
    {
        $this->model = $model;
    }

    public function getUserByUsernameOrEmail(string $username, string $email): ?User
    {
        return User::getUserByUsernameOrEmail($username, $email);
    }

    public function find($id) {
        return $this->model::find($id);
    } 
}
