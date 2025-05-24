<?php

use App\Controller\PostsApiController;
use App\Controller\UsersApiController;

$routes = [
    // HTML API: GET /api/posts
    // HTML API: GET /api/posts/<alias>||<id>
    // HTML API: GET /api/post/<alias>||<id>

    new \PhpDevCommunity\Route('posts', '/api/posts', [PostsApiController::class, 'index'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.create_form', '/api/posts/create', [PostsApiController::class, 'createForm'], ['GET']),
    new \PhpDevCommunity\Route('posts.favorites', '/api/posts/favorites', [PostsApiController::class, 'favoritesPage'], ['GET']),
    new \PhpDevCommunity\Route('posts.comment', '/api/posts/favorites/{identifier}', [PostsApiController::class, 'favoritesPage'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.identifier', '/api/posts/{identifier}', [PostsApiController::class, 'index'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.show', '/api/post/{identifier}', [PostsApiController::class, 'show'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.comment', '/api/posts/{id}/comment', [PostsApiController::class, 'storeComment'], ['POST']),

    // ACTIONS
    new \PhpDevCommunity\Route('posts.store', '/api/posts/create', [PostsApiController::class, 'store'], ['POST']),
    new \PhpDevCommunity\Route('posts.like', '/api/posts/{id}/like', [PostsApiController::class, 'like'], ['POST']),
    new \PhpDevCommunity\Route('posts.dislike', '/api/posts/{id}/dislike', [PostsApiController::class, 'dislike'], ['POST']),
    new \PhpDevCommunity\Route('posts.favorite', '/api/posts/{id}/favorite', [PostsApiController::class, 'favorite'], ['POST']),
    new \PhpDevCommunity\Route('posts.report', '/api/posts/{id}/report', [PostsApiController::class, 'report'], ['POST']),
    new \PhpDevCommunity\Route('posts.share', '/api/posts/{id}/share', [PostsApiController::class, 'share'], ['GET']),

    // USERS API: GET /api/users
    new \PhpDevCommunity\Route('users.register_form', '/api/register', [UsersApiController::class, 'registerForm'], ['GET']),
    new \PhpDevCommunity\Route('users.login_form', '/api/login', [UsersApiController::class, 'loginForm'], ['GET']),
    new \PhpDevCommunity\Route('users', '/api/users', [UsersApiController::class, 'index'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('users.show', '/api/users/{id}', [UsersApiController::class, 'show'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('users.create', '/api/users/create', [UsersApiController::class, 'create'], ['POST']),
    new \PhpDevCommunity\Route('users.update', '/api/users/{id}/update', [UsersApiController::class, 'update'], ['POST']),
    new \PhpDevCommunity\Route('users.delete', '/api/users/{id}/delete', [UsersApiController::class, 'delete'], ['POST']),
];

return $routes;