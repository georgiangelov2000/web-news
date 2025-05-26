<?php

namespace App\Service;

use App\Repository\PostRepository;
use App\Service\BaseService;
class PostService extends BaseService
{
    protected $posts;
    public function __construct(PostRepository $posts)
    {
        parent::__construct($posts);
        $this->posts = $posts;
    }

    public function getComments($postId)
    {
        return $this->posts->getComments($postId);
    }

    public function likePost(int $postId)
    {
        return $this->posts->incrementLikes($postId);
    }

    public function unlikePost(int $postId)
    {
        return $this->posts->decrementLikes($postId);
    }

    public function dislikePost(int $postId)
    {
        return $this->posts->incrementDislikes($postId);
    }

    public function undislikePost(int $postId)
    {
        return $this->posts->decrementDislikes($postId);
    }

    public function toggleFavoriteInDb(int $userId, int $postId)
    {
        return $this->posts->toggleFavorite($userId, $postId);
    }

    public function getFavorites(int $userId, int $page = 1, int $perPage = 10)
    {
        return $this->posts->getFavoritePosts($userId, $page, $perPage);
    }

}