<?php
$v = fn(string $k) => old($k, (string) ($ad[$k] ?? ''));
$price = old('price', isset($ad['price']) ? rtrim(rtrim((string) $ad['price'], '0'), '.') : '');
?>
<section class="section">
    <div class="wrap wrap-narrow">
        <h1 class="form-title"><?= $ad ? 'Edit advertisement' : 'Post an advertisement' ?></h1>
        <p class="page-lead">Newcomers will contact you directly, so an address and at least one working number are required.</p>

        <form class="form" method="post" enctype="multipart/form-data" novalidate
              action="<?= url($ad ? 'market/' . $ad['slug'] . '/edit' : 'market/new') ?>">
            <?= csrf_field() ?>

            <fieldset>
                <legend>What are you offering?</legend>
                <?= field('title', 'Title', ['required' => true, 'value' => $v('title'), 'attrs' => ' maxlength="140"', 'hint' => 'Example: Oil heater, used one winter']) ?>
                <div class="field-pair">
                    <?= select_field('category', 'Category', $categories, ['other' => 'Other (add a new category)', 'other_label' => 'New category name',
                        'selected' => old('category', (string) ($ad['category_id'] ?? ''))]) ?>
                    <?= field('price', 'Price in roubles', ['value' => $price, 'attrs' => ' inputmode="decimal"', 'hint' => 'Leave empty for "Price on request".']) ?>
                </div>
                <?= field('description', 'Description', ['type' => 'textarea', 'rows' => 7, 'required' => true, 'value' => $v('description'),
                    'hint' => 'Condition, age, what is included, when you are available.']) ?>

                <div class="field<?= isset($errors['image']) ? ' has-error' : '' ?>">
                    <label class="upload" data-upload>
                        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
                        <span class="upload-preview"<?= !empty($ad['image']) ? ' style="background-image:url(' . e(upload_url($ad['image'])) . ')"' : '' ?>></span>
                        <span class="upload-text"><strong><?= !empty($ad['image']) ? 'Replace photo' : 'Add a photo' ?></strong><small data-upload-name>Optional. JPG, PNG or WebP, up to 3 MB.</small></span>
                    </label>
                    <?= field_error('image') ?>
                </div>
            </fieldset>

            <fieldset>
                <legend>Where can buyers find you?</legend>
                <div class="field-pair">
                    <?= select_field('city', 'City', $cities, ['other' => 'Other city', 'other_label' => 'City name',
                        'selected' => old('city', (string) ($ad['city_id'] ?? $user['city_id']))]) ?>
                    <?= field('address', 'Address', ['required' => true, 'value' => $v('address'), 'attrs' => ' maxlength="255" autocomplete="street-address"', 'hint' => 'Street and building, or dormitory name and number.']) ?>
                </div>
            </fieldset>

            <fieldset>
                <legend>How can buyers contact you?</legend>
                <p class="fieldset-note">Fill in at least one. Use the country code, for example +7 912 345 67 89.</p>
                <?= field('phone', 'Phone number', ['type' => 'tel', 'value' => $v('phone'), 'attrs' => ' autocomplete="tel" maxlength="24"']) ?>
                <div class="field-pair">
                    <?= field('whatsapp', 'WhatsApp number', ['type' => 'tel', 'value' => $v('whatsapp'), 'attrs' => ' maxlength="24"']) ?>
                    <?= field('telegram', 'Telegram username or number', ['value' => $v('telegram'), 'attrs' => ' maxlength="40" autocapitalize="none"']) ?>
                </div>
            </fieldset>

            <div class="form-actions">
                <button class="btn btn-primary btn-lg" type="submit"><?= $ad ? 'Save changes' : 'Post advertisement' ?></button>
                <a class="btn btn-ghost" href="<?= url($ad ? 'market/' . $ad['slug'] : 'market') ?>">Cancel</a>
            </div>
        </form>
    </div>
</section>
