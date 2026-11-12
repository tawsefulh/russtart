<?php if ($pages > 1): ?>
    <nav class="pager" aria-label="Pages">
        <?php if ($page > 1): ?>
            <a class="btn btn-ghost" href="<?= e(query_with(['page' => $page - 1])) ?>">Newer</a>
        <?php endif ?>
        <span>Page <?= $page ?> of <?= $pages ?></span>
        <?php if ($page < $pages): ?>
            <a class="btn btn-ghost" href="<?= e(query_with(['page' => $page + 1])) ?>">Older</a>
        <?php endif ?>
    </nav>
<?php endif ?>
