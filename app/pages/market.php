<?php
$data = listing('ads', 12);

render('market', $data + [
    'title'      => t('Marketplace for students in Russia'),
    'categories' => all_categories('ad'),
]);
