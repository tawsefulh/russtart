<?php
function current_user(): ?array
{
    static $user = false;
    if ($user === false) {
        $user = null;
        if (!empty($_SESSION['uid'])) {
            $user = q('SELECT u.*, c.name AS city_name, c.slug AS city_slug
                       FROM users u LEFT JOIN cities c ON c.id = u.city_id
                       WHERE u.id = ?', [$_SESSION['uid']])->fetch() ?: null;
            if (!$user) {
                unset($_SESSION['uid']);
            }
        }
    }
    return $user;
}

function login_user(int $id): void
{
    session_regenerate_id(true);
    $_SESSION['uid'] = $id;
}

function require_login(): array
{
    $u = current_user();
    if (!$u) {
        $_SESSION['after_login'] = $_SERVER['REQUEST_URI'];
        flash('info', 'Log in to continue.');
        redirect('login');
    }
    return $u;
}

/** Send the person back to where they were heading before login. */
function redirect_after_login(): void
{
    $to = $_SESSION['after_login'] ?? null;
    unset($_SESSION['after_login']);
    if ($to && str_starts_with($to, BASE_URL . '/') && !str_starts_with($to, '//')) {
        header('Location: ' . $to);
        exit;
    }
    redirect('');
}

function google_enabled(): bool
{
    global $config;
    return $config['google']['client_id'] !== '' && $config['google']['client_secret'] !== '';
}

function validate_username(string $username, ?int $ignoreId = null): ?string
{
    if (!preg_match('/^[a-z0-9_]{3,30}$/', $username)) {
        return 'Use 3 to 30 lowercase letters, numbers or underscores.';
    }
    $taken = q('SELECT id FROM users WHERE username = ? AND id <> ?', [$username, $ignoreId ?? 0])->fetch();
    return $taken ? 'That username is taken. Try another.' : null;
}
