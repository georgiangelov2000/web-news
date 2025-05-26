<?php
session_start();
$lang = $_GET['lang'] ?? 'en';
if (!in_array($lang, ['en', 'bg'])) {
    $lang = 'en';
}
$_SESSION['lang'] = $lang;
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
exit;