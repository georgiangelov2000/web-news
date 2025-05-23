<?php
/**
 * Migration script using .env for DB config.
 * If the database does not exist, it will be created automatically.
 */

file_exists(__DIR__ . '/../../.env') or die("No .env file found.\n");

function loadEnv($path)
{
    if (!file_exists($path)) return [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (!strpos($line, '=')) continue;
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        $env[$name] = $value;
    }
    return $env;
}

$env = loadEnv(__DIR__ . '/../../.env');
$host = $env['DB_HOST'] ?? 'localhost';
$port = $env['DB_PORT'] ?? '3306';
$dbname = $env['DB_DATABASE'] ?? '';
$user = $env['DB_USERNAME'] ?? '';
$pass = $env['DB_PASSWORD'] ?? '';

try {
    // Connect without specifying a database to check/create it
    $pdo = new PDO(
        "mysql:host=$host;port=$port;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    
    // Check if database exists
    $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
    $stmt->execute([$dbname]);
    if ($stmt->fetchColumn()) {
        echo "Database '$dbname' already exists.\n";
    } else {
        $pdo->exec("CREATE DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Database '$dbname' created.\n";
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage() . "\n");
}

// Now connect to the specific database
$pdo = new PDO(
    "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
    $user,
    $pass,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$migrationsDir = __DIR__ . '/../Database/Migrations';
if (!is_dir($migrationsDir)) {
    die("Migrations directory not found: $migrationsDir\n");
}

// Helper: extract table name from CREATE TABLE statement
function getTableNameFromSql($sql) {
    if (preg_match('/CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+`?([a-zA-Z0-9_]+)`?/i', $sql, $matches)) {
        return $matches[1];
    }
    if (preg_match('/CREATE\s+TABLE\s+`?([a-zA-Z0-9_]+)`?/i', $sql, $matches)) {
        return $matches[1];
    }
    return null;
}

// Only run migrations for tables that don't exist yet
foreach (glob($migrationsDir . '/*.sql') as $file) {
    $query = file_get_contents($file);
    $tableName = getTableNameFromSql($query);

    if (!$tableName) {
        echo "Warning: Could not determine table name in $file. Running migration anyway.\n";
        $pdo->exec($query);
        continue;
    }

    // Check if the table exists
    $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
    $stmt->execute([$tableName]);
    if ($stmt->fetchColumn()) {
        echo "Table '$tableName' already exists, skipping migration: $file\n";
        continue;
    }

    echo "Running migration: $file\n";
    $pdo->exec($query);
}
echo "All migrations executed.\n";