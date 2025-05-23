<?php

namespace App\Cache;

class CacheManager
{
    private string $cacheDir;

    public function __construct(string $cacheDir)
    {
        $this->cacheDir = rtrim($cacheDir, '/');
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function getCachePath(): string
    {
        return $this->cacheDir;
    }

    public function has(string $filename): bool
    {
        return file_exists($this->cacheDir . '/' . $filename);
    }

    public function get(string $filename): ?string
    {
        $path = $this->cacheDir . '/' . $filename;
        return file_exists($path) ? file_get_contents($path) : null;
    }

    public function set(string $filename, string $content): bool
    {
        $fullPath = $this->cacheDir . '/' . $filename;
        $dir = dirname($fullPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        return file_put_contents($fullPath, $content) !== false;
    }
}