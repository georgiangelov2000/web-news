<?php
/**
 * Simple script to clear cache files for a given resource and/or id.
 * Usage:
 *   sudo -u www-data php ClearCache.php posts 25
 *   php clear_cache.php posts           # Deletes all cached posts
 *   php clear_cache.php posts 15        # Deletes cached post with ID 15
 *   php clear_cache.php                 # Deletes ALL cache (careful!)
 */

$cacheDir = __DIR__ . '/../../storage/cache';

if (!is_dir($cacheDir)) {
    echo "Cache directory does not exist.\n";
    exit(1);
}

$resource = $argv[1] ?? null;
$id       = $argv[2] ?? null;

function rrmdir($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $full = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($full)) {
            rrmdir($full);
        } else {
            unlink($full);
        }
    }
    rmdir($dir);
}

// Remove ALL cache
if (!$resource) {
    rrmdir($cacheDir);
    mkdir($cacheDir, 0777, true);
    echo "All cache cleared.\n";
    exit(0);
}

// Remove cache for specific resource (e.g. posts)
$resourceDir = $cacheDir . '/api_' . $resource;
if (!is_dir($resourceDir)) {
    echo "No cache found for resource: $resource\n";
    exit(0);
}

if (!$id) {
    rrmdir($resourceDir);
    echo "Cache cleared for resource: $resource\n";
    exit(0);
}

// Remove cache for specific resource and ID (e.g. posts/15)
$file = $resourceDir . '/' . $id . '.html';
if (file_exists($file)) {
    unlink($file);
    echo "Cache cleared for resource: $resource, id: $id\n";
} else {
    echo "No cache file found for resource: $resource, id: $id\n";
}