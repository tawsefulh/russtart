<?php
$user = require_login();
if ($user['city_id'] && $user['university']) {
    redirect('');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = mb_strtolower(post('username'));
    $university = trim(preg_replace('/\s+/u', ' ', post('university')));

    if ($msg = validate_username($username, (int) $user['id'])) {
        $errors['username'] = $msg;
    }
    if (mb_strlen($university) < 2 || mb_strlen($university) > 160) {
        $errors['university'] = 'Enter your university.';
    }
    $cityId = resolve_city();

    if (!$errors) {
        q('UPDATE users SET username = ?, university = ?, city_id = ? WHERE id = ?',
            [$username, $university, $cityId, $user['id']]);
        flash('success', 'Profile complete. Welcome to RusStart.');
        redirect_after_login();
    }
}

render('complete_profile', [
    'title'     => 'Finish your profile',
    'user'      => $user,
    'cities'    => all_cities(),
    'bodyClass' => 'is-auth',
]);
