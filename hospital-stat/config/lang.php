<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$lang = $_SESSION['lang'] ?? 'ru';
$langFile = __DIR__ . "/../language/$lang/$lang.php";

if (file_exists($langFile)) {
    $GLOBALS['lang'] = require $langFile;
} else {
    $GLOBALS['lang'] = require __DIR__ . '/../language/ru/ru.php';
}

function __($key) {
    return $GLOBALS['lang'][$key] ?? $key;
}
