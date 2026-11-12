<?php
$article = find_post('articles', $params[0]);
if (!$article) {
    not_found();
}

// Count one view per visitor session
if (empty($_SESSION['seen'][$article['id']])) {
    $_SESSION['seen'][$article['id']] = 1;
    q('UPDATE articles SET views = views + 1 WHERE id = ?', [$article['id']]);
    $article['views']++;
}

$more = q(post_select('articles') . ' WHERE p.city_id = ? AND p.id <> ? ORDER BY p.created_at DESC LIMIT 3',
    [$article['city_id'], $article['id']])->fetchAll();

render('article_show', [
    'title'       => $article['title'],
    'description' => $article['excerpt'],
    'article'     => $article,
    'more'        => $more,
    'isOwner'     => current_user() && (int) current_user()['id'] === (int) $article['user_id'],
]);
