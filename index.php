<?php
/**
 * Front controller: every page request comes through here.
 */

// Support `php -S localhost:8000 index.php` as an alternative to Apache
if (PHP_SAPI === 'cli-server') {
    $p = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (preg_match('#^/(assets|uploads)/#', $p) && is_file(__DIR__ . $p) && !preg_match('/\.php$/i', $p)) {
        return false;
    }
}

require __DIR__ . '/app/bootstrap.php';

$path = ROUTE_PATH;

// A visitor who prefers Russian (chosen earlier, or detected) and opened an English address goes to /ru
if (URL_LANG === 'en' && $_SERVER['REQUEST_METHOD'] === 'GET' && preferred_lang() === 'ru'
    && !preg_match('#^/(language|auth)/#', $path)) {
    header('Location: ' . lang_url('ru'), true, 302);
    exit;
}

$slug = '([a-z0-9][a-z0-9-]*)';
$routes = [
    '#^/$#'                           => 'home',
    '#^/go$#'                         => 'go',
    '#^/language/(en|ru)$#'           => 'lang',
    '#^/login$#'                      => 'login',
    '#^/register$#'                   => 'register',
    '#^/logout$#'                     => 'logout',
    '#^/auth/google$#'                => 'google',
    '#^/auth/google/callback$#'       => 'google_callback',
    '#^/complete-profile$#'           => 'complete_profile',
    '#^/me$#'                         => 'me',
    '#^/articles$#'                   => 'articles',
    '#^/articles/new$#'               => 'article_form',
    "#^/articles/$slug/edit$#"        => 'article_form',
    "#^/articles/$slug/delete$#"      => 'article_delete',
    "#^/articles/$slug$#"             => 'article_show',
    '#^/market$#'                     => 'market',
    '#^/market/new$#'                 => 'ad_form',
    "#^/market/$slug/edit$#"          => 'ad_form',
    "#^/market/$slug/delete$#"        => 'ad_delete',
    "#^/market/$slug$#"               => 'ad_show',
    "#^/city/$slug$#"                 => 'city',
];

foreach ($routes as $pattern => $page) {
    if (preg_match($pattern, $path, $m)) {
        $params = array_slice($m, 1);

        // People who signed up with Google still owe us a city and university
        $u = current_user();
        if ($u && (!$u['city_id'] || !$u['university']) && !in_array($page, ['complete_profile', 'logout', 'lang'], true)) {
            redirect('complete-profile');
        }

        require ROOT . "/app/pages/$page.php";
        exit;
    }
}

not_found();
