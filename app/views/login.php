<section class="auth">
    <?php partial('auth_side', ['text' => t('Good to see you again. Someone is reading what you wrote right now.')]) ?>

    <div class="auth-card">
        <h1><?= et('Log in') ?></h1>
        <p class="auth-lead"><?= et('New here?') ?> <a href="<?= url('register') ?>"><?= et('Create account') ?></a></p>

        <?php partial('google_button') ?>

        <form method="post" action="<?= url('login') ?>" novalidate>
            <?= csrf_field() ?>
            <?= field('login', t('Email or username'), ['required' => true, 'attrs' => ' autocomplete="username" autocapitalize="none"']) ?>
            <?= field('password', t('Password'), ['type' => 'password', 'required' => true, 'attrs' => ' autocomplete="current-password"']) ?>
            <button class="btn btn-primary btn-block" type="submit"><?= et('Log in') ?></button>
        </form>
    </div>
</section>
