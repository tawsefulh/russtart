<?php
$data = listing('articles', 10);

render('articles', $data + [
    'title'      => 'Articles from students in Russia',
    'categories' => all_categories('article'),
]);
