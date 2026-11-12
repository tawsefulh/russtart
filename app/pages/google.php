<?php
// Step 1 of Google sign-in: send the person to Google.
if (!google_enabled()) {
    flash('error', t('Google sign-in is not set up yet. Use email and password.'));
    redirect('login');
}

$_SESSION['google_state'] = bin2hex(random_bytes(16));

header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
    'client_id'     => $config['google']['client_id'],
    'redirect_uri'  => ORIGIN . base_url('auth/google/callback'),
    'response_type' => 'code',
    'scope'         => 'openid email profile',
    'state'         => $_SESSION['google_state'],
    'prompt'        => 'select_account',
]));
exit;
