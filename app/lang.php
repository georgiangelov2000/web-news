<?php
function lang($key) {
    static $lang = null;
    if ($lang === null) {
        $session = $GLOBALS['session'] ?? null;
        $currentLang = $_SESSION['lang'] ?? ($session ? $session->get('lang') : 'en') ?? 'en';
        $path = __DIR__ . "/../../config/lang/{$currentLang}.php";
        if (!file_exists($path)) {
            $path = __DIR__ . "/../../config/lang/en.php";
        }
        $lang = require $path;
    }
    return $lang[$key] ?? $key;
}