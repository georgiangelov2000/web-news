<?php

namespace App\Session;

class Session
{
    protected string $sessionId;
    protected array $data = [];
    protected string $savePath;

    public function __construct(string $savePath = __DIR__ . '/../../../storage/session')
    {
        $this->savePath = $savePath;
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0777, true);
        }
        $this->sessionId = $this->initializeSessionId();
        $this->load();
    }

    protected function initializeSessionId(): string
    {
        if (isset($_COOKIE['app_session'])) {
            return preg_replace('/[^a-zA-Z0-9]/', '', $_COOKIE['app_session']);
        }
        $id = bin2hex(random_bytes(16));
        setcookie('app_session', $id, [
            'expires' => time() + 60 * 60 * 24 * 7, // 1 week
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        $_COOKIE['app_session'] = $id; // So that it's available immediately
        return $id;
    }

    protected function getSessionFile(): string
    {
        return $this->savePath . '/sess_' . $this->sessionId;
    }

    protected function load(): void
    {
        $file = $this->getSessionFile();
        if (file_exists($file)) {
            $contents = file_get_contents($file);
            if ($contents !== false) {
                $this->data = unserialize($contents) ?: [];
            }
        }
    }

    public function save(): void
    {
        file_put_contents($this->getSessionFile(), serialize($this->data), LOCK_EX);
    }

    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
        $this->save();
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function remove(string $key): void
    {
        unset($this->data[$key]);
        $this->save();
    }

    public function all(): array
    {
        return $this->data;
    }

    public function destroy(): void
    {
        $file = $this->getSessionFile();
        if (file_exists($file)) {
            unlink($file);
        }
        $this->data = [];
        setcookie('app_session', '', time() - 3600, '/');
    }
}