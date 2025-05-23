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
     * Get a single post by ID
     */
    public function getPost($alias)
    {
        return $this->posts->find($alias);
    }
}