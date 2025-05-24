<?php

namespace App\Support;

use Redis;

class RedisClient
{
    protected static ?\Redis $client = null;

    public static function get(): \Redis
    {
        if (!self::$client) {
            self::$client = new \Redis();
            self::$client->connect(
                getenv('REDIS_HOST') ?: '127.0.0.1',
                (int)(getenv('REDIS_PORT') ?: 6379)
            );

            if (getenv('REDIS_PASSWORD')) {
                self::$client->auth(getenv('REDIS_PASSWORD'));
            }

            $db = (int)(getenv('REDIS_DB') ?: 0);
            self::$client->select($db);
        }
        return self::$client;
    }

    public static function set(string $key, mixed $value, int $ttl = 0): bool
    {
        $client = self::get();
        $data = is_scalar($value) ? $value : json_encode($value);
        return $ttl > 0 ? $client->setex($key, $ttl, $data) : $client->set($key, $data);
    }

    public static function getValue(string $key): mixed
    {
        $data = self::get()->get($key);
        if ($data === false) return null;
        return json_decode($data, true) ?? $data;
    }

    public static function delete(string $key): bool
    {
        return (bool)self::get()->del($key);
    }

    public static function has(string $key): bool
    {
        return self::get()->exists($key) > 0;
    }

    public static function flushAll(): void
    {
        self::get()->flushAll();
    }
}
