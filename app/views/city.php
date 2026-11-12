<section class="page-head page-head-city">
    <div class="wrap">
        <p class="crumb"><a href="<?= url() ?>">Home</a> / Cities</p>
        <h1><?= e($city['name']) ?></h1>
        <p class="page-lead">
            <?= $articleCount ?> <?= $articleCount === 1 ? 'article' : 'articles' ?> and
            <?= $adCount ?> <?= $adCount === 1 ? 'advertisement' : 'advertisements' ?> from students in <?= e($city['name']) ?>.
        </p>
        <p class="page-jump">
            <a class="btn btn-light" href="#city-articles">Articles</a>
            <a class="btn btn-light" href="#city-market">Marketplace</a>
        </p>
    </div>
</section>

<section class="section" id="city-articles">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2>Articles about <?= e($city['name']) ?></h2>
            <?php if ($articleCount > count($articles)): ?>
                <a class="more" href="<?= url('articles?city=' . $city['slug']) ?>">All <?= $articleCount ?> articles</a>
            <?php endif ?>
        </div>
        <?php if ($articles): ?>
            <div class="stories">
                <?php foreach ($articles as $a): ?>
                    <?php partial('article_row', ['a' => $a]) ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="empty" data-reveal>
                <h3>Nobody has written about <?= e($city['name']) ?> yet</h3>
                <p>If you study here, your experience would be the first guide for this city.</p>
                <a class="btn btn-primary" href="<?= url('articles/new') ?>">Write an article</a>
            </div>
        <?php endif ?>
    </div>
</section>

<section class="section section-tint" id="city-market">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2>For sale in <?= e($city['name']) ?></h2>
            <?php if ($adCount > count($ads)): ?>
                <a class="more" href="<?= url('market?city=' . $city['slug']) ?>">All <?= $adCount ?> advertisements</a>
            <?php endif ?>
        </div>
        <?php if ($ads): ?>
            <div class="offers">
                <?php foreach ($ads as $ad): ?>
                    <?php partial('ad_card', ['ad' => $ad]) ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="empty" data-reveal>
                <h3>Nothing for sale in <?= e($city['name']) ?> yet</h3>
                <p>Post what you are selling and newcomers to this city will see it here.</p>
                <a class="btn btn-primary" href="<?= url('market/new') ?>">Post an ad</a>
            </div>
        <?php endif ?>
    </div>
</section>
