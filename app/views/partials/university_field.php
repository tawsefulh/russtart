<?php global $config, $errors; ?>
<div class="field<?= isset($errors['university']) ? ' has-error' : '' ?>">
    <div class="field-box suggest" data-suggest='<?= e(json_encode($config['universities'], JSON_UNESCAPED_UNICODE)) ?>'>
        <input id="f-university" type="text" name="university" value="<?= e(old('university', $value ?? '')) ?>" placeholder=" " autocomplete="off" maxlength="160" required>
        <label for="f-university"><?= et('University') ?></label>
    </div>
    <?= field_error('university') ?>
    <p class="field-hint"><?= et('Pick from the list or type your own.') ?></p>
</div>
