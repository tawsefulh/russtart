<?php $cityNames = array_column(all_cities(), 'name'); ?>

<section class="hero">
    <div class="wrap hero-inner">
        <h1 class="hero-title">
            <span class="line"><span><?= et('Landing in Russia soon?') ?></span></span>
            <span class="line"><span><?= et('Read the students') ?></span></span>
            <span class="line"><span><?= et('who got there first.') ?></span></span>
        </h1>
        <p class="hero-lead"><?= et('Visas, dormitories, SIM cards, the first winter. Real experience from international students, sorted by the city you are going to.') ?></p>

        <form class="hero-search" method="get" action="<?= url('go') ?>" role="search">
            <label for="hero-city"><?= et('Which city are you going to?') ?></label>
            <div class="hero-search-row">
                <div class="suggest" data-suggest='<?= e(json_encode($cityNames, JSON_UNESCAPED_UNICODE)) ?>'>
                    <input id="hero-city" type="text" name="q" placeholder="<?= e(implode(', ', array_slice($cityNames, 0, 3))) ?>…" autocomplete="off" required>
                </div>
                <button class="btn btn-primary btn-lg" type="submit"><?= et('Show my city') ?></button>
            </div>
        </form>

        <div class="route-wrap" data-route>
            <nav class="route" aria-label="<?= et('Cities') ?>">
                <ol>
                    <?php foreach ($stations as $i => $s): ?>
                        <li style="--i: <?= min($i, 9) ?>"<?= $s['slug'] === $config['main_city'] ? ' class="is-main"' : '' ?>><a href="<?= url('city/' . $s['slug']) ?>" draggable="false"><i aria-hidden="true"></i><?= e($s['name']) ?></a></li>
                    <?php endforeach ?>
                </ol>
            </nav>
            <div class="route-arrows" hidden>
                <button type="button" data-route-prev aria-label="<?= et('Previous cities') ?>"></button>
                <button type="button" data-route-next aria-label="<?= et('More cities') ?>"></button>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2><?= et('Latest from students') ?></h2>
            <a class="more" href="<?= url('articles') ?>"><?= et('All articles') ?></a>
        </div>

        <?php if ($articles): ?>
            <div class="stories stories-home">
                <?php foreach ($articles as $i => $a): ?>
                    <?php partial('article_row', ['a' => $a, 'lead' => $i === 0]) ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="empty" data-reveal>
                <h3><?= et('No articles yet') ?></h3>
                <p><?= et('Be the first to write down what you wish someone had told you before you arrived.') ?></p>
                <a class="btn btn-primary" href="<?= url('articles/new') ?>"><?= et('Write an article') ?></a>
            </div>
        <?php endif ?>
    </div>
</section>

<section class="section section-tint">
    <div class="wrap topics" data-reveal>
        <h2><?= et('Find answers by topic') ?></h2>
        <ul>
            <?php foreach ($topics as $t): ?>
                <li><a href="<?= url('articles?category=' . $t['slug']) ?>"><?= e($t['name']) ?><?php if ($t['total']): ?><b><?= (int) $t['total'] ?></b><?php endif ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <div>
                <h2><?= et('Marketplace') ?></h2>
                <p><?= et('Buy what you need from students and residents who are already in your city.') ?></p>
            </div>
            <a class="more" href="<?= url('market') ?>"><?= et('All advertisements') ?></a>
        </div>

        <?php if ($ads): ?>
            <div class="offers">
                <?php foreach ($ads as $ad): ?>
                    <?php partial('ad_card', ['ad' => $ad]) ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="empty" data-reveal>
                <h3><?= et('No advertisements yet') ?></h3>
                <p><?= et('Selling a heater, textbooks or a bicycle before you leave? Newcomers are looking for exactly that.') ?></p>
                <a class="btn btn-primary" href="<?= url('market/new') ?>"><?= et('Post an ad') ?></a>
            </div>
        <?php endif ?>
    </div>
</section>

<?php if (!current_user()): ?>
<section class="section">
    <div class="wrap">
        <div class="join" data-reveal>
            <div>
                <h2><?= et('Already studying in Russia?') ?></h2>
                <p><?= et('Your first month is someone else\'s biggest worry. Share how you handled it, or sell what the next student needs.') ?></p>
            </div>
            <a class="btn btn-primary btn-lg" href="<?= url('register') ?>"><?= et('Create account') ?></a>
        </div>
    </div>
</section>
<?php endif ?>
