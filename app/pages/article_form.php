<?php
$user = require_login();

$article = null;
if ($params) {
    $article = find_post('articles', $params[0]);
    if (!$article || (int) $article['user_id'] !== (int) $user['id']) {
        not_found();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = post('title');
    $body  = trim(str_replace("\r\n", "\n", $_POST['body'] ?? ''));

    if (mb_strlen($title) < 8 || mb_strlen($title) > 160) {
        $errors['title'] = 'Write a title between 8 and 160 characters.';
    }
    if (mb_strlen($body) < 200) {
        $errors['body'] = 'Write at least 200 characters so the article is useful to a newcomer.';
    }
    $cityId     = resolve_city();
    $categoryId = resolve_category('article');
    $cover      = $errors ? null : save_image('cover');

    if (!$errors) {
        if ($article) {
            if ($cover) {
                delete_upload($article['cover']);
            }
            q('UPDATE articles SET title = ?, body = ?, excerpt = ?, city_id = ?, category_id = ?, cover = ?, updated_at = NOW() WHERE id = ?',
                [$title, $body, excerpt($body), $cityId, $categoryId, $cover ?: $article['cover'], $article['id']]);
            flash('success', 'Changes saved.');
            redirect('articles/' . $article['slug']);
        }
        $slug = unique_slug('articles', $title);
        q('INSERT INTO articles (user_id, city_id, category_id, title, slug, excerpt, body, cover) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [$user['id'], $cityId, $categoryId, $title, $slug, excerpt($body), $body, $cover]);
        flash('success', 'Article published.');
        redirect('articles/' . $slug);
    }
}

render('article_form', [
    'title'      => $article ? 'Edit article' : 'Write an article',
    'article'    => $article,
    'user'       => $user,
    'cities'     => all_cities(),
    'categories' => all_categories('article'),
]);
