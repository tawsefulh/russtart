<?php /** Search + city + category filter bar. Needs: $action, $filters, $categories, $placeholder */ ?>
<form class="filters" method="get" action="<?= url($action) ?>" data-reveal>
    <div class="field filters-search">
        <div class="field-box">
            <input id="f-q" type="search" name="q" value="<?= e($filters['q']) ?>" placeholder=" ">
            <label for="f-q"><?= e($placeholder) ?></label>
        </div>
    </div>
    <?= select_field('city', 'City', all_cities(), ['selected' => $filters['city'], 'value_key' => 'slug', 'any' => 'All cities']) ?>
    <?= select_field('category', 'Category', $categories, ['selected' => $filters['category'], 'value_key' => 'slug', 'any' => 'All categories']) ?>
    <button class="btn btn-navy" type="submit">Search</button>
</form>
