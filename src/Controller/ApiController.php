<?php

namespace App\Controller;

use App\Cache\CacheManager;
use App\View\ViewRenderer;

class ApiController
{
    protected CacheManager $cache;
    protected ViewRenderer $view;
    protected string $resource = '';
    protected string $cacheDir = '';

    public function __construct()
    {
        $this->cache = new CacheManager(__DIR__ . '/../../storage/cache');
        $this->view = new ViewRenderer(__DIR__ . '/../../templates');
    }

    // Set the resource name (e.g. 'posts') for the controller
    public function setResource(string $resource): void
    {
        $this->resource = $resource;
    }

    // Set the cache subdirectory (e.g. 'posts')
    public function setCacheDir(string $cacheDir): void
    {
        $this->cacheDir = $cacheDir;
    }

    // Get full cache directory path
    protected function getFullCacheDir(): string
    {
        return $this->cache->getCachePath() . '/' . $this->cacheDir;
    }

    // Render a view and cache its HTML output, useful for HTML endpoints
    protected function renderAndCacheView(string $id, array $data): void
    {
        $cacheFile = $id . '.html';
        $fullCacheDir = $this->getFullCacheDir();

        // Ensure directory exists
        if (!is_dir($fullCacheDir)) {
            mkdir($fullCacheDir, 0777, true);
        }

        if ($this->cache->has($this->cacheDir . '/' . $cacheFile)) {
            echo $this->cache->get($this->cacheDir . '/' . $cacheFile);
            return;
        }

        // Use view named after the resource
        $viewName = $this->resource;

        $html = $this->view->render($viewName, [
            'resource' => $this->resource,
            'data' => $data,
        ]);

        $this->cache->set($this->cacheDir . '/' . $cacheFile, $html);
        echo $html;
    }

    protected function parseRequestUriAndQuery($request): array
    {
        $uri = $request['requestUri'] ?? '';
        $query = $request['query'] ?? [];
    
        // Step 1: Normalize URI (remove leading/trailing slashes)
        $uri = trim($uri, '/');
    
        // Step 2: Remove first segment before first '/'
        $posFirstSlash = strpos($uri, '/');
        $remaining = $posFirstSlash !== false ? substr($uri, $posFirstSlash + 1) : '';
    
        $id = null;
    
        // Step 3: Check if the last segment is numeric
        $posLastSlash = strrpos($remaining, '/');
        $lastPart = $posLastSlash !== false ? substr($remaining, $posLastSlash + 1) : $remaining;
    
        if (is_numeric($lastPart)) {
            $id = (int) $lastPart;
            // Remove the last segment
            $remaining = $posLastSlash !== false ? substr($remaining, 0, $posLastSlash) : '';
        }
    
        return [
            'resource' => $remaining, // e.g. 'posts/test'
            'id' => $id,              // e.g. 2
            'query' => $query,
        ];
    }    
    

}