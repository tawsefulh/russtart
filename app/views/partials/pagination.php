<?php if ($pages > 1): ?>
    <nav class="pager" aria-label="<?= et('Pages') ?>">
        <?php if ($page > 1): ?>
            <a class="btn btn-ghost" href="<?= e(query_with(['page' => $page - 1])) ?>"><?= et('Newer') ?></a>
        <?php endif ?>
        <span><?= et('Page %d of %d', $page, $pages) ?></span>
        <?php if ($page < $pages): ?>
            <a class="btn btn-ghost" href="<?= e(query_with(['page' => $page + 1])) ?>"><?= et('Older') ?></a>
        <?php endif ?>
    </nav>
<?php endif ?>
