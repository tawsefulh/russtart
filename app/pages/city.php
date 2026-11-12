<?php
$city = q('SELECT * FROM cities WHERE slug = ?', [$params[0]])->fetch();
if (!$city) {
    not_found();
}

$filter = ['city' => $city['slug']];

render('city', [
    'title'        => $city['name'] . ': student guides and marketplace',
    'city'         => $city,
    'articles'     => find_posts('articles', $filter, 6),
    'articleCount' => count_posts('articles', $filter),
    'ads'          => find_posts('ads', $filter, 6),
    'adCount'      => count_posts('ads', $filter),
]);
