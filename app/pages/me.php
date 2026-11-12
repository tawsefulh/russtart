<?php
$user = require_login();

render('me', [
    'title'    => t('My posts'),
    'user'     => $user,
    'articles' => find_posts('articles', ['user_id' => $user['id']], 100),
    'ads'      => find_posts('ads', ['user_id' => $user['id']], 100),
]);
