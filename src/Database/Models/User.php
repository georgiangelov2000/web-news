<?php

namespace App\Database\Models;

use App\Database\Abstract\Model;
use App\Database\Models\Post;

class User extends Model
{
    protected static string $table = 'users';
    protected static string $primaryKey = 'id';

    public function posts(): array
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public static function getUserByUsernameOrEmail(string $username, string $email): ?self
    {
        $db = static::getConnection();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $data = $stmt->fetch();

        return $data ? new static($data) : null;
    }

    public static function create(array $data): self
    {
        $passwordHash = isset($data['password'])
            ? (password_get_info($data['password'])['algo'] ? $data['password'] : password_hash($data['password'], PASSWORD_DEFAULT))
            : null;

        $user = new static([
            'name' => $data['name'] ?? $data['username'],
            'username' => $data['username'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => $passwordHash
        ]);

        $user->save();
        return $user;
    }

    public static function paginate(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $db = static::getConnection();

        $countStmt = $db->query("SELECT COUNT(*) FROM users");
        $totalItems = (int) $countStmt->fetchColumn();
        $totalPages = (int) ceil($totalItems / $perPage);

        $stmt = $db->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $users = array_map(fn($row) => new static($row), $stmt->fetchAll());

        return [
            'users' => $users,
            'current_page' => $page,
            'per_page' => $perPage,
            'total_items' => $totalItems,
            'total_pages' => $totalPages
        ];
    }

    public static function update(int $id, array $data) {
        $db = static::getConnection();
        $setParts = [];
        $params = [];

        if (isset($data['name'])) {
            $setParts[] = 'name = :name';
            $params[':name'] = $data['name'];
        }
        if (isset($data['username'])) {
            $setParts[] = 'username = :username';
            $params[':username'] = $data['username'];
        }
        if (isset($data['email'])) {
            $setParts[] = 'email = :email';
            $params[':email'] = $data['email'];
        }
        if (isset($data['password'])) {
            $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
            $setParts[] = 'password = :password';
            $params[':password'] = $passwordHash;
        }

        if (empty($setParts)) {
            return false; // No fields to update
        }

        $sql = "UPDATE users SET " . implode(', ', $setParts) . " WHERE id = :id";
        $params[':id'] = $id;

        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }
}
