<?php
define('ROOT', dirname(__DIR__));

$config = require ROOT . '/config/config.php';

error_reporting(E_ALL);
ini_set('display_errors', $config['debug'] ? '1' : '0');
mb_internal_encoding('UTF-8');
date_default_timezone_set('Europe/Moscow');

// Folder the site lives in: "/russtart" on XAMPP, "" on a real domain
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
define('BASE_URL', $base === '.' ? '' : $base);

// Page being asked for, without the site folder and without the language prefix
$routePath = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');
if (BASE_URL !== '' && str_starts_with($routePath, BASE_URL)) {
    $routePath = substr($routePath, strlen(BASE_URL));
}
$routePath = '/' . trim($routePath, '/');
$urlLang = 'en';
if (preg_match('#^/ru(/.*)?$#', $routePath, $m)) {
    $urlLang = 'ru';
    $routePath = '/' . trim($m[1] ?? '', '/');
}
define('URL_LANG', $urlLang);      // English pages: /articles   Russian pages: /ru/articles
define('ROUTE_PATH', $routePath);

$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https');
define('ORIGIN', ($https ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));

session_name('russtart');
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => BASE_URL . '/',
    'httponly' => true,
    'secure'   => $https,
    'samesite' => 'Lax',
]);
session_start();

require ROOT . '/app/db.php';
require ROOT . '/app/helpers.php';
require ROOT . '/app/i18n.php';
require ROOT . '/app/auth.php';
require ROOT . '/app/queries.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
}
