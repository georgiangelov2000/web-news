<?php

use App\Controller\PostController;
use App\Controller\UserController;
use App\Controller\CustomizationController;
$routes = [
    // =============================
    // POSTS ROUTES
    // =============================

    // Post listing and details
    new \PhpDevCommunity\Route('posts.index',        '/',                    [PostController::class, 'index'],        ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.index',        '/posts',                    [PostController::class, 'index'],        ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.show',         '/posts/{identifier}',             [PostController::class, 'index'],         ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('posts.show_legacy',  '/post/{identifier}',              [PostController::class, 'show'],         ['GET', 'HEAD']), // for backward compatibility

    // Post create
    new \PhpDevCommunity\Route('posts.create_form',  '/posts/create',             [PostController::class, 'createForm'],   ['GET']),
    new \PhpDevCommunity\Route('posts.store',        '/posts',                    [PostController::class, 'store'],        ['POST']),

    // Post update/delete
    new \PhpDevCommunity\Route('posts.edit_form',    '/post/{post}/edit',        [PostController::class, 'editForm'],     ['GET']),
    new \PhpDevCommunity\Route('posts.update',       '/posts/{post}',             [PostController::class, 'update'],       ['POST']),
    new \PhpDevCommunity\Route('posts.delete',       '/posts/{post}',             [PostController::class, 'delete'],       ['DELETE', 'POST']),

    // Post actions
    new \PhpDevCommunity\Route('posts.like',         '/posts/{post}/like',        [PostController::class, 'like'],         ['POST']),
    new \PhpDevCommunity\Route('posts.dislike',      '/posts/{post}/dislike',     [PostController::class, 'dislike'],      ['POST']),
    new \PhpDevCommunity\Route('posts.favorite',     '/posts/{post}/favorite',    [PostController::class, 'favorite'],     ['POST']),
    new \PhpDevCommunity\Route('posts.report',       '/posts/{post}/report',      [PostController::class, 'report'],       ['POST']),
    new \PhpDevCommunity\Route('posts.share',        '/posts/{post}/share',       [PostController::class, 'share'],        ['GET']),

    // Comments
    new \PhpDevCommunity\Route('posts.comments.store', '/posts/{post}/comments',  [PostController::class, 'storeComment'], ['POST']),

    // Favorites
    new \PhpDevCommunity\Route('posts.favorites',    '/posts/favorites',          [PostController::class, 'favoritesPage'], ['GET']),
    new \PhpDevCommunity\Route('posts.favorites.show','/posts/favorites/{post}',  [PostController::class, 'favoritesPage'], ['GET', 'HEAD']),

    // =============================
    // USER & AUTH ROUTES
    // =============================

    // Registration & Login (forms and actions)
    new \PhpDevCommunity\Route('auth.register.form', '/register',                 [UserController::class, 'registerForm'], ['GET','HEAD']),
    new \PhpDevCommunity\Route('auth.register',      '/register',                 [UserController::class, 'register'],     ['POST']),
    new \PhpDevCommunity\Route('auth.login.form',    '/login',                    [UserController::class, 'loginForm'],    ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('auth.login',         '/login',                    [UserController::class, 'login'],        ['POST']),
    new \PhpDevCommunity\Route('auth.logout',        '/logout',                   [UserController::class, 'logout'],       ['GET','HEAD']),

    // Users management
    new \PhpDevCommunity\Route('users.index',        '/users',                    [UserController::class, 'index'],        ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('users.create',       '/users',                    [UserController::class, 'create'],       ['POST']),
    new \PhpDevCommunity\Route('users.show',         '/users/{user}',             [UserController::class, 'show'],         ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('users.update',       '/users/{user}',             [UserController::class, 'update'],       ['POST', 'PUT']),
    new \PhpDevCommunity\Route('users.delete',       '/users/{user}',             [UserController::class, 'delete'],       ['POST', 'DELETE']),

    // Profile
    new \PhpDevCommunity\Route('profile.show',       '/profile',                  [UserController::class, 'profile'],      ['GET', 'HEAD']),
    new \PhpDevCommunity\Route('profile.edit_form',  '/profile/edit',             [UserController::class, 'getProfileForm'],['GET', 'HEAD']),
    new \PhpDevCommunity\Route('profile.update',     '/profile',                  [UserController::class, 'updateProfile'],['POST']),

    // Pricing page (GET)
    new \PhpDevCommunity\Route('pricing.show',     '/pricing',                  [CustomizationController::class, 'getPricingPage'],['GET', 'HEAD']),

    // Forgot password (GET form)
    new \PhpDevCommunity\Route('forgot_password.form', '/forgot-password', [UserController::class, 'forgotPasswordForm'], ['GET']),

    // Forgot password (POST submit)
    new \PhpDevCommunity\Route('forgot_password.submit', '/forgot-password', [UserController::class, 'forgotPassword'], ['POST'])

];

return $routes;