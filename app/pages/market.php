<?php
$data = listing('ads', 12);

render('market', $data + [
    'title'      => 'Marketplace for students in Russia',
    'categories' => all_categories('ad'),
]);
