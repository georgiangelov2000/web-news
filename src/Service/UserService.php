<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\PostRepository;

class UserService
{
    protected $users;
    protected $posts;

    public function __construct(UserRepository $users, PostRepository $posts)
    {
        $this->users = $users;
        $this->posts = $posts;
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

    public function findByUserId($userId)
    {
        return $this->posts->findByUserId($userId);
    }
}