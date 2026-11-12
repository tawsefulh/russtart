<section class="section">
    <div class="wrap listing">
        <div class="listing-main">
            <p class="crumb"><a href="<?= url('market') ?>">Marketplace</a> / <a href="<?= url('market?city=' . $ad['city_slug']) ?>"><?= e($ad['city']) ?></a> / <a href="<?= url('market?category=' . $ad['category_slug']) ?>"><?= e($ad['category']) ?></a></p>
            <h1><?= e($ad['title']) ?></h1>
            <p class="listing-price"><?= e(price_label($ad['price'])) ?></p>

            <?php if ($ad['image']): ?>
                <div class="listing-image"><img src="<?= e(upload_url($ad['image'])) ?>" alt="<?= e($ad['title']) ?>"></div>
            <?php endif ?>

            <div class="prose prose-sm">
                <?= format_body($ad['description']) ?>
            </div>

            <?php if ($isOwner): ?>
                <div class="owner-bar">
                    <a class="btn btn-ghost btn-sm" href="<?= url('market/' . $ad['slug'] . '/edit') ?>">Edit advertisement</a>
                    <form method="post" action="<?= url('market/' . $ad['slug'] . '/delete') ?>" data-confirm="Delete this advertisement? This cannot be undone.">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm" type="submit">Delete advertisement</button>
                    </form>
                </div>
            <?php endif ?>
        </div>

        <aside class="contact" aria-label="Contact the seller">
            <h2>Contact the seller</h2>
            <p class="byline">
                <span class="avatar" aria-hidden="true"><?= e(initials($ad['author'])) ?></span>
                <span><strong><?= e($ad['author']) ?></strong><br><?= e($ad['university']) ?></span>
            </p>

            <div class="contact-actions">
                <?php if ($ad['phone']): ?>
                    <a class="btn btn-navy" href="tel:<?= e($ad['phone']) ?>">Call <?= e($ad['phone']) ?></a>
                <?php endif ?>
                <?php if ($ad['whatsapp']): ?>
                    <a class="btn btn-whatsapp" href="https://wa.me/<?= e(ltrim($ad['whatsapp'], '+')) ?>" target="_blank" rel="noopener">WhatsApp <?= e($ad['whatsapp']) ?></a>
                <?php endif ?>
                <?php if ($ad['telegram']): ?>
                    <a class="btn btn-telegram" href="<?= e(telegram_link($ad['telegram'])) ?>" target="_blank" rel="noopener">Telegram <?= e($ad['telegram']) ?></a>
                <?php endif ?>
            </div>

            <dl class="contact-facts">
                <dt>Address</dt>
                <dd><?= e($ad['address']) ?>, <?= e($ad['city']) ?></dd>
                <dt>Posted</dt>
                <dd><?= e(short_date($ad['created_at'])) ?></dd>
            </dl>
            <p class="contact-note">Meet in a public place and check the item before you pay.</p>
        </aside>
    </div>
</section>

<?php if ($more): ?>
<section class="section section-tint">
    <div class="wrap">
        <div class="section-head" data-reveal>
            <h2>Also for sale in <?= e($ad['city']) ?></h2>
            <a class="more" href="<?= url('market?city=' . $ad['city_slug']) ?>">All in <?= e($ad['city']) ?></a>
        </div>
        <div class="offers">
            <?php foreach ($more as $m): ?>
                <?php partial('ad_card', ['ad' => $m]) ?>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>
