<?php
$me = current_user();
$here = '/' . trim(substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), strlen(BASE_URL)), '/');
$nav = fn(string $prefix) => str_starts_with($here, $prefix) ? ' aria-current="page"' : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'RusStart') ?> | RusStart</title>
    <meta name="description" content="<?= e($description ?? 'Guides written by international students in Russia, and a marketplace to buy what you need from people already there.') ?>">
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/mark.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&family=Unbounded:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <script>document.documentElement.classList.add('js');</script>
</head>
<body class="<?= e($bodyClass ?? '') ?>">
<a class="skip" href="#main">Skip to content</a>

<header class="site-header" data-header>
    <div class="wrap header-row">
        <?php partial('logo') ?>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
            <span class="sr">Menu</span><i></i><i></i>
        </button>

        <nav class="site-nav" id="site-nav" data-nav>
            <ul class="nav-links">
                <li><a href="<?= url('articles') ?>"<?= $nav('/articles') ?>>Articles</a></li>
                <li><a href="<?= url('market') ?>"<?= $nav('/market') ?>>Marketplace</a></li>
            </ul>
            <div class="nav-actions">
                <?php if ($me): ?>
                    <a class="btn btn-ghost btn-sm" href="<?= url('market/new') ?>">Post an ad</a>
                    <a class="btn btn-primary btn-sm" href="<?= url('articles/new') ?>">Write an article</a>
                    <div class="menu" data-menu>
                        <button class="avatar" type="button" aria-expanded="false" aria-haspopup="true" data-menu-btn>
                            <span class="sr">Account menu for </span><?= e(initials($me['name'])) ?>
                        </button>
                        <div class="menu-panel" data-menu-panel>
                            <p class="menu-who"><strong><?= e($me['name']) ?></strong><span>@<?= e($me['username']) ?></span></p>
                            <a href="<?= url('me') ?>">My posts</a>
                            <?php if ($me['city_slug']): ?>
                                <a href="<?= url('city/' . $me['city_slug']) ?>"><?= e($me['city_name']) ?></a>
                            <?php endif ?>
                            <form method="post" action="<?= url('logout') ?>">
                                <?= csrf_field() ?>
                                <button type="submit">Log out</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="nav-login" href="<?= url('login') ?>">Log in</a>
                    <a class="btn btn-primary btn-sm" href="<?= url('register') ?>">Create account</a>
                <?php endif ?>
            </div>
        </nav>
    </div>
</header>

<?php if ($flashes = flashes()): ?>
    <div class="toasts" role="status" aria-live="polite">
        <?php foreach ($flashes as $f): ?>
            <div class="toast toast-<?= e($f['type']) ?>" data-toast>
                <span><?= e($f['message']) ?></span>
                <button type="button" aria-label="Dismiss" data-toast-close>&times;</button>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>

<main id="main">
<?= $content ?>
</main>

<footer class="site-footer">
    <div class="wrap footer-grid">
        <div class="footer-about">
            <?php partial('logo', ['light' => true]) ?>
            <p>Written by international students in Russia for the ones arriving next.</p>
        </div>
        <nav aria-label="Read">
            <h2>Read</h2>
            <a href="<?= url('articles') ?>">All articles</a>
            <a href="<?= url('articles?category=visa-documents') ?>">Visa &amp; documents</a>
            <a href="<?= url('articles?category=housing-dormitory') ?>">Housing &amp; dormitory</a>
            <a href="<?= url('articles?category=winter') ?>">Winter</a>
        </nav>
        <nav aria-label="Marketplace">
            <h2>Marketplace</h2>
            <a href="<?= url('market') ?>">All advertisements</a>
            <a href="<?= url('market/new') ?>">Post an ad</a>
        </nav>
        <nav aria-label="Cities">
            <h2>Cities</h2>
            <?php foreach (array_slice(all_cities(), 0, 4) as $c): ?>
                <a href="<?= url('city/' . $c['slug']) ?>"><?= e($c['name']) ?></a>
            <?php endforeach ?>
        </nav>
    </div>
    <div class="wrap footer-base">
        <p>&copy; <?= date('Y') ?> RusStart. Advertisements are posted by members; meet in public places and check items before paying.</p>
    </div>
</footer>

<script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
