<?php

use App\Database\Models\User;
use App\Database\Models\Post;

require_once __DIR__ . '/../../vendor/autoload.php';

// Import users
$users = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/users'), true);
foreach ($users as $user) {
    User::create([
        'name' => $user['name'],
        'username' => $user['username'],
        'email' => $user['email'],
    ]);
}
echo "Users imported.\n";

// Import posts
$posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
foreach ($posts as $post) {
    Post::create([
        'userId' => $post['userId'],
        'title' => $post['title'],
        'body' => $post['body'],
    ]);
}
echo "Posts imported.\n";