<article class="story<?= !empty($lead) ? ' story-lead' : '' ?>" data-reveal>
    <?php if ($a['cover']): ?>
        <a class="story-cover" href="<?= url('articles/' . $a['slug']) ?>" tabindex="-1" aria-hidden="true">
            <img src="<?= e(upload_url($a['cover'])) ?>" alt="" loading="lazy">
        </a>
    <?php endif ?>
    <div class="story-text">
        <p class="story-tags">
            <a class="tag tag-city" href="<?= url('city/' . $a['city_slug']) ?>"><?= e($a['city']) ?></a>
            <a class="tag" href="<?= url('articles?category=' . $a['category_slug']) ?>"><?= e($a['category']) ?></a>
        </p>
        <h3><a href="<?= url('articles/' . $a['slug']) ?>"><?= e($a['title']) ?></a></h3>
        <p class="story-excerpt"><?= e($a['excerpt']) ?></p>
        <p class="byline">
            <span class="avatar avatar-sm" aria-hidden="true"><?= e(initials($a['author'])) ?></span>
            <span><?= e($a['author']) ?>, <?= e($a['university']) ?></span>
            <time datetime="<?= e($a['created_at']) ?>"><?= e(short_date($a['created_at'])) ?></time>
        </p>
    </div>
</article>
