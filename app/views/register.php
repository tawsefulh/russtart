<section class="auth">
    <?php partial('auth_side', ['text' => t('Every guide here was written by a student who arrived the same way you will.')]) ?>

    <div class="auth-card">
        <h1><?= et('Create account') ?></h1>
        <p class="auth-lead"><?= et('For students in Russia and the ones on their way.') ?> <?= et('Already a member?') ?> <a href="<?= url('login') ?>"><?= et('Log in') ?></a></p>

        <?php partial('google_button') ?>

        <form method="post" action="<?= url('register') ?>" novalidate>
            <?= csrf_field() ?>
            <?= field('name', t('Full name'), ['required' => true, 'attrs' => ' autocomplete="name" maxlength="100"']) ?>
            <div class="field-pair">
                <?= field('username', t('Username'), ['required' => true, 'attrs' => ' autocomplete="username" maxlength="30" autocapitalize="none"', 'hint' => t('Lowercase letters, numbers, underscore.')]) ?>
                <?= field('email', t('Email'), ['type' => 'email', 'required' => true, 'attrs' => ' autocomplete="email"']) ?>
            </div>
            <?= field('password', t('Password'), ['type' => 'password', 'required' => true, 'attrs' => ' autocomplete="new-password" minlength="8"', 'hint' => t('At least 8 characters.')]) ?>
            <div class="field-pair">
                <?= select_field('city', t('City in Russia'), $cities, ['other' => t('Other city'), 'other_label' => t('Your city')]) ?>
                <?php partial('university_field') ?>
            </div>
            <button class="btn btn-primary btn-block" type="submit"><?= et('Create account') ?></button>
        </form>
    </div>
</section>
