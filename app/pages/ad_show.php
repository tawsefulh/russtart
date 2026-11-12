<?php
$ad = find_post('ads', $params[0]);
if (!$ad) {
    not_found();
}

$more = q(post_select('ads') . ' WHERE p.city_id = ? AND p.id <> ? ORDER BY p.created_at DESC LIMIT 3',
    [$ad['city_id'], $ad['id']])->fetchAll();

render('ad_show', [
    'title'       => $ad['title'] . ', ' . $ad['city'],
    'description' => excerpt($ad['description'], 150),
    'ad'          => $ad,
    'more'        => $more,
    'isOwner'     => current_user() && (int) current_user()['id'] === (int) $ad['user_id'],
]);
