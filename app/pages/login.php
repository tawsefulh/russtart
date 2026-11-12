<?php
if (current_user()) {
    redirect('');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = mb_strtolower(post('login'));
    $password = $_POST['password'] ?? '';

    $user = q('SELECT id, password_hash FROM users WHERE email = ? OR username = ?', [$login, $login])->fetch();

    if ($user && $user['password_hash'] && is_string($password) && password_verify($password, $user['password_hash'])) {
        login_user((int) $user['id']);
        redirect_after_login();
    }

    if ($user && !$user['password_hash']) {
        $errors['login'] = 'This account was created with Google. Use "Continue with Google" to log in.';
    } else {
        $errors['login'] = 'The email, username or password is not correct.';
    }
    usleep(400000); // slow down guessing
}

render('login', ['title' => 'Log in', 'bodyClass' => 'is-auth']);
