<?php

namespace App\Database;

use PDO;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $env = self::loadEnv(__DIR__ . '/../../.env');

            $host = $env['DB_HOST'] ?? 'localhost';
            $port = $env['DB_PORT'] ?? '3306';
            $dbname = $env['DB_DATABASE'] ?? '';
            $user = $env['DB_USERNAME'] ?? '';
            $pass = $env['DB_PASSWORD'] ?? '';

            self::$instance = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }
        return self::$instance;
    }

    private static function loadEnv($path)
    {
        if (!file_exists($path)) return [];
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $env = [];
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($name, $value) = array_map('trim', explode('=', $line, 2));
            $env[$name] = $value;
        }
        return $env;
    }
}