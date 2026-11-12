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
require ROOT . '/app/auth.php';
require ROOT . '/app/queries.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
}
