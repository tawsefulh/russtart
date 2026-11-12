<?php
// Hero search: a city name takes you to that city, anything else searches articles.
$text = query('q');
if ($text === '') {
    redirect('articles');
}

$city = q('SELECT slug FROM cities WHERE name = ? OR name_ru = ? OR slug = ?', [$text, $text, slugify($text)])->fetch();
if (!$city) {
    $like = addcslashes($text, '%_\\') . '%';
    $city = q('SELECT slug FROM cities WHERE name LIKE ? OR name_ru LIKE ? ORDER BY is_default DESC, name LIMIT 1',
        [$like, $like])->fetch();
}

if ($city) {
    redirect('city/' . $city['slug']);
}
redirect('articles?q=' . urlencode($text));
