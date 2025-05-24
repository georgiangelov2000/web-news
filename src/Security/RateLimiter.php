<?php
namespace App\Security;

class RateLimiter
{
    const REQUESTS = 60;
    const WINDOW = 60; // seconds

    protected $dir;

    public function __construct($storageDir = __DIR__ . '/../../storage/ratelimit/')
    {
        $this->dir = $storageDir;
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0700, true);
        }
    }

    public function check($ip)
    {
        $file = $this->dir . md5($ip) . '.json';
        $window = self::WINDOW;

        if (!file_exists($file)) {
            file_put_contents($file, json_encode(['count' => 1, 'start' => time()]));
            return true;
        }
        $data = json_decode(file_get_contents($file), true);
        $now = time();

        if ($now - $data['start'] > $window) {
            file_put_contents($file, json_encode(['count' => 1, 'start' => $now]));
            return true;
        }

        if ($data['count'] >= self::REQUESTS) {
            header('HTTP/1.1 429 Too Many Requests');
            header('Retry-After: ' . ($window - ($now - $data['start'])));
            echo "Rate limit exceeded. Try again later.";
            exit();
        }
        $data['count']++;
        file_put_contents($file, json_encode($data));
        return true;
    }
}