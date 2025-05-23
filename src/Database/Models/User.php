<?php

namespace App\Database\Models;

use App\Database\Database;
use App\Database\Models\Post;

class User
{
    public $id, $name, $username, $email, $created_at;

    public function __construct($data = [])
    {
        foreach ($data as $k => $v) $this->$k = $v;
    }

    public static function find($id)
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        return $data ? new static($data) : null;
    }

    public static function all()
    {
        $stmt = Database::getConnection()->query("SELECT * FROM users");
        return array_map(fn($row) => new static($row), $stmt->fetchAll());
    }

    public static function create($data)
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO users (name, username, email) VALUES (?, ?, ?)"
        );
        $stmt->execute([$data['name'], $data['username'], $data['email']]);
        return Database::getConnection()->lastInsertId();
    }

        // Relation: User has many Posts
        public function posts()
        {
            return Post::findByUserId($this->id);
        }
}