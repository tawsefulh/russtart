<?php
// Language switcher: remember the choice for a year, then open the same page in that language.
$code = $params[0];
setcookie('lang', $code, [
    'expires'  => time() + 365 * 86400,
    'path'     => BASE_URL . '/',
    'samesite' => 'Lax',
]);

$prefix = BASE_URL . ($code === 'ru' ? '/ru' : '');
$back = $_SERVER['HTTP_REFERER'] ?? '';

if (str_starts_with($back, ORIGIN . BASE_URL . '/')) {
    $page = substr(parse_url($back, PHP_URL_PATH) ?? '', strlen(BASE_URL));
    $page = '/' . trim(preg_replace('#^/ru(?=/|$)#', '', $page), '/');
    $query = parse_url($back, PHP_URL_QUERY);
    if (!str_starts_with($page, '/language/')) {
        header('Location: ' . $prefix . $page . ($query ? '?' . $query : ''));
        exit;
    }
}
header('Location: ' . $prefix . '/');
exit;
