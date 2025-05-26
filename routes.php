<?php

use App\Controller\PostController;
use App\Controller\UserController;

$routes = [
    // HTML API: GET /posts
    // HTML API: GET /posts/<alias>||<id>
    // HTML API: GET /post/<alias>||<id>

    new \PhpDevCommunity\Route('posts', '/posts', [PostController::class, 'index'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.create_form', '/posts/create', [PostController::class, 'createForm'], ['GET']),
    new \PhpDevCommunity\Route('posts.favorites', '/posts/favorites', [PostController::class, 'favoritesPage'], ['GET']),
    new \PhpDevCommunity\Route('posts.comment', '/posts/favorites/{identifier}', [PostController::class, 'favoritesPage'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.identifier', '/posts/{identifier}', [PostController::class, 'index'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.show', '/post/{identifier}', [PostController::class, 'show'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.comment', '/posts/{id}/comment', [PostController::class, 'storeComment'], ['POST']),

    // ACTIONS
    new \PhpDevCommunity\Route('posts.store', '/posts/create', [PostController::class, 'store'], ['POST']),
    new \PhpDevCommunity\Route('posts.like', '/posts/{id}/like', [PostController::class, 'like'], ['POST']),
    new \PhpDevCommunity\Route('posts.dislike', '/posts/{id}/dislike', [PostController::class, 'dislike'], ['POST']),
    new \PhpDevCommunity\Route('posts.favorite', '/posts/{id}/favorite', [PostController::class, 'favorite'], ['POST']),
    new \PhpDevCommunity\Route('posts.report', '/posts/{id}/report', [PostController::class, 'report'], ['POST']),
    new \PhpDevCommunity\Route('posts.share', '/posts/{id}/share', [PostController::class, 'share'], ['GET']),

    // USERS API: GET /users
    new \PhpDevCommunity\Route('users.register_form_get', '/register', [UserController::class, 'registerForm'], ['GET','HEAD']),
    new \PhpDevCommunity\Route('users.login_form_get', '/login', [UserController::class, 'loginForm'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('users', '/users', [UserController::class, 'index'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('users.logout', '/logout', [UserController::class, 'logout'], ['GET','HEAD']),
    new \PhpDevCommunity\Route('users.show', '/user/{id}', [UserController::class, 'show'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('profile.show', '/profile', [UserController::class, 'profile'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('profile.update_get', '/profile/update', [UserController::class, 'getProfileForm'], ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('profile.update_put', '/profile/update', [UserController::class, 'updateProfile'], ['PUT']),

    new \PhpDevCommunity\Route('users.register_form_create', '/register', [UserController::class, 'register'], ['POST']),
    new \PhpDevCommunity\Route('users.login_form_create', '/login', [UserController::class, 'login'], ['POST']),
    new \PhpDevCommunity\Route('users.create', '/users/create', [UserController::class, 'create'], ['POST']),
    new \PhpDevCommunity\Route('users.update', '/users/{id}/update', [UserController::class, 'update'], ['POST']),
    new \PhpDevCommunity\Route('users.delete', '/users/{id}/delete', [UserController::class, 'delete'], ['POST']),
];

return $routes;