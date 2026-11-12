<section class="page-head page-head-city">
    <div class="wrap">
        <p class="crumb"><a href="<?= url() ?>"><?= et('Home') ?></a> / <?= et('Cities') ?></p>
        <h1><?= e($city['name']) ?></h1>
        <p class="page-lead"><?= et('%s and %s from students in %s.', tn($articleCount, 'article'), tn($adCount, 'advertisement'), $city['name']) ?></p>
        <p class="page-jump">
            <a class="btn btn-light" href="#city-articles"><?= et('Articles') ?></a>
            <a class="btn btn-light" href="#city-market"><?= et('Marketplace') ?></a>
        </p>
    </div>
</section>

<section class="section" id="city-articles">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2><?= et('Articles about %s', $city['name']) ?></h2>
            <?php if ($articleCount > count($articles)): ?>
                <a class="more" href="<?= url('articles?city=' . $city['slug']) ?>"><?= et('All articles') ?> (<?= $articleCount ?>)</a>
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
                <h3><?= et('Nobody has written about %s yet', $city['name']) ?></h3>
                <p><?= et('If you study here, your experience would be the first guide for this city.') ?></p>
                <a class="btn btn-primary" href="<?= url('articles/new') ?>"><?= et('Write an article') ?></a>
            </div>
        <?php endif ?>
    </div>
</section>

<section class="section section-tint" id="city-market">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2><?= et('For sale in %s', $city['name']) ?></h2>
            <?php if ($adCount > count($ads)): ?>
                <a class="more" href="<?= url('market?city=' . $city['slug']) ?>"><?= et('All advertisements') ?> (<?= $adCount ?>)</a>
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
                <h3><?= et('Nothing for sale in %s yet', $city['name']) ?></h3>
                <p><?= et('Post what you are selling and newcomers to this city will see it here.') ?></p>
                <a class="btn btn-primary" href="<?= url('market/new') ?>"><?= et('Post an ad') ?></a>
            </div>
        <?php endif ?>
    </div>
</section>
