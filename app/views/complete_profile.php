<section class="auth auth-single">
    <div class="auth-card">
        <h1>Finish your profile</h1>
        <p class="auth-lead">Hello <?= e(explode(' ', $user['name'])[0]) ?>. Tell us where you study so your posts reach the right city.</p>

        <form method="post" action="<?= url('complete-profile') ?>" novalidate>
            <?= csrf_field() ?>
            <?= field('username', 'Username', ['required' => true, 'value' => old('username', $user['username']), 'attrs' => ' maxlength="30" autocapitalize="none"', 'hint' => 'Lowercase letters, numbers, underscore.']) ?>
            <?= select_field('city', 'City in Russia', $cities, ['other' => 'Other city', 'other_label' => 'Your city', 'selected' => old('city', (string) $user['city_id'])]) ?>
            <?php partial('university_field', ['value' => $user['university']]) ?>
            <button class="btn btn-primary btn-block" type="submit">Save profile</button>
        </form>
    </div>
</section>
