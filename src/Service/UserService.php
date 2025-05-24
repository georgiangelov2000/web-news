<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserService
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    // Get paginated users for the given page and perPage
    public function getPaginatedUsers($page = 1, $perPage = 10, $search = '')
    {
        $filters = [];
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        return $this->users->paginate($page, $perPage, $filters);
    }

    // Add this method to your UserService
    public function getUserByUsernameOrEmail($username, $email)
    {
        return $this->users->getUserByUsernameOrEmail($username, $email);
    }

    public function create(array $data)
    {
        return $this->users->createUser($data);
    }
    
    // Get user by id
    public function getUserById($id)
    {
        return $this->users->getUserById($id);
    }

    // // Create a new user
    // public function create(array $data)
    // {
    //     return $this->users->createUser($data);
    // }

    // // Update user by id
    // public function update($id, array $data)
    // {
    //     return $this->users->updateUser($id, $data);
    // }

    // // Delete user by id
    // public function delete($id)
    // {
    //     return $this->users->deleteUser($id);
    // }
}