<article class="read">
    <header class="read-head wrap wrap-narrow">
        <p class="story-tags">
            <a class="tag tag-city" href="<?= url('city/' . $article['city_slug']) ?>"><?= e($article['city']) ?></a>
            <a class="tag" href="<?= url('articles?category=' . $article['category_slug']) ?>"><?= e($article['category']) ?></a>
        </p>
        <h1><?= e($article['title']) ?></h1>
        <p class="byline byline-lg">
            <span class="avatar" aria-hidden="true"><?= e(initials($article['author'])) ?></span>
            <span><strong><?= e($article['author']) ?></strong><br><?= e($article['university']) ?></span>
            <span class="byline-meta">
                <time datetime="<?= e($article['created_at']) ?>"><?= e(date('j F Y', strtotime($article['created_at']))) ?></time><br>
                <?= reading_time($article['body']) ?> min read, <?= (int) $article['views'] ?> <?= (int) $article['views'] === 1 ? 'view' : 'views' ?>
            </span>
        </p>
        <?php if ($isOwner): ?>
            <div class="owner-bar">
                <a class="btn btn-ghost btn-sm" href="<?= url('articles/' . $article['slug'] . '/edit') ?>">Edit article</a>
                <form method="post" action="<?= url('articles/' . $article['slug'] . '/delete') ?>" data-confirm="Delete this article? This cannot be undone.">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger btn-sm" type="submit">Delete article</button>
                </form>
            </div>
        <?php endif ?>
    </header>

    <?php if ($article['cover']): ?>
        <div class="wrap read-cover"><img src="<?= e(upload_url($article['cover'])) ?>" alt=""></div>
    <?php endif ?>

    <div class="wrap wrap-narrow prose">
        <?= format_body($article['body']) ?>
    </div>
</article>

<?php if ($more): ?>
<section class="section section-tint">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2>More about <?= e($article['city']) ?></h2>
            <a class="more" href="<?= url('city/' . $article['city_slug']) ?>">Everything in <?= e($article['city']) ?></a>
        </div>
        <div class="stories">
            <?php foreach ($more as $a): ?>
                <?php partial('article_row', ['a' => $a]) ?>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>
