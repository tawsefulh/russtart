<section class="page-head">
    <div class="wrap page-head-row">
        <div>
            <h1>My posts</h1>
            <p class="page-lead"><?= e($user['name']) ?>, <?= e($user['university']) ?>, <?= e($user['city_name']) ?></p>
        </div>
        <p class="page-jump">
            <a class="btn btn-ghost" href="<?= url('market/new') ?>">Post an ad</a>
            <a class="btn btn-primary" href="<?= url('articles/new') ?>">Write an article</a>
        </p>
    </div>
</section>

<section class="section section-flush">
    <div class="wrap mine">
        <div>
            <h2>Articles</h2>
            <?php if ($articles): ?>
                <ul class="mine-list">
                    <?php foreach ($articles as $a): ?>
                        <li>
                            <a class="mine-title" href="<?= url('articles/' . $a['slug']) ?>"><?= e($a['title']) ?></a>
                            <span class="mine-meta"><?= e($a['city']) ?>, <?= e(short_date($a['created_at'])) ?>, <?= (int) $a['views'] ?> views</span>
                            <a class="mine-edit" href="<?= url('articles/' . $a['slug'] . '/edit') ?>">Edit</a>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php else: ?>
                <p class="mine-empty">You have not written anything yet. <a href="<?= url('articles/new') ?>">Write an article</a></p>
            <?php endif ?>
        </div>
        <div>
            <h2>Advertisements</h2>
            <?php if ($ads): ?>
                <ul class="mine-list">
                    <?php foreach ($ads as $ad): ?>
                        <li>
                            <a class="mine-title" href="<?= url('market/' . $ad['slug']) ?>"><?= e($ad['title']) ?></a>
                            <span class="mine-meta"><?= e($ad['city']) ?>, <?= e(price_label($ad['price'])) ?>, <?= e(short_date($ad['created_at'])) ?></span>
                            <a class="mine-edit" href="<?= url('market/' . $ad['slug'] . '/edit') ?>">Edit</a>
                        </li>
                    <?php endforeach ?>
                </ul>
            <?php else: ?>
                <p class="mine-empty">You have no advertisements. <a href="<?= url('market/new') ?>">Post an ad</a></p>
            <?php endif ?>
        </div>
    </div>
</section>
