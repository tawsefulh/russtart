<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION = [];
    session_regenerate_id(true);
    flash('info', t('Logged out.'));
}
redirect('');
