<?php /** Search + city + category filter bar. Needs: $action, $filters, $categories, $placeholder */ ?>
<form class="filters" method="get" action="<?= url($action) ?>" data-reveal>
    <div class="field filters-search">
        <div class="field-box">
            <input id="f-q" type="search" name="q" value="<?= e($filters['q']) ?>" placeholder=" ">
            <label for="f-q"><?= e($placeholder) ?></label>
        </div>
    </div>
    <?= select_field('city', t('City'), all_cities(), ['selected' => $filters['city'], 'value_key' => 'slug', 'any' => t('All cities')]) ?>
    <?= select_field('category', t('Category'), $categories, ['selected' => $filters['category'], 'value_key' => 'slug', 'any' => t('All categories')]) ?>
    <button class="btn btn-navy" type="submit"><?= et('Search') ?></button>
</form>
