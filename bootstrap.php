<?php
// bootstrap.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';

use App\Session\Session;
use App\Security\SessionGuard;
use App\Security\RateLimiter;

$GLOBALS['session'] = new Session(__DIR__ . '/storage/session');

$guard = new SessionGuard($GLOBALS['session']);
$guard->enforce();

$clientIp = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
$limiter = new RateLimiter(__DIR__ . '/storage/ratelimit/');
$limiter->check($clientIp);
