<?php

namespace App\Controller;

use App\Database\Models\Comment;
use App\Service\PostService;
use App\Repository\PostRepository;
use App\Session\Session;
use App\Security\SessionGuard;

class PostController extends ApiController
{
    protected PostService $postService;
    private int $perPage = 10;
    private int $currentPage = 1;
    protected $session;
    protected $guard;

    public function __construct()
    {
        parent::__construct();
        $this->setResource('posts');
        $this->setCacheDir('posts');
        $this->postService = new PostService(new PostRepository());
        $this->session = $GLOBALS['session'];
        $this->guard = new SessionGuard($this->session);
    }

    // List posts: GET /posts
    public function index(array $request)
    {
        $currentPage = isset($request['identifier']) ? (int)$request['identifier'] : 1;
        $posts = $this->postService->paginate($currentPage, $this->perPage);

        $userId = $this->session->get('user_id');
        $favIds = $userId 
            ? $this->postService->getFavorites($userId)
            : $this->session->get('favorite_posts', []);

        $data = [
            ...$posts,
            'favIds'    => $favIds,
            'liked'     => $this->session->get('liked_posts', []),
            'disliked'  => $this->session->get('disliked_posts', []),
        ];

        http_response_code(200);
        echo $this->view->render('posts', $data);
    }
      

    // Show single post: GET /posts/{alias}
    public function show(array $request)
    {
        $alias = $request['identifier'] ?? null;
        if (!$alias) {
            http_response_code(400);
            echo "Missing post alias";
            return;
        }

        $cacheKey = "post/{$alias}.html";
        if ($this->cache->has($cacheKey)) {
            http_response_code(200);
            echo $this->cache->get($cacheKey);
            return;
        }

        $post = $this->postService->find($alias);
        if (!$post) {
            http_response_code(404);
            echo "Post not found";
            return;
        }

        $userId = $this->session->get('user_id');
        $favIds = $userId
            ? $this->postService->getFavorites($userId)
            : $this->session->get('favorite_posts', []);

        $data = [
            'post'     => $post,
            'comments' => $this->postService->getComments($post->id),
            'favIds'   => $favIds,
        ];

        $html = $this->view->render('post', $data);
        $this->cache->set($cacheKey, $html);
        http_response_code(200);
        echo $html;
    }


    // POST /posts/{id}/favorite
    public function favorite(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId || !is_numeric($postId)) {
            return jsonError('Missing or invalid post ID', 400);
        }

        $userId = $this->session->get('user_id');
        if ($userId) {
            $isNowFavorited = $this->postService->toggleFavoriteInDb($userId, (int)$postId);
            return jsonSuccess(['favorited' => $isNowFavorited]);
        }

        // Guest: session
        $favorites = $this->session->get('favorite_posts', []);
        if (in_array($postId, $favorites)) {
            $favorites = array_diff($favorites, [$postId]);
            $favorited = false;
        } else {
            $favorites[] = $postId;
            $favorited = true;
        }
        $this->session->set('favorite_posts', array_values($favorites));
        return jsonSuccess(['favorited' => $favorited]);
    }
    

    // POST /posts/{id}/like
    public function like(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            return jsonError('Missing post ID', 400);
        }

        // Prevent disliking and liking at the same time
        $liked = $this->session->get('liked_posts', []);
        $disliked = $this->session->get('disliked_posts', []);

        if (!in_array($postId, $liked)) {
            $liked[] = $postId;
            $this->postService->likePost((int)$postId);
        }
        if (in_array($postId, $disliked)) {
            $disliked = array_diff($disliked, [$postId]);
            $this->postService->undislikePost((int)$postId);
        }

        $this->session->set('liked_posts', array_values($liked));
        $this->session->set('disliked_posts', array_values($disliked));
        $post = $this->postService->find((int)$postId);

        http_response_code(200);
        return jsonSuccess([
            'liked'    => true,
            'likes'    => (int)($post->likes ?? 0),
            'dislikes' => (int)($post->dislikes ?? 0)
        ]);
    }

    // Dislike post: POST /posts/{id}/dislike
    public function dislike(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            return jsonError('Missing post ID', 400);
        }

        $liked = $this->session->get('liked_posts', []);
        $disliked = $this->session->get('disliked_posts', []);

        if (!in_array($postId, $disliked)) {
            $disliked[] = $postId;
            $this->postService->dislikePost((int)$postId);
        }
        if (in_array($postId, $liked)) {
            $liked = array_diff($liked, [$postId]);
            $this->postService->unlikePost((int)$postId);
        }

        $this->session->set('disliked_posts', array_values($disliked));
        $this->session->set('liked_posts', array_values($liked));
        $post = $this->postService->find((int)$postId);

        return jsonSuccess([
            'disliked' => true,
            'likes'    => (int)($post->likes ?? 0),
            'dislikes' => (int)($post->dislikes ?? 0)
        ]);
    }

    // Share post: GET /posts/{id}/share
    public function share(array $params)
    {
        $postId = $params['id'] ?? null;
        if (!$postId) {
            http_response_code(400);
            echo 'Missing post ID';
            return;
        }

        $post = $this->postService->find($postId);
        if (!$post) {
            http_response_code(404);
            echo 'Post not found';
            return;
        }

        http_response_code(200);
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
        $page = isset($request['page']) && is_numeric($request['page']) ? (int)$request['page'] : 1;
        $perPage = 5;

        $favIds = $this->session->get('favorite_posts', []) ?: [];
        $totalItems = count($favIds);
        $totalPages = max(1, ceil($totalItems / $perPage));
        $page = min(max($page, 1), $totalPages);
        $favIdsPage = array_slice($favIds, ($page - 1) * $perPage, $perPage);

        $favPosts = array_filter(array_map(fn($id) => $this->postService->find($id), $favIdsPage));

        $data = [
            'favPosts'     => $favPosts,
            'favIds'       => $favIds,
            'current_page' => $page,
            'per_page'     => $perPage,
            'total_items'  => $totalItems,
            'total_pages'  => $totalPages,
        ];

        http_response_code(200);
        echo $this->view->render('favourites', $data);
    }

    public function createForm(): void
    {
        $isAuthenticated = $this->guard->isAuthenticated();
        if (!$isAuthenticated) {
            header('Location: /login', true, 302);
            exit;
        }
        
        http_response_code(200);
        echo $this->view->render('create_post');
    }

    public function store(array $request): void
    {
        $title = trim($request['title'] ?? '');
        $body = trim($request['body'] ?? '');

        if (empty($title) || empty($body)) {
            http_response_code(422);
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
        $body = trim($_POST['body'] ?? '');
        $id = $request['id'] ?? null;
        $username = $_SESSION['user_name'] ?? 'Guest';

        if (empty($body)) {
            http_response_code(422);
            return jsonError('Comment body is required.', 422);
        }

        Comment::create([
            'post_id' => $id,
            'username' => $username,
            'body' => $body,
        ]);

        http_response_code(201);
        echo json_encode([
            'success' => true,
            'username' => $username,
            'created_at' => date('Y-m-d H:i'),
            'body' => $body
        ]);
    }

}