<?php

namespace App\Repository;

use App\Database\Models\Post;

class PostRepository
{
    public function paginate($page = 1, $perPage = 10, $filters = [])
    {
        return Post::paginate($page, $perPage, $filters);
    }

    public function find($alias)
    {
        return Post::findByIdOrAlias($alias);
    }

    public function findById(int $id)
    {
        return Post::findByIdOrAlias($id);
    }
    public function findByUserId(int $userId)
    {
        return Post::findByUserId($userId);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function getComments($postId)
    {
        return Post::getComments($postId);
    }
    
    public function incrementLikes(int $postId)
    {
        return Post::incrementLikes($postId);
    }

    public function decrementLikes(int $postId)
    {
        return Post::decrementLikes($postId);
    }

    public function incrementDislikes(int $postId)
    {
        return Post::incrementDislikes($postId);
    }

    public function decrementDislikes(int $postId)
    {
        return Post::decrementDislikes($postId);
    }

    public function toggleFavorite(int $userId, int $postId)
    {
        return Post::toggleFavorite($userId, $postId);
    }

    public function getFavoritePosts(int $userId, int $page = 1, int $perPage = 10)
    {
        return Post::getFavoritePosts($userId, $page, $perPage);
    }
}