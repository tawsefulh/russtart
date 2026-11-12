<section class="page-head">
    <div class="wrap">
        <h1><?= et('Articles') ?></h1>
        <p class="page-lead"><?= et('Experience from international students across Russia. Search a question or narrow down by city and topic.') ?></p>
    </div>
</section>

<section class="section section-flush">
    <div class="wrap">
        <?php partial('filters', ['action' => 'articles', 'filters' => $filters, 'categories' => $categories, 'placeholder' => t('Search articles')]) ?>

        <p class="result-count"><?= e(tn($total, 'article')) ?>
            <?php if (array_filter($filters)): ?><a href="<?= url('articles') ?>"><?= et('Clear filters') ?></a><?php endif ?>
        </p>

        <?php if ($rows): ?>
            <div class="stories">
                <?php foreach ($rows as $a): ?>
                    <?php partial('article_row', ['a' => $a]) ?>
                <?php endforeach ?>
            </div>
            <?php partial('pagination', ['page' => $page, 'pages' => $pages]) ?>
        <?php else: ?>
            <div class="empty">
                <h3><?= et('No articles match that search') ?></h3>
                <p><?= et('Try a shorter search or a different city. If you know the answer, write it for the next student.') ?></p>
                <a class="btn btn-primary" href="<?= url('articles/new') ?>"><?= et('Write an article') ?></a>
            </div>
        <?php endif ?>
    </div>
</section>
