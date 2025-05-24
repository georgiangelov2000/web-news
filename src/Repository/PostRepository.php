<?php

namespace App\Repository;

use App\Database\Models\Post;

class PostRepository
{
    public function paginate(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        return Post::paginate($page, $perPage);
    }

    public function find($alias): ?Post
    {
        return Post::findByIdOrAlias($alias);
    }

    public function findById(int $id): ?Post
    {
        return Post::findByIdOrAlias($id);
    }

    public function findByUserId(int $userId): array
    {
        return Post::findByUserId($userId);
    }

    public function create(array $data): int
    {
        return Post::create($data);
    }

    public function getComments(int $postId): array
    {
        return Post::getComments($postId);
    }

    public function incrementLikes(int $postId): bool
    {
        return Post::incrementLikes($postId);
    }

    public function decrementLikes(int $postId): bool
    {
        return Post::decrementLikes($postId);
    }

    public function incrementDislikes(int $postId): bool
    {
        return Post::incrementDislikes($postId);
    }

    public function decrementDislikes(int $postId): bool
    {
        return Post::decrementDislikes($postId);
    }

    public function toggleFavorite(int $userId, int $postId): bool
    {
        return Post::toggleFavorite($userId, $postId);
    }

    public function getFavoritePosts(int $userId, int $page = 1, int $perPage = 10, array $columns = ['*']): array
    {
        return Post::getFavoritePosts($userId, $page, $perPage, $columns);
    }
}
