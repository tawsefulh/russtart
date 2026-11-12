<?php
// Step 2 of Google sign-in: Google sends the person back here with a code.
function google_fail(string $why = ''): void
{
    global $config;
    flash('error', 'Google sign-in did not finish. Try again.' . ($config['debug'] && $why ? " ($why)" : ''));
    redirect('login');
}

function http_json(string $url, ?array $post = null, array $headers = []): ?array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_HTTPHEADER     => $headers,
    ]);
    if ($post !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }
    $body = curl_exec($ch);
    curl_close($ch);
    $data = is_string($body) ? json_decode($body, true) : null;
    return is_array($data) ? $data : null;
}

$state = $_SESSION['google_state'] ?? '';
unset($_SESSION['google_state']);

if (!google_enabled() || $state === '' || !hash_equals($state, query('state')) || query('code') === '') {
    google_fail(query('error'));
}

$token = http_json('https://oauth2.googleapis.com/token', [
    'code'          => query('code'),
    'client_id'     => $config['google']['client_id'],
    'client_secret' => $config['google']['client_secret'],
    'redirect_uri'  => ORIGIN . url('auth/google/callback'),
    'grant_type'    => 'authorization_code',
]);
if (empty($token['access_token'])) {
    google_fail($token['error_description'] ?? 'no token');
}

$profile = http_json('https://openidconnect.googleapis.com/v1/userinfo', null,
    ['Authorization: Bearer ' . $token['access_token']]);
if (empty($profile['sub']) || empty($profile['email']) || empty($profile['email_verified'])) {
    google_fail('no verified email');
}

$email = mb_strtolower($profile['email']);
$user = q('SELECT id, google_id FROM users WHERE google_id = ? OR email = ? ORDER BY google_id = ? DESC LIMIT 1',
    [$profile['sub'], $email, $profile['sub']])->fetch();

if ($user) {
    if (!$user['google_id']) {
        q('UPDATE users SET google_id = ? WHERE id = ?', [$profile['sub'], $user['id']]);
    }
    login_user((int) $user['id']);
    redirect_after_login();
}

// New person: make a username from the email, then ask for city and university
$base = substr(preg_replace('/[^a-z0-9_]/', '', strtolower(strstr($email, '@', true))), 0, 24);
$base = strlen($base) >= 3 ? $base : 'student';
$username = $base;
while (q('SELECT 1 FROM users WHERE username = ?', [$username])->fetch()) {
    $username = $base . random_int(100, 9999);
}

q('INSERT INTO users (name, username, email, google_id) VALUES (?, ?, ?, ?)',
    [clean_name($profile['name'] ?? $base), $username, $email, $profile['sub']]);
login_user((int) db()->lastInsertId());
redirect('complete-profile');
