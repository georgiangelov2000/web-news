<?php

namespace App\Controller;

use App\Service\UserService;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Security\SessionGuard;

class UsersApiController extends ApiController
{
    protected $userService;
    private $perPage = 10;
    private $currentPage = 1;
    protected $session;
    protected $guard;

    public function __construct()
    {
        parent::__construct();
        $this->setResource('users');
        $this->setCacheDir('users');

        $this->userService = new UserService(new UserRepository(), new PostRepository());

        $this->session = $GLOBALS['session'];
        $this->guard = new SessionGuard($this->session);
    }

    public function registerForm()
    {
        $this->guard->redirectIfAuthenticated('/');
        http_response_code(200);
        echo $this->view->render('register');
    }

    public function register()
    {
        $this->guard->redirectIfAuthenticated('/');

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            http_response_code(422);
            echo $this->view->render('register', [
                'error' => 'All fields are required.',
            ]);
            return;
        }

        if ($this->userService->getUserByUsernameOrEmail($username, $email)) {
            http_response_code(409);
            echo $this->view->render('register', [
                'error' => 'Username or email already exists.',
            ]);
            return;
        }

        $user = $this->userService->create([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($user) {
            $this->session->set('user_id', $user->id);
            $this->session->set('user_name', $user->username);
            $this->session->regenerate();

            header('Location: /api/profile', true, 302);
            exit;
        }

        http_response_code(500);
        echo $this->view->render('register', [
            'error' => 'Registration failed.',
        ]);
    }

    public function loginForm()
    {
        $this->guard->redirectIfAuthenticated('/');
        http_response_code(200);
        echo $this->view->render('login');
    }

    public function login()
    {
        $username = trim($_REQUEST['username'] ?? '');
        $password = trim($_REQUEST['password'] ?? '');

        if (empty($username) || empty($password)) {
            http_response_code(422);
            echo $this->view->render('login', [
                'error' => 'Username and password are required.',
            ]);
            return;
        }

        $user = $this->userService->getUserByUsernameOrEmail($username, $username);
        if ($user && password_verify($password, $user->password)) {
            $this->session->set('user_id', $user->id);
            $this->session->set('user_name', $user->username);
            $this->session->regenerate();

            header('Location: /api/profile', true, 302);
            exit;
        }

        http_response_code(401);
        echo $this->view->render('login', [
            'error' => 'Invalid username or password.',
        ]);
    }

    public function logout()
    {
        $this->session->destroy();
        header('Location: /login', true, 302);
        exit;
    }

    public function index(array $request = [])
    {
        $page = $request['identifier'] ?? null;

        $this->currentPage = $page ? (int) $page : 1;
        $relativePath = $this->cacheDir . ($page ? "/$page.html" : '.html');

        $data = $this->userService->getPaginatedUsers($this->currentPage, $this->perPage);

        if ($this->cache->has($relativePath)) {
            http_response_code(200);
            echo $this->cache->get($relativePath);
            return;
        }

        $html = $this->view->render('users', $data);
        $this->cache->set($relativePath, $html);

        http_response_code(200);
        echo $html;
    }

    public function show(array $request = [])
    {
        $id = $request['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo "Missing user ID";
            return;
        }

        $relativePath = $this->cacheDir . "/$id.html";

        if ($this->cache->has($relativePath)) {
            http_response_code(200);
            echo $this->cache->get($relativePath);
            return;
        }

        $user = $this->userService->getUserById($id);
        if (!$user) {
            http_response_code(404);
            echo "User not found";
            return;
        }

        $html = $this->view->render('user', ['user' => $user]);
        $this->cache->set($relativePath, $html);

        http_response_code(200);
        echo $html;
    }

    public function update(array $request)
    {
        $id = $request['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing user ID']);
            return;
        }

        $data = array_filter([
            'username' => isset($request['username']) ? trim($request['username']) : null,
            'email' => isset($request['email']) ? trim($request['email']) : null,
            'password' => isset($request['password']) ? password_hash($request['password'], PASSWORD_DEFAULT) : null
        ]);

        if (empty($data)) {
            http_response_code(422);
            echo json_encode(['error' => 'No data to update.']);
            return;
        }

        if (!$this->userService->update($id, $data)) {
            http_response_code(400);
            echo json_encode(['error' => 'User update failed']);
            return;
        }

        http_response_code(200);
        echo json_encode(['success' => true]);
    }

    public function delete(array $request)
    {
        $id = $request['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing user ID']);
            return;
        }

        if (!$this->userService->delete($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'User delete failed']);
            return;
        }

        http_response_code(200);
        echo json_encode(['success' => true]);
    }

    public function profile()
    {
        $userId = $this->session->get('user_id');
        if (!$userId) {
            http_response_code(401);
            echo $this->view->render('error', [
                'error' => 'Unauthorized access.'
            ]);
            return;
        }

        $user = $this->userService->getUserById($userId);
        if (!$user) {
            http_response_code(404);
            echo $this->view->render('error', [
                'error' => 'User not found.'
            ]);
            return;
        }

        $posts = $this->userService->findByUserId($userId);
        $favoritePosts = $this->userService->getFavoritePosts($userId);

        $data = [
            'user' => $user,
            'posts' => $posts,
            'favoritePosts' => $favoritePosts['posts'],
        ];

        http_response_code(200);
        echo $this->view->render('profile', $data);
    }
}
