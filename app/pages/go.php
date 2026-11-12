<?php
// Hero search: a city name takes you to that city, anything else searches articles.
$text = query('q');
if ($text === '') {
    redirect('articles');
}

$city = q('SELECT slug FROM cities WHERE name = ? OR slug = ?', [$text, slugify($text)])->fetch();
if (!$city) {
    $city = q('SELECT slug FROM cities WHERE name LIKE ? ORDER BY is_default DESC, name LIMIT 1',
        [addcslashes($text, '%_\\') . '%'])->fetch();
}

if ($city) {
    redirect('city/' . $city['slug']);
}
redirect('articles?q=' . urlencode($text));
