<section class="auth">
    <div class="auth-side" aria-hidden="true">
        <svg class="auth-route" viewBox="0 0 320 520" fill="none">
            <path d="M60 480V330a70 70 0 0 1 70-70h60a70 70 0 0 0 70-70V60" stroke-width="10" stroke-linecap="round"/>
            <circle class="s1" cx="60" cy="480" r="13" stroke-width="7"/>
            <circle class="s2" cx="160" cy="260" r="13" stroke-width="7"/>
            <circle class="s3" cx="260" cy="60" r="15"/>
        </svg>
        <p>Every guide here was written by a student who arrived the same way you will.</p>
    </div>

    <div class="auth-card">
        <h1>Create account</h1>
        <p class="auth-lead">For students in Russia and the ones on their way. Already a member? <a href="<?= url('login') ?>">Log in</a></p>

        <?php partial('google_button') ?>

        <form method="post" action="<?= url('register') ?>" novalidate>
            <?= csrf_field() ?>
            <?= field('name', 'Full name', ['required' => true, 'attrs' => ' autocomplete="name" maxlength="100"']) ?>
            <div class="field-pair">
                <?= field('username', 'Username', ['required' => true, 'attrs' => ' autocomplete="username" maxlength="30" autocapitalize="none"', 'hint' => 'Lowercase letters, numbers, underscore.']) ?>
                <?= field('email', 'Email', ['type' => 'email', 'required' => true, 'attrs' => ' autocomplete="email"']) ?>
            </div>
            <?= field('password', 'Password', ['type' => 'password', 'required' => true, 'attrs' => ' autocomplete="new-password" minlength="8"', 'hint' => 'At least 8 characters.']) ?>
            <div class="field-pair">
                <?= select_field('city', 'City in Russia', $cities, ['other' => 'Other city', 'other_label' => 'Your city']) ?>
                <?php partial('university_field') ?>
            </div>
            <button class="btn btn-primary btn-block" type="submit">Create account</button>
        </form>
    </div>
</section>
