<?php
$city = q('SELECT c.id, c.slug, ' . name_sql('c') . ' AS name FROM cities c WHERE c.slug = ?', [$params[0]])->fetch();
if (!$city) {
    not_found();
}

$filter = ['city' => $city['slug']];

render('city', [
    'title'        => t('%s: student guides and marketplace', $city['name']),
    'city'         => $city,
    'articles'     => find_posts('articles', $filter, 6),
    'articleCount' => count_posts('articles', $filter),
    'ads'          => find_posts('ads', $filter, 6),
    'adCount'      => count_posts('ads', $filter),
]);
