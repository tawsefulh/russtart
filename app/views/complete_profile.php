<section class="auth auth-single">
    <div class="auth-card">
        <h1><?= et('Finish your profile') ?></h1>
        <p class="auth-lead"><?= et('Hello %s. Tell us where you study so your posts reach the right city.', explode(' ', $user['name'])[0]) ?></p>

        <form method="post" action="<?= url('complete-profile') ?>" novalidate>
            <?= csrf_field() ?>
            <?= field('username', t('Username'), ['required' => true, 'value' => old('username', $user['username']), 'attrs' => ' maxlength="30" autocapitalize="none"', 'hint' => t('Lowercase letters, numbers, underscore.')]) ?>
            <?= select_field('city', t('City in Russia'), $cities, ['other' => t('Other city'), 'other_label' => t('Your city'), 'selected' => old('city', (string) $user['city_id'])]) ?>
            <?php partial('university_field', ['value' => $user['university']]) ?>
            <button class="btn btn-primary btn-block" type="submit"><?= et('Save profile') ?></button>
        </form>
    </div>
</section>
