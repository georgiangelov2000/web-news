<?php

namespace App\Controller;

use App\Service\UserService;
use App\Repository\UserRepository;
use App\Session\Session;
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
        $this->userService = new UserService(new UserRepository());
        $this->session = new Session(__DIR__ . '/../../../storage/session');
        $this->guard = new SessionGuard($this->session);
    }

    // Show registration form
    public function registerForm()
    {
        // Redirect if already authenticated
        $this->guard->redirectIfAuthenticated('/');
        echo $this->view->render('register');
    }

    // Handle user registration
    public function register(array $request)
    {
        // Redirect if already authenticated
        $this->guard->redirectIfAuthenticated('/');

        $username = trim($request['username'] ?? '');
        $email = trim($request['email'] ?? '');
        $password = trim($request['password'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            echo $this->view->render('register', [
                'error' => 'All fields are required.',
                'old' => $request,
            ]);
            return;
        }

        if ($this->userService->getUserByUsernameOrEmail($username, $email)) {
            echo $this->view->render('register', [
                'error' => 'Username or email already exists.',
                'old' => $request,
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
            $this->session->regenerate(); // Prevent session fixation
            header('Location: /');
            exit;
        } else {
            echo $this->view->render('register', [
                'error' => 'Registration failed.',
                'old' => $request,
            ]);
        }
    }

    // Show login form
    public function loginForm()
    {
        // Redirect if already authenticated
        $this->guard->redirectIfAuthenticated('/');
        echo $this->view->render('login');
    }


    // Handle login
    public function login(array $request)
    {
        $username = trim($request['username'] ?? '');
        $password = trim($request['password'] ?? '');

        if (empty($username) || empty($password)) {
            echo $this->view->render('login', [
                'error' => 'Username and password are required.',
                'old' => $request,
            ]);
            return;
        }

        $user = $this->userService->getUserByUsernameOrEmail($username, $username);
        if ($user && password_verify($password, $user->password)) {
            $this->session->set('user_id', $user->id);
            $this->session->set('user_name', $user->username);
            $this->session->regenerate(); // Prevent session fixation
            header('Location: /');
            exit;
        } else {
            echo $this->view->render('login', [
                'error' => 'Invalid username or password.',
                'old' => $request,
            ]);
        }
    }

    // Handle logout
    public function logout()
    {
        $this->session->destroy();
        header('Location: /login');
        exit;
    }
    // GET /api/users/1
    public function index(array $request = [])
    {
        $page = $request['identifier'];

        if ($page) {
            $this->currentPage = (int) $page;
            $relativePath = $this->cacheDir . '/' . $page . '.html';
        } else {
            $relativePath = $this->cacheDir . '.html';
        }

        $data = $this->userService->getPaginatedUsers(
            $this->currentPage,
            $this->perPage
        );

        // Check if the data is already cached
        if ($this->cache->has($relativePath)) {
            echo $this->cache->get($relativePath);
            return;
        }

        $html = $this->view->render('users', $data);
        $this->cache->set($relativePath, $html);

        echo $html;
    }

    // GET /api/users/{id}
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
            echo $this->cache->get($relativePath);
            return;
        }
        $user = $this->userService->getUserById($id);
        if (!$user) {
            http_response_code(404);
            echo "User not found";
            return;
        }
        $data = ['user' => $user];
        $html = $this->view->render('user', $data);
        $this->cache->set($relativePath, $html);
        echo $html;
    }

    // POST /api/users/create
    public function create(array $request)
    {
        $username = trim($request['username'] ?? '');
        $email = trim($request['email'] ?? '');
        $password = trim($request['password'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            http_response_code(422);
            echo json_encode(['error' => 'Username, email and password are required.']);
            return;
        }

        $user = $this->userService->create([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        echo json_encode(['success' => true, 'user' => $user]);
    }

    // POST /api/users/{id}/update
    public function update(array $request)
    {
        $id = $request['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo "Missing user ID";
            return;
        }
        $data = [];
        if (isset($request['username']))
            $data['username'] = trim($request['username']);
        if (isset($request['email']))
            $data['email'] = trim($request['email']);
        if (isset($request['password']))
            $data['password'] = password_hash($request['password'], PASSWORD_DEFAULT);

        if (empty($data)) {
            http_response_code(422);
            echo json_encode(['error' => 'No data to update.']);
            return;
        }

        $result = $this->userService->update($id, $data);
        if (!$result) {
            http_response_code(400);
            echo json_encode(['error' => 'User update failed']);
            return;
        }
        echo json_encode(['success' => true]);
    }

    // POST /api/users/{id}/delete
    public function delete(array $request)
    {
        $id = $request['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo "Missing user ID";
            return;
        }
        $result = $this->userService->delete($id);
        if (!$result) {
            http_response_code(400);
            echo json_encode(['error' => 'User delete failed']);
            return;
        }
        echo json_encode(['success' => true]);
    }
}