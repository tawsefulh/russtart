<?php $v = fn(string $k) => old($k, (string) ($article[$k] ?? '')); ?>
<section class="section">
    <div class="wrap wrap-narrow">
        <h1 class="form-title"><?= $article ? 'Edit article' : 'Write an article' ?></h1>
        <p class="page-lead">Write it the way you would explain it to a friend arriving next month: what to do, in what order, and what it cost.</p>

        <form class="form" method="post" enctype="multipart/form-data" novalidate
              action="<?= url($article ? 'articles/' . $article['slug'] . '/edit' : 'articles/new') ?>">
            <?= csrf_field() ?>

            <?= field('title', 'Title', ['required' => true, 'value' => $v('title'), 'attrs' => ' maxlength="160"', 'hint' => 'Example: How I registered my visa in Kazan in three days']) ?>

            <div class="field-pair">
                <?= select_field('city', 'City', $cities, ['other' => 'Other city', 'other_label' => 'City name',
                    'selected' => old('city', (string) ($article['city_id'] ?? $user['city_id']))]) ?>
                <?= select_field('category', 'Category', $categories, ['other' => 'Other (add a new category)', 'other_label' => 'New category name',
                    'selected' => old('category', (string) ($article['category_id'] ?? ''))]) ?>
            </div>

            <?= field('body', 'Your experience', ['type' => 'textarea', 'rows' => 16, 'required' => true, 'value' => $v('body'),
                'hint' => 'Leave an empty line between paragraphs. Start a line with ## to make a subheading.']) ?>

            <div class="field<?= isset($errors['cover']) ? ' has-error' : '' ?>">
                <label class="upload" data-upload>
                    <input type="file" name="cover" accept="image/jpeg,image/png,image/webp">
                    <span class="upload-preview"<?= !empty($article['cover']) ? ' style="background-image:url(' . e(upload_url($article['cover'])) . ')"' : '' ?>></span>
                    <span class="upload-text"><strong><?= !empty($article['cover']) ? 'Replace cover photo' : 'Add a cover photo' ?></strong><small data-upload-name>Optional. JPG, PNG or WebP, up to 3 MB.</small></span>
                </label>
                <?= field_error('cover') ?>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary btn-lg" type="submit"><?= $article ? 'Save changes' : 'Publish article' ?></button>
                <a class="btn btn-ghost" href="<?= url($article ? 'articles/' . $article['slug'] : 'articles') ?>">Cancel</a>
            </div>
        </form>
    </div>
</section>
