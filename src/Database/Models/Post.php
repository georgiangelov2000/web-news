<?php

namespace App\Database\Models;

use App\Database\Database;
use App\Database\Models\User;

class Post
{
    public $id, $userId, $title, $body, $created_at;
    protected static $with = [];

    public function __construct($data = [])
    {
        foreach ($data as $k => $v) $this->$k = $v;
    }

    public static function find($alias)
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM posts WHERE alias = ?");
        $stmt->execute([$alias]);
        return $stmt->fetch();
    }

    public static function create($data)
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO posts (userId, title, body) VALUES (?, ?, ?)"
        );
        $stmt->execute([$data['userId'], $data['title'], $data['body']]);
        return Database::getConnection()->lastInsertId();
    }

    // Fluent method to specify eager loading relations
    public static function eagerLoading($relation)
    {
        static::$with = is_array($relation) ? $relation : [$relation];
        return new static;
    }
    
    // Reset eager loading relations
    protected static function resetEager()
    {
        static::$with = [];
    }

    public static function paginate($page = 1, $perPage = 10)
    {
        $offset = ($page - 1) * $perPage;
        $db = Database::getConnection();
    
        // Get total items count
        $countStmt = $db->query("SELECT COUNT(*) FROM posts");
        $totalItems = (int)$countStmt->fetchColumn();
        $totalPages = (int)ceil($totalItems / $perPage);
    
        // Get current page items
        $stmt = $db->prepare("SELECT * FROM posts LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $posts = $stmt->fetchAll();
    
        return [
            'posts' => $posts,
            'current_page' => $page,
            'per_page' => $perPage,
            'total_items' => $totalItems,
            'total_pages' => $totalPages
        ];
    }
    
    public static function findByUserId($userId)
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM posts WHERE userId = ?");
        $stmt->execute([$userId]);
        return array_map(fn($row) => new static($row), $stmt->fetchAll());
    }

    public static function update($id, $data)
    {
        $stmt = Database::getConnection()->prepare(
            "UPDATE posts SET title = ?, body = ? WHERE id = ?"
        );
        return $stmt->execute([$data['title'], $data['body'], $id]);
    }

    public static function delete($id)
    {
        $stmt = Database::getConnection()->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function count()
    {
        $stmt = Database::getConnection()->query("SELECT COUNT(*) FROM posts");
        return $stmt->fetchColumn();
    }

    public static function search($query)
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM posts WHERE title LIKE ? OR body LIKE ?");
        $stmt->execute(["%$query%", "%$query%"]);
        return $stmt->fetchAll();
    }

    public static function getAll()
    {
        $stmt = Database::getConnection()->query("SELECT * FROM posts");
        return $stmt->fetchAll();
    }

    // Relation: Post belongs to User
    public function user()
    {
        return User::find($this->userId);
    }
}