<?php

namespace App\Service;

use App\Repository\PostRepository;

class PostService
{
    protected $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get paginated posts with optional search filter
     */
    public function getPaginatedPosts($page = 1, $perPage = 10, $search = '')
    {
        $filters = [];
        if (!empty($search)) {
            $filters['search'] = $search;
        }
        return $this->posts->paginate($page, $perPage, $filters);
    }

    /**
     * Get a single post by ALIAS
     */
    public function getPost($alias)
    {
        return $this->posts->find($alias);
    }

    /**
     * Get a single post by ID
     */
    public function getPostById(int $id)
    {
        return $this->posts->findById($id);
    }

    public function create(array $data)
    {
        return $this->posts->create($data);
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


}