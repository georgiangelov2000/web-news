<?php

namespace App\Database\Models;

use App\Database\Model;
use App\Database\Database;
use App\Database\Models\User;
use App\Database\Models\Comment;

class Post extends Model
{
    protected static string $table = 'posts';
    protected static string $primaryKey = 'id';

    protected static function getConnection()
    {
        return Database::getConnection();
    }

    public function user(): ?User
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(): array
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public static function findByIdOrAlias($identifier): ?self
    {
        $db = static::getConnection();

        if (ctype_digit((string) $identifier)) {
            $stmt = $db->prepare("SELECT * FROM posts WHERE id = ?");
        } else {
            $stmt = $db->prepare("SELECT * FROM posts WHERE alias = ?");
        }

        $stmt->execute([$identifier]);
        $data = $stmt->fetch();

        return $data ? new static($data) : null;
    }

    public static function findByUserId($userId): array
    {
        $stmt = static::getConnection()->prepare("SELECT * FROM posts WHERE user_id = ?");
        $stmt->execute([$userId]);
        return array_map(fn($row) => new static($row), $stmt->fetchAll());
    }

    public static function toggleFavorite($userId, $postId): bool
    {
        $db = static::getConnection();
        $stmt = $db->prepare("SELECT * FROM user_favorite_posts WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$userId, $postId]);
        $favorite = $stmt->fetch();

        if ($favorite) {
            $stmt = $db->prepare("DELETE FROM user_favorite_posts WHERE user_id = ? AND post_id = ?");
            return $stmt->execute([$userId, $postId]);
        } else {
            $stmt = $db->prepare("INSERT INTO user_favorite_posts (user_id, post_id) VALUES (?, ?)");
            return $stmt->execute([$userId, $postId]);
        }
    }

    public static function getFavoritePosts(int $userId, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $db = static::getConnection();

        $countStmt = $db->prepare("SELECT COUNT(*) FROM user_favorite_posts WHERE user_id = ?");
        $countStmt->execute([$userId]);
        $totalItems = (int)$countStmt->fetchColumn();
        $totalPages = (int)ceil($totalItems / $perPage);

        $stmt = $db->prepare(
            "SELECT p.* FROM posts p 
             JOIN user_favorite_posts uf ON p.id = uf.post_id 
             WHERE uf.user_id = :user_id 
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $posts = $stmt->fetchAll();

        return [
            'posts' => array_map(fn($row) => new static($row), $posts),
            'current_page' => $page,
            'per_page' => $perPage,
            'total_items' => $totalItems,
            'total_pages' => $totalPages
        ];
    }

    public static function create(array $data): int
    {
        $stmt = static::getConnection()->prepare(
            "INSERT INTO posts (user_id, title, body) VALUES (?, ?, ?)"
        );
        $stmt->execute([$data['user_id'], $data['title'], $data['body']]);
        return static::getConnection()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = static::getConnection()->prepare("UPDATE posts SET title = ?, body = ? WHERE id = ?");
        return $stmt->execute([$data['title'], $data['body'], $id]);
    }

    // public static function delete(int $id): bool
    // {
    //     $stmt = static::getConnection()->prepare("DELETE FROM posts WHERE id = ?");
    //     return $stmt->execute([$id]);
    // }

    public static function getComments($id): array
    {
        $stmt = static::getConnection()->prepare("SELECT * FROM comments WHERE post_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function incrementLikes(int $postId): bool
    {
        $stmt = static::getConnection()->prepare("UPDATE posts SET likes = likes + 1 WHERE id = ?");
        return $stmt->execute([$postId]);
    }

    public static function decrementLikes(int $postId): bool
    {
        $stmt = static::getConnection()->prepare("UPDATE posts SET likes = GREATEST(likes - 1, 0) WHERE id = ?");
        return $stmt->execute([$postId]);
    }

    public static function incrementDislikes(int $postId): bool
    {
        $stmt = static::getConnection()->prepare("UPDATE posts SET dislikes = dislikes + 1 WHERE id = ?");
        return $stmt->execute([$postId]);
    }

    public static function decrementDislikes(int $postId): bool
    {
        $stmt = static::getConnection()->prepare("UPDATE posts SET dislikes = GREATEST(dislikes - 1, 0) WHERE id = ?");
        return $stmt->execute([$postId]);
    }

    public static function search(string $query): array
    {
        $stmt = static::getConnection()->prepare("SELECT * FROM posts WHERE title LIKE ? OR body LIKE ?");
        $stmt->execute(["%$query%", "%$query%"]);
        return $stmt->fetchAll();
    }

    public static function getAll(): array
    {
        $stmt = static::getConnection()->query("SELECT * FROM posts");
        return $stmt->fetchAll();
    }
}
