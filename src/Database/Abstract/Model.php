<?php

namespace App\Database\Abstract;

use App\Database\Database;

abstract class Model
{
    protected static string $table;
    protected static string $primaryKey = 'id';

    protected array $attributes = [];
    protected array $original = [];
    protected array $relations = [];

    public function __construct(array $data = [])
    {
        $this->fill($data);
        $this->original = $this->attributes;
    }

    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }

        if (array_key_exists($name, $this->relations)) {
            return $this->relations[$name];
        }

        if (method_exists($this, $name)) {
            $this->relations[$name] = $this->$name();
            return $this->relations[$name];
        }

        return null;
    }

    public function __set($name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public static function find(int $id, array $with = []): ?static
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        $model = new static($result);
        foreach ($with as $relation) {
            if (method_exists($model, $relation)) {
                $model->relations[$relation] = $model->$relation();
            }
        }

        return $model;
    }

    public static function all(array $with = []): array
    {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        $rows = $stmt->fetchAll();

        return array_map(function ($row) use ($with) {
            $model = new static($row);
            foreach ($with as $relation) {
                if (method_exists($model, $relation)) {
                    $model->relations[$relation] = $model->$relation();
                }
            }
            return $model;
        }, $rows);
    }

    public function save(): bool
    {
        $db = Database::getConnection();

        if (!empty($this->attributes[static::$primaryKey])) {
            $columns = array_keys($this->attributes);
            $columns = array_filter($columns, fn($col) => $col !== static::$primaryKey);
            $sets = implode(', ', array_map(fn($col) => "$col = :$col", $columns));

            $stmt = $db->prepare("UPDATE " . static::$table . " SET $sets WHERE " . static::$primaryKey . " = :id");
            $this->attributes['id'] = $this->attributes[static::$primaryKey];
            return $stmt->execute($this->attributes);
        } else {
            $columns = array_keys($this->attributes);
            $placeholders = implode(', ', array_map(fn($col) => ":$col", $columns));
            $cols = implode(', ', $columns);

            $stmt = $db->prepare("INSERT INTO " . static::$table . " ($cols) VALUES ($placeholders)");
            $result = $stmt->execute($this->attributes);

            if ($result) {
                $this->attributes[static::$primaryKey] = $db->lastInsertId();
            }
            return $result;
        }
    }

    public function delete(): bool
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = :id");
        return $stmt->execute(['id' => $this->attributes[static::$primaryKey]]);
    }

    public function toArray(): array
    {
        return array_merge($this->attributes, $this->relations);
    }

    // Relationships

    protected function hasMany(string $relatedClass, string $foreignKey): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . $relatedClass::$table . " WHERE $foreignKey = :id");
        $stmt->execute(['id' => $this->attributes[static::$primaryKey]]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new $relatedClass($row), $rows);
    }

    protected function hasOne(string $relatedClass, string $foreignKey): ?object
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . $relatedClass::$table . " WHERE $foreignKey = :id LIMIT 1");
        $stmt->execute(['id' => $this->attributes[static::$primaryKey]]);
        $row = $stmt->fetch();

        return $row ? new $relatedClass($row) : null;
    }

    protected function belongsTo(string $relatedClass, string $foreignKey): ?object
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . $relatedClass::$table . " WHERE " . $relatedClass::$primaryKey . " = :id LIMIT 1");
        $stmt->execute(['id' => $this->attributes[$foreignKey] ?? null]);
        $row = $stmt->fetch();

        return $row ? new $relatedClass($row) : null;
    }

    protected function belongsToMany(string $relatedClass, string $pivotTable, string $foreignKey, string $relatedKey): array
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT r.* FROM " . $relatedClass::$table . " r
            JOIN $pivotTable p ON r." . $relatedClass::$primaryKey . " = p.$relatedKey
            WHERE p.$foreignKey = :id");
        $stmt->execute(['id' => $this->attributes[static::$primaryKey]]);
        $rows = $stmt->fetchAll();

        return array_map(fn($row) => new $relatedClass($row), $rows);
    }

    protected static function getConnection()
    {
        return Database::getConnection();
    }
}