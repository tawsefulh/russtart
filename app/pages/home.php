<?php
$articles = find_posts('articles', [], 5);
$ads = find_posts('ads', [], 6);

$topics = q("SELECT k.name, k.slug, COUNT(a.id) AS total
             FROM categories k LEFT JOIN articles a ON a.category_id = k.id
             WHERE k.type = 'article'
             GROUP BY k.id ORDER BY k.is_default DESC, total DESC, k.id LIMIT 13")->fetchAll();

render('home', [
    'title'    => 'Student guides and marketplace for life in Russia',
    'articles' => $articles,
    'ads'      => $ads,
    'topics'   => $topics,
    'stations' => array_slice(all_cities(), 0, 7),
    'bodyClass' => 'is-home',
]);
