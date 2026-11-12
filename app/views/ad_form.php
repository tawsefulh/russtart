<?php
$v = fn(string $k) => old($k, (string) ($ad[$k] ?? ''));
$price = old('price', isset($ad['price']) ? rtrim(rtrim((string) $ad['price'], '0'), '.') : '');
?>
<section class="section">
    <div class="wrap wrap-narrow">
        <h1 class="form-title"><?= $ad ? et('Edit advertisement') : et('Post an advertisement') ?></h1>
        <p class="page-lead"><?= et('Newcomers will contact you directly, so an address and at least one working number are required.') ?></p>

        <form class="form" method="post" enctype="multipart/form-data" novalidate
              action="<?= url($ad ? 'market/' . $ad['slug'] . '/edit' : 'market/new') ?>">
            <?= csrf_field() ?>

            <fieldset>
                <legend><?= et('What are you offering?') ?></legend>
                <?= field('title', t('Title'), ['required' => true, 'value' => $v('title'), 'attrs' => ' maxlength="140"', 'hint' => t('Example: Oil heater, used one winter')]) ?>
                <div class="field-pair">
                    <?= select_field('category', t('Category'), $categories, ['other' => t('Other (add a new category)'), 'other_label' => t('New category name'),
                        'selected' => old('category', (string) ($ad['category_id'] ?? ''))]) ?>
                    <?= field('price', t('Price in roubles'), ['value' => $price, 'attrs' => ' inputmode="decimal"', 'hint' => t('Leave empty for "Price on request".')]) ?>
                </div>
                <?= field('description', t('Description'), ['type' => 'textarea', 'rows' => 7, 'required' => true, 'value' => $v('description'),
                    'hint' => t('Condition, age, what is included, when you are available.')]) ?>

                <div class="field<?= isset($errors['image']) ? ' has-error' : '' ?>">
                    <label class="upload" data-upload>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
                        <span class="upload-preview"<?= !empty($ad['image']) ? ' style="background-image:url(' . e(upload_url($ad['image'])) . ')"' : '' ?>></span>
                        <span class="upload-text"><strong><?= !empty($ad['image']) ? et('Replace photo') : et('Add a photo') ?></strong><small data-upload-name><?= et('Optional. JPG, PNG or WebP, up to 3 MB.') ?></small></span>
                    </label>
                    <?= field_error('image') ?>
                </div>
            </fieldset>

            <fieldset>
                <legend><?= et('Where can buyers find you?') ?></legend>
                <div class="field-pair">
                    <?= select_field('city', t('City'), $cities, ['other' => t('Other city'), 'other_label' => t('City name'),
                        'selected' => old('city', (string) ($ad['city_id'] ?? $user['city_id']))]) ?>
                    <?= field('address', t('Address'), ['required' => true, 'value' => $v('address'), 'attrs' => ' maxlength="255" autocomplete="street-address"', 'hint' => t('Street and building, or dormitory name and number.')]) ?>
                </div>
            </fieldset>

            <fieldset>
                <legend><?= et('How can buyers contact you?') ?></legend>
                <p class="fieldset-note"><?= et('Fill in at least one. Use the country code, for example +7 912 345 67 89.') ?></p>
                <?= field('phone', t('Phone number'), ['type' => 'tel', 'value' => $v('phone'), 'attrs' => ' autocomplete="tel" maxlength="24"']) ?>
                <div class="field-pair">
                    <?= field('whatsapp', t('WhatsApp number'), ['type' => 'tel', 'value' => $v('whatsapp'), 'attrs' => ' maxlength="24"']) ?>
                    <?= field('telegram', t('Telegram username or number'), ['value' => $v('telegram'), 'attrs' => ' maxlength="40" autocapitalize="none"']) ?>
                </div>
            </fieldset>

            <div class="form-actions">
                <button class="btn btn-primary btn-lg" type="submit"><?= $ad ? et('Save changes') : et('Post advertisement') ?></button>
                <a class="btn btn-ghost" href="<?= url($ad ? 'market/' . $ad['slug'] : 'market') ?>"><?= et('Cancel') ?></a>
            </div>
        </form>
    </div>
</section>
