<article class="offer" data-reveal>
    <a class="offer-link" href="<?= url('market/' . $ad['slug']) ?>">
        <div class="offer-image">
            <?php if ($ad['image']): ?>
                <img src="<?= e(upload_url($ad['image'])) ?>" alt="" loading="lazy">
            <?php else: ?>
                <span aria-hidden="true"><?= e(mb_strtoupper(mb_substr($ad['category'], 0, 1))) ?></span>
            <?php endif ?>
        </div>
        <div class="offer-text">
            <p class="offer-price"><?= e(price_label($ad['price'])) ?></p>
            <h3><?= e($ad['title']) ?></h3>
            <p class="offer-meta"><?= e($ad['city']) ?>, <?= e($ad['category']) ?></p>
        </div>
    </a>
</article>
