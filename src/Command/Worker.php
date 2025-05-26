<?php

require 'vendor/autoload.php'; // or your autoloader

use App\Queue\RedisQueue;
use App\Queue\DatabaseQueue;

// Configurable load threshold (e.g., 75% of CPU cores)
define('QUEUE_MAX_LOAD', 2.0); // Change as needed

function isServerOverloaded(float $threshold): bool
{
    if (!function_exists('sys_getloadavg')) {
        return false; // Assume not overloaded if function unavailable (e.g., Windows)
    }
    $load = sys_getloadavg();
    $cpuCount = (int) shell_exec('nproc') ?: 1; // Linux: get CPU core count
    $normalized = $load[0] / $cpuCount;
    return $normalized >= $threshold;
}

// Decide which queue to use, e.g. via CLI argument
$type = $argv[1] ?? 'redis';

if ($type === 'redis') {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $queue = new RedisQueue($redis);
} elseif ($type === 'database') {
    $pdo = new PDO('mysql:host=localhost;dbname=yourdb', 'user', 'pass');
    $queue = new DatabaseQueue($pdo);
} else {
    exit("Unknown queue type\n");
}

echo "Starting worker for $type queue...\n";

while (true) {
    if (isServerOverloaded(QUEUE_MAX_LOAD)) {
        echo "[WARN] Server load too high, skipping job execution...\n";
        sleep(5); // Wait before checking again
        continue;
    }
    $queue->processNext();
    usleep(250000); // 0.25s
}