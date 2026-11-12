<?php $cityNames = array_column(all_cities(), 'name'); ?>

<section class="hero">
    <div class="wrap hero-inner">
        <h1 class="hero-title">
            <span class="line"><span>Landing in Russia soon?</span></span>
            <span class="line"><span>Read the students</span></span>
            <span class="line"><span>who got there first.</span></span>
        </h1>
        <p class="hero-lead">Visas, dormitories, SIM cards, the first winter. Real experience from international students, sorted by the city you are going to.</p>

        <form class="hero-search" method="get" action="<?= url('go') ?>" role="search">
            <label for="hero-city">Which city are you going to?</label>
            <div class="hero-search-row">
                <div class="suggest" data-suggest='<?= e(json_encode($cityNames)) ?>'>
                    <input id="hero-city" type="text" name="q" placeholder="Moscow, Kazan, Tomsk…" autocomplete="off" required>
                </div>
                <button class="btn btn-primary btn-lg" type="submit">Show my city</button>
            </div>
        </form>

        <nav class="route" aria-label="Popular cities">
            <ol>
                <?php foreach ($stations as $i => $s): ?>
                    <li style="--i: <?= $i ?>"><a href="<?= url('city/' . $s['slug']) ?>"><i aria-hidden="true"></i><?= e($s['name']) ?></a></li>
                <?php endforeach ?>
            </ol>
        </nav>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2>Latest from students</h2>
            <a class="more" href="<?= url('articles') ?>">All articles</a>
        </div>

        <?php if ($articles): ?>
            <div class="stories stories-home">
                <?php foreach ($articles as $i => $a): ?>
                    <?php partial('article_row', ['a' => $a, 'lead' => $i === 0]) ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="empty" data-reveal>
                <h3>No articles yet</h3>
                <p>Be the first to write down what you wish someone had told you before you arrived.</p>
                <a class="btn btn-primary" href="<?= url('articles/new') ?>">Write an article</a>
            </div>
        <?php endif ?>
    </div>
</section>

<section class="section section-tint">
    <div class="wrap topics" data-reveal>
        <h2>Find answers by topic</h2>
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
                <h2>Marketplace</h2>
                <p>Buy what you need from students and residents who are already in your city.</p>
            </div>
            <a class="more" href="<?= url('market') ?>">All advertisements</a>
        </div>

        <?php if ($ads): ?>
            <div class="offers">
                <?php foreach ($ads as $ad): ?>
                    <?php partial('ad_card', ['ad' => $ad]) ?>
                <?php endforeach ?>
            </div>
        <?php else: ?>
            <div class="empty" data-reveal>
                <h3>No advertisements yet</h3>
                <p>Selling a heater, textbooks or a bicycle before you leave? Newcomers are looking for exactly that.</p>
                <a class="btn btn-primary" href="<?= url('market/new') ?>">Post an ad</a>
            </div>
        <?php endif ?>
    </div>
</section>

<?php if (!current_user()): ?>
<section class="section">
    <div class="wrap">
        <div class="join" data-reveal>
            <div>
                <h2>Already studying in Russia?</h2>
                <p>Your first month is someone else's biggest worry. Share how you handled it, or sell what the next student needs.</p>
            </div>
            <a class="btn btn-primary btn-lg" href="<?= url('register') ?>">Create account</a>
        </div>
    </div>
</section>
<?php endif ?>
