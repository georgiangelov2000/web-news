<?php

namespace App\Repository;
use App\Repository\BaseRepository;
use App\Database\Models\Post;

class PostRepository extends BaseRepository
{

    protected $model;
    /**
     * PostRepository constructor.
     */
    public function __construct($model = Post::class)
    {
        $this->model = $model;
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
