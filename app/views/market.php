<section class="page-head">
    <div class="wrap page-head-row">
        <div>
            <h1>Marketplace</h1>
            <p class="page-lead">Things and services offered by people already living in Russia. Contact the seller directly by phone, WhatsApp or Telegram.</p>
        </div>
        <a class="btn btn-primary" href="<?= url('market/new') ?>">Post an ad</a>
    </div>
</section>

<section class="section section-flush">
    <div class="wrap">
        <?php partial('filters', ['action' => 'market', 'filters' => $filters, 'categories' => $categories, 'placeholder' => 'Search advertisements']) ?>

        <p class="result-count"><?= $total ?> <?= $total === 1 ? 'advertisement' : 'advertisements' ?><?= array_filter($filters) ? ' found' : '' ?>
            <?php if (array_filter($filters)): ?><a href="<?= url('market') ?>">Clear filters</a><?php endif ?>
        </p>

        <?php if ($rows): ?>
            <div class="offers">
                <?php foreach ($rows as $ad): ?>
                    <?php partial('ad_card', ['ad' => $ad]) ?>
                <?php endforeach ?>
            </div>
            <?php partial('pagination', ['page' => $page, 'pages' => $pages]) ?>
        <?php else: ?>
            <div class="empty">
                <h3>No advertisements match that search</h3>
                <p>Try a different city or category, or post what you have to offer.</p>
                <a class="btn btn-primary" href="<?= url('market/new') ?>">Post an ad</a>
            </div>
        <?php endif ?>
    </div>
</section>
