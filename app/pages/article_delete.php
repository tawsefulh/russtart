<?php
$user = require_login();
$article = find_post('articles', $params[0]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$article || (int) $article['user_id'] !== (int) $user['id']) {
    not_found();
}

q('DELETE FROM articles WHERE id = ?', [$article['id']]);
delete_upload($article['cover']);
flash('success', t('Article deleted.'));
redirect('me');
