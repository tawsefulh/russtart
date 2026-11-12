<?php
$me = current_user();
$here = ROUTE_PATH;
$nav = fn(string $prefix) => str_starts_with($here, $prefix) ? ' aria-current="page"' : '';
$footerTopics = array_slice(all_categories('article'), 0, 3);
$jsText = [
    'filter'     => t('Type to filter'),
    'nothing'    => t('Nothing matches. Choose "Other" to add it.'),
    'show'       => t('Show'),
    'hide'       => t('Hide'),
    'showPass'   => t('Show password'),
    'hidePass'   => t('Hide password'),
    'notChosen'  => t('not chosen'),
];
?>
<!doctype html>
<html lang="<?= LANG ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'RusStart') ?> | RusStart</title>
    <meta name="description" content="<?= e($description ?? t('Guides written by international students in Russia, and a marketplace to buy what you need from people already there.')) ?>">
    <link rel="alternate" hreflang="en" href="<?= e(ORIGIN . lang_url('en')) ?>">
    <link rel="alternate" hreflang="ru" href="<?= e(ORIGIN . lang_url('ru')) ?>">
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/mark.svg') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@400;500;600;700&family=Unbounded:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <script>document.documentElement.classList.add('js'); window.I18N = <?= json_encode($jsText, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
</head>
<body class="<?= e($bodyClass ?? '') ?>">
<a class="skip" href="#main"><?= et('Skip to content') ?></a>

<header class="site-header" data-header>
    <div class="wrap header-row">
        <?php partial('logo') ?>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
            <span class="sr"><?= et('Menu') ?></span><i></i><i></i>
        </button>

        <nav class="site-nav" id="site-nav" data-nav>
            <ul class="nav-links">
                <li><a href="<?= url('articles') ?>"<?= $nav('/articles') ?>><?= et('Articles') ?></a></li>
                <li><a href="<?= url('market') ?>"<?= $nav('/market') ?>><?= et('Marketplace') ?></a></li>
            </ul>
            <div class="nav-actions">
                <div class="menu lang" data-menu>
                    <button class="lang-btn" type="button" aria-expanded="false" aria-haspopup="true" data-menu-btn>
                        <span class="sr"><?= et('Language') ?>: </span><?= strtoupper(LANG) ?>
                    </button>
                    <div class="menu-panel" data-menu-panel>
                        <?php foreach (LANGS as $code => $label): ?>
                            <a href="<?= base_url('language/' . $code) ?>" rel="nofollow" lang="<?= $code ?>" hreflang="<?= $code ?>"<?= $code === LANG ? ' aria-current="true"' : '' ?>><?= e($label) ?></a>
                        <?php endforeach ?>
                    </div>
                </div>
                <?php if ($me): ?>
                    <a class="btn btn-ghost btn-sm" href="<?= url('market/new') ?>"><?= et('Post an ad') ?></a>
                    <a class="btn btn-primary btn-sm" href="<?= url('articles/new') ?>"><?= et('Write an article') ?></a>
                    <div class="menu account" data-menu>
                        <button class="avatar" type="button" aria-expanded="false" aria-haspopup="true" data-menu-btn>
                            <span class="sr"><?= et('Account menu') ?> </span><?= e(initials($me['name'])) ?>
                        </button>
                        <div class="menu-panel" data-menu-panel>
                            <p class="menu-who"><strong><?= e($me['name']) ?></strong><span>@<?= e($me['username']) ?></span></p>
                            <a href="<?= url('me') ?>"><?= et('My posts') ?></a>
                            <?php if ($me['city_slug']): ?>
                                <a href="<?= url('city/' . $me['city_slug']) ?>"><?= e($me['city_name']) ?></a>
                            <?php endif ?>
                            <form method="post" action="<?= url('logout') ?>">
                                <?= csrf_field() ?>
                                <button type="submit"><?= et('Log out') ?></button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="nav-login" href="<?= url('login') ?>"><?= et('Log in') ?></a>
                    <a class="btn btn-primary btn-sm" href="<?= url('register') ?>"><?= et('Create account') ?></a>
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
                <button type="button" aria-label="<?= et('Dismiss') ?>" data-toast-close>&times;</button>
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
            <p><?= et('Written by international students in Russia for the ones arriving next.') ?></p>
        </div>
        <nav aria-label="<?= et('Read') ?>">
            <h2><?= et('Read') ?></h2>
            <a href="<?= url('articles') ?>"><?= et('All articles') ?></a>
            <?php foreach ($footerTopics as $topic): ?>
                <a href="<?= url('articles?category=' . $topic['slug']) ?>"><?= e($topic['name']) ?></a>
            <?php endforeach ?>
        </nav>
        <nav aria-label="<?= et('Marketplace') ?>">
            <h2><?= et('Marketplace') ?></h2>
            <a href="<?= url('market') ?>"><?= et('All advertisements') ?></a>
            <a href="<?= url('market/new') ?>"><?= et('Post an ad') ?></a>
        </nav>
        <nav aria-label="<?= et('Cities') ?>">
            <h2><?= et('Cities') ?></h2>
            <?php foreach (array_slice(all_cities(), 0, 4) as $c): ?>
                <a href="<?= url('city/' . $c['slug']) ?>"><?= e($c['name']) ?></a>
            <?php endforeach ?>
        </nav>
    </div>
    <div class="wrap footer-base">
        <p>&copy; <?= date('Y') ?> RusStart. <?= et('Advertisements are posted by members; meet in public places and check items before paying.') ?></p>
        <p class="footer-credit">Build By Hasan Md Tawseful</p>
    </div>
</footer>

<script src="<?= asset('js/app.js') ?>" defer></script>
</body>
</html>
