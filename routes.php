<?php
use App\Controller\PostsApiController;

// Only allow these explicit API endpoints:
return [

    // Favorite/Unfavorite a post (POST for action)
    '#^/posts/(?P<id>\d+)/favorite$#' => function ($params) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            echo '405 Method Not Allowed';
            exit;
        }
        $controller = new PostsApiController();
        $controller->favorite($params ?? []);
    },

    // Like a post (POST for action)
    '#^/posts/(?P<id>\d+)/like$#' => function ($params) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            echo '405 Method Not Allowed';
            exit;
        }
        $controller = new PostsApiController();
        $controller->like($params ?? []);
    },

    // Dislike a post (POST for action)
    '#^/posts/(?P<id>\d+)/dislike$#' => function ($params) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            echo '405 Method Not Allowed';
            exit;
        }
        $controller = new PostsApiController();
        $controller->dislike($params ?? []);
    },

    // Share a post (GET for displaying share options)
    '#^/posts/(?P<id>\d+)/share$#' => function ($params) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            header('Allow: GET');
            echo '405 Method Not Allowed';
            exit;
        }
        $controller = new PostsApiController();
        $controller->share($params ?? []);
    },

    // Report a post (POST for action)
    '#^/posts/(?P<id>\d+)/report$#' => function ($params) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            echo '405 Method Not Allowed';
            exit;
        }
        $controller = new PostsApiController();
        $controller->report($params ?? []);
    },
    // /api/posts or /api/posts/
    '#^/api/posts/?$#' => function ($params) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405); // Method Not Allowed
            header('Allow: GET');
            echo '405 Method Not Allowed';
            exit;
        }
        $controller = new PostsApiController();
        $controller->index($params ?? []);
    },

    // /api/posts/2 or /api/posts/test/2
    // '#^/api/posts(?:/[^/]+)?/(?P<id>\d+)$#' => function ($params) {
    //     $controller = new PostsApiController();
    //     $controller->index($params ?? []);
    // },

    // /api/posts/<A-Za-z0-9> or /api/posts/test/<A-Za-z0-9>
    // '#^/api/posts(?:/[^/]+)?/(?P<alias>[a-zA-Z0-9\-_]+)$#' => function ($params) {
    //     if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    //         http_response_code(405); // Method Not Allowed
    //         header('Allow: GET');
    //         echo '405 Method Not Allowed';
    //         exit;
    //     }
    //     $controller = new PostsApiController();
    //     $controller->show($params ?? []);
    // },

    '#^/api/posts/(?P<alias>[a-zA-Z0-9\-_]+)$#' => function ($params) {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405); // Method Not Allowed
            header('Allow: GET');
            echo '405 Method Not Allowed';
            exit;
        }
        $controller = new PostsApiController();
        $controller->show($params ?? []);
    },
];