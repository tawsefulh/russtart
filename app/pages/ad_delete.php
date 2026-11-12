<?php
$user = require_login();
$ad = find_post('ads', $params[0]);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$ad || (int) $ad['user_id'] !== (int) $user['id']) {
    not_found();
}

q('DELETE FROM ads WHERE id = ?', [$ad['id']]);
delete_upload($ad['image']);
flash('success', t('Advertisement deleted.'));
redirect('me');
