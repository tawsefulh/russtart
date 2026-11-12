<?php
if (current_user()) {
    redirect('');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = clean_name(post('name'));
    $username   = mb_strtolower(post('username'));
    $email      = mb_strtolower(post('email'));
    $password   = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $university = trim(preg_replace('/\s+/u', ' ', post('university')));

    if (mb_strlen($name) < 2 || mb_strlen($name) > 100) {
        $errors['name'] = 'Enter your full name.';
    }
    if ($msg = validate_username($username)) {
        $errors['username'] = $msg;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) {
        $errors['email'] = 'Enter a valid email address.';
    } elseif (q('SELECT 1 FROM users WHERE email = ?', [$email])->fetch()) {
        $errors['email'] = 'An account with this email already exists. Log in instead.';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Use at least 8 characters.';
    }
    if (mb_strlen($university) < 2 || mb_strlen($university) > 160) {
        $errors['university'] = 'Enter your university.';
    }
    $cityId = resolve_city();

    if (!$errors) {
        q('INSERT INTO users (name, username, email, password_hash, city_id, university) VALUES (?, ?, ?, ?, ?, ?)',
            [$name, $username, $email, password_hash($password, PASSWORD_DEFAULT), $cityId, $university]);
        login_user((int) db()->lastInsertId());
        flash('success', 'Account created. Welcome to RusStart, ' . explode(' ', $name)[0] . '.');
        redirect_after_login();
    }
}

render('register', [
    'title'     => 'Create account',
    'cities'    => all_cities(),
    'bodyClass' => 'is-auth',
]);
