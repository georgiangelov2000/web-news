<?php

namespace App\Controller;

use App\Service\PostService;
use App\Repository\PostRepository;
use App\Session\Session;

class PostsApiController extends ApiController
{
    protected $postService;
    private $perPage = 10;
    private $currentPage = 1;
    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->setResource('posts');
        $this->setCacheDir('posts');
        $this->postService = new PostService(new PostRepository());
        $this->session = new Session(__DIR__ . '/../../../storage/session');

    }

    // HTML API: GET /api/posts
    public function index(array $request)
    {
        $page = $request['identifier'];

        if ($page) {
            $this->currentPage = (int) $page;
            $relativePath = $this->cacheDir . '/' . $page . '.html';
        } else {
            $relativePath = $this->cacheDir . '.html';
        }

        $data = $this->postService->getPaginatedPosts(
            $this->currentPage,
            $this->perPage
        );

        // Check if the data is already cached
        if ($this->cache->has($relativePath)) {
            echo $this->cache->get($relativePath);
            return;
        }

        $html = $this->view->render('posts', $data);
        $this->cache->set($relativePath, $html);

        echo $html;
    }

    // Render single post as HTML and cache it
    // HTML API: GET /api/posts/<alias>||<id>
    public function show($request)
    {
        // Extract alias from route params
        $alias = $request['identifier'] ?? null;
        if (!$alias) {
            http_response_code(400);
            echo "Missing post alias";
            return;
        }

        $relativePath = $this->cacheDir . '/' . $alias . '.html';

        // Serve from cache if available
        if ($this->cache->has($relativePath)) {
            echo $this->cache->get($relativePath);
            return;
        }

        // Retrieve post by alias (or ID if necessary)
        $post = $this->postService->getPost($alias);
        
        if (!$post) {
            http_response_code(404);
            echo "Post not found";
            return;
        }

        // Prepare data for the view (you may want to adapt this)
        $data = ['post' => $post];

        // Render HTML for the single post
        $html = $this->view->render('post', $data);

        // Cache the result
        $this->cache->set($relativePath, $html);

        echo $html;
    }


    // POST /posts/{id}/favorite
    public function favorite(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            http_response_code(400);
            echo 'Missing post ID';
            return;
        }

        // Get the array of favorited post IDs for this session
        $favorites = $this->session->get('favorite_posts', []);

        if (in_array($postId, $favorites)) {
            // Unfavorite if already favorited
            $favorites = array_diff($favorites, [$postId]);
            $favorited = false;
        } else {
            $favorites[] = $postId;
            $favorited = true;
        }
        $this->session->set('favorite_posts', array_values($favorites));

        echo json_encode(['status' => 'success', 'favorited' => $favorited]);
    }

    // POST /posts/{id}/like
    public function like(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            http_response_code(400);
            echo 'Missing post ID';
            return;
        }

        // Prevent disliking and liking at the same time
        $liked = $this->session->get('liked_posts', []);
        $disliked = $this->session->get('disliked_posts', []);
        if (!in_array($postId, $liked)) {
            $liked[] = $postId;
        }
        // Remove from disliked if present
        $disliked = array_diff($disliked, [$postId]);
        $this->session->set('liked_posts', array_values($liked));
        $this->session->set('disliked_posts', array_values($disliked));

        echo json_encode(['status' => 'success', 'liked' => true]);
    }

    // POST /posts/{id}/dislike
    public function dislike(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            http_response_code(400);
            echo 'Missing post ID';
            return;
        }

        // Prevent liking and disliking at the same time
        $liked = $this->session->get('liked_posts', []);
        $disliked = $this->session->get('disliked_posts', []);
        if (!in_array($postId, $disliked)) {
            $disliked[] = $postId;
        }
        // Remove from liked if present
        $liked = array_diff($liked, [$postId]);
        $this->session->set('disliked_posts', array_values($disliked));
        $this->session->set('liked_posts', array_values($liked));

        echo json_encode(['status' => 'success', 'disliked' => true]);
    }

    // GET /posts/{id}/share
    public function share(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            http_response_code(400);
            echo 'Missing post ID';
            return;
        }

        $post = $this->postService->getById($postId);
        if (!$post) {
            http_response_code(404);
            echo 'Post not found';
            return;
        }

        // Simple modal/page with share info (implement this view as needed)
        echo $this->view->render('post_share', ['post' => $post]);
    }

    // POST /posts/{id}/report
    public function report(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            http_response_code(400);
            echo 'Missing post ID';
            return;
        }

        // Store reported post IDs in session (no backend moderation)
        $reports = $this->session->get('reported_posts', []);
        if (!in_array($postId, $reports)) {
            $reports[] = $postId;
        }
        $this->session->set('reported_posts', array_values($reports));

        // Optionally save a reason
        $reason = $_POST['reason'] ?? 'Inappropriate content';

        echo json_encode(['status' => 'success', 'reported' => true, 'reason' => $reason]);
    }

    // GET /api/favourites
    public function favoritesPage()
    {
        $favIds = $this->session->get('favorite_posts', []);
        $favPosts = [];
        foreach ($favIds as $id) {
            $post = $this->postService->getPostById($id);
            if ($post) $favPosts[] = $post;
        }

        // Render the favorites page
        echo $this->view->render('favourites', ['favPosts' => $favPosts]);
    }
}