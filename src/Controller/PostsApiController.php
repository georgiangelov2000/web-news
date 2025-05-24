<?php

namespace App\Controller;

use App\Database\Models\Comment;
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
            http_response_code(200);
            echo $this->cache->get($relativePath);
            return;
        }

        // Favourite posts
        $favIds = $this->session->get('favorite_posts', []);
        $data['favIds'] = $favIds;

        // Liked and disliked posts
        $liked = $this->session->get('liked_posts', []);
        $disliked = $this->session->get('disliked_posts', []);
        $data['liked'] = $liked;
        $data['disliked'] = $disliked;

        $html = $this->view->render('posts', $data);
        $this->cache->set($relativePath, $html);

        http_response_code(200);
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
            http_response_code(200);
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

        // Get comments for the post
        $comments = $this->postService->getComments($post->id);
        $data['comments'] = $comments;

        // Get the current user's favorite post IDs from the session
        $favIds = $this->session->get('favorite_posts', []);
        $data['favIds'] = $favIds;

        // Render HTML for the single post
        $html = $this->view->render('post', $data);

        // Cache the result
        $this->cache->set($relativePath, $html);
        http_response_code(200);

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

        http_response_code(200);
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
        $isLiked = in_array($postId, $liked);

        if (!$isLiked) {
            $liked[] = $postId;
            $this->postService->likePost((int) $postId);
        }

        // Remove from disliked if present
        if (in_array($postId, $disliked)) {
            $disliked = array_diff($disliked, [$postId]);
            $this->postService->undislikePost((int) $postId);
        }

        // Remove from disliked if present
        $this->session->set('liked_posts', array_values($liked));
        $this->session->set('disliked_posts', array_values($disliked));

        // Fetch updated counts
        $post = $this->postService->getPostById((int) $postId);
        $likes = (int) ($post->likes ?? 0);
        $dislikes = (int) ($post->dislikes ?? 0);

        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'liked' => true,
            'likes' => $likes,
            'dislikes' => $dislikes
        ]);
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
        $isDisliked = in_array($postId, $disliked);

        if (!$isDisliked) {
            $disliked[] = $postId;
            $this->postService->dislikePost((int) $postId);
        }
        // Remove from liked if present
        if (in_array($postId, $liked)) {
            $liked = array_diff($liked, [$postId]);
            $this->postService->unlikePost((int) $postId);
        }

        $this->session->set('disliked_posts', array_values($disliked));
        $this->session->set('liked_posts', array_values($liked));

        // Fetch updated counts
        $post = $this->postService->getPostById((int) $postId);
        $likes = (int) ($post->likes ?? 0);
        $dislikes = (int) ($post->dislikes ?? 0);

        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'disliked' => true,
            'likes' => $likes,
            'dislikes' => $dislikes
        ]);
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

        http_response_code(200);
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

        http_response_code(200);
        echo json_encode(['status' => 'success', 'reported' => true, 'reason' => $reason]);
    }

    // GET /api/posts/favourites?page=1
    public function favoritesPage(array $request = [])
    {
        // Get the page number from the request, default to 1
        $page = isset($request['page']) && is_numeric($request['page']) ? (int) $request['page'] : 1;
        $perPage = 5; // Number of favorites per page

        // Get favorited post IDs from session
        $favIds = $this->session->get('favorite_posts', []);
        if (!is_array($favIds))
            $favIds = [];

        // Pagination calculations
        $totalItems = count($favIds);
        $totalPages = max(1, ceil($totalItems / $perPage));
        $page = min(max($page, 1), $totalPages);

        // Slice the favorites for the current page
        $favIdsPage = array_slice($favIds, ($page - 1) * $perPage, $perPage);

        $favPosts = [];
        foreach ($favIdsPage as $id) {
            $post = $this->postService->getPostById($id);
            if ($post)
                $favPosts[] = $post;
        }

        // Pass pagination info to the view
        $data = [
            'favPosts' => $favPosts,
            'favIds' => $favIds,
            'current_page' => $page,
            'per_page' => $perPage,
            'total_items' => $totalItems,
            'total_pages' => $totalPages,
        ];

        http_response_code(200);
        echo $this->view->render('favourites', $data);
    }

    public function createForm(): void
    {
        http_response_code(200);
        echo $this->view->render('create_post');
    }

    public function store(array $request): void
    {
        $title = trim($request['title'] ?? '');
        $body = trim($request['body'] ?? '');

        if (empty($title) || empty($body)) {
            echo $this->view->render('create_post', [
                'error' => 'Title and body are required.',
                'old' => $request,
            ]);
            return;
        }

        $this->postService->create([
            'userId' => 1, // Assume a logged-in user or default for now
            'title' => $title,
            'body' => $body,
        ]);

        http_response_code(302);
        header('Location: /posts');
        exit;
    }

    public function storeComment(array $request): void
    {
        $body = trim(string: $_POST['body'] ?? '');
        $id = $request['id'] ?? null;
        $username = $_SESSION['user_name'] ?? 'Guest'; // Replace with actual session logic

        if (empty($body)) {
            http_response_code(422);
            echo json_encode(['error' => 'Comment body is required.']);
            return;
        }

        Comment::create([
            'post_id' => $id,
            'username' => $username,
            'body' => $body,
        ]);

        http_response_code(201);
        echo json_encode(['success' => true, 'username' => $username, 'created_at' => date('Y-m-d H:i'), 'body' => $body]);
    }

}