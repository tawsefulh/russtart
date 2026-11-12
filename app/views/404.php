<section class="section">
    <div class="wrap">
        <div class="empty empty-page">
            <h1><?= et('This page does not exist') ?></h1>
            <p><?= et('The link may be old, or the post was deleted by its author.') ?></p>
            <p class="page-jump">
                <a class="btn btn-primary" href="<?= url() ?>"><?= et('Go to the home page') ?></a>
                <a class="btn btn-ghost" href="<?= url('articles') ?>"><?= et('Browse articles') ?></a>
            </p>
        </div>
    </div>
</section>
