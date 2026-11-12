<section class="auth">
    <div class="auth-side" aria-hidden="true">
        <svg class="auth-route" viewBox="0 0 320 520" fill="none">
            <path d="M60 480V330a70 70 0 0 1 70-70h60a70 70 0 0 0 70-70V60" stroke-width="10" stroke-linecap="round"/>
            <circle class="s1" cx="60" cy="480" r="13" stroke-width="7"/>
            <circle class="s2" cx="160" cy="260" r="13" stroke-width="7"/>
            <circle class="s3" cx="260" cy="60" r="15"/>
        </svg>
        <p>Good to see you again. Someone is reading what you wrote right now.</p>
    </div>

    <div class="auth-card">
        <h1>Log in</h1>
        <p class="auth-lead">New here? <a href="<?= url('register') ?>">Create account</a></p>

        <?php partial('google_button') ?>

        <form method="post" action="<?= url('login') ?>" novalidate>
            <?= csrf_field() ?>
            <?= field('login', 'Email or username', ['required' => true, 'attrs' => ' autocomplete="username" autocapitalize="none"']) ?>
            <?= field('password', 'Password', ['type' => 'password', 'required' => true, 'attrs' => ' autocomplete="current-password"']) ?>
            <button class="btn btn-primary btn-block" type="submit">Log in</button>
        </form>
    </div>
</section>
