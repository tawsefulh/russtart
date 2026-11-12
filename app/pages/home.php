<?php
$articles = find_posts('articles', [], 5);
$ads = find_posts('ads', [], 6);

$topics = q("SELECT " . name_sql('k') . " AS name, k.slug, COUNT(a.id) AS total
             FROM categories k LEFT JOIN articles a ON a.category_id = k.id
             WHERE k.type = 'article'
             GROUP BY k.id ORDER BY k.is_default DESC, total DESC, k.id LIMIT 13")->fetchAll();

render('home', [
    'title'    => t('Student guides and marketplace for life in Russia'),
    'articles' => $articles,
    'ads'      => $ads,
    'topics'   => $topics,
    'stations' => all_cities(),
    'bodyClass' => 'is-home',
]);
