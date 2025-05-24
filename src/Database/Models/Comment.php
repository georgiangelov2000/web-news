<?php

namespace App\Database\Models;

use App\Database\Database;

class Comment
{
    
    public static function create(array $data)
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO comments (post_id, username, body) VALUES (?, ?, ?)");
        $stmt->execute([$data['post_id'], $data['username'], $data['body']]);
    }

    public static function findByPostId(int $postId): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
        $stmt->execute([$postId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
