<?php
$user = require_login();

$ad = null;
if ($params) {
    $ad = find_post('ads', $params[0]);
    if (!$ad || (int) $ad['user_id'] !== (int) $user['id']) {
        not_found();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = post('title');
    $description = trim(str_replace("\r\n", "\n", $_POST['description'] ?? ''));
    $address     = post('address');
    $priceRaw    = str_replace([' ', ','], ['', '.'], post('price'));
    $price       = null;

    if (mb_strlen($title) < 5 || mb_strlen($title) > 140) {
        $errors['title'] = t('Write a title between 5 and 140 characters.');
    }
    if (mb_strlen($description) < 20) {
        $errors['description'] = t('Describe what you are offering in at least 20 characters.');
    }
    if ($priceRaw !== '') {
        if (!is_numeric($priceRaw) || $priceRaw < 0 || $priceRaw > 99999999) {
            $errors['price'] = t('Enter the price in roubles as a number, or leave it empty.');
        } else {
            $price = round((float) $priceRaw, 2);
        }
    }
    if (mb_strlen($address) < 8 || mb_strlen($address) > 255) {
        $errors['address'] = t('Add the address where buyers can meet you (street and building).');
    }

    // Contacts: at least one valid way to reach the seller
    $phone = $whatsapp = $telegram = null;
    if (post('phone') !== '' && !($phone = normalize_phone(post('phone')))) {
        $errors['phone'] = t('Enter the number with country code, for example +7 912 345 67 89.');
    }
    if (post('whatsapp') !== '' && !($whatsapp = normalize_phone(post('whatsapp')))) {
        $errors['whatsapp'] = t('Enter the WhatsApp number with country code, for example +7 912 345 67 89.');
    }
    if (post('telegram') !== '' && !($telegram = normalize_telegram(post('telegram')))) {
        $errors['telegram'] = t('Enter a Telegram username like @name, or a number with country code.');
    }
    if (post('phone') === '' && post('whatsapp') === '' && post('telegram') === '') {
        $errors['phone'] = t('Add a phone, WhatsApp or Telegram number so buyers can contact you.');
    }

    $cityId     = resolve_city();
    $categoryId = resolve_category('ad');
    $image      = $errors ? null : save_image('image');

    if (!$errors) {
        if ($ad) {
            if ($image) {
                delete_upload($ad['image']);
            }
            q('UPDATE ads SET title = ?, description = ?, price = ?, address = ?, phone = ?, whatsapp = ?, telegram = ?,
                              city_id = ?, category_id = ?, image = ?, updated_at = NOW() WHERE id = ?',
                [$title, $description, $price, $address, $phone, $whatsapp, $telegram, $cityId, $categoryId, $image ?: $ad['image'], $ad['id']]);
            flash('success', t('Changes saved.'));
            redirect('market/' . $ad['slug']);
        }
        $slug = unique_slug('ads', $title);
        q('INSERT INTO ads (user_id, city_id, category_id, title, slug, description, price, address, phone, whatsapp, telegram, image)
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [$user['id'], $cityId, $categoryId, $title, $slug, $description, $price, $address, $phone, $whatsapp, $telegram, $image]);
        flash('success', t('Advertisement posted.'));
        redirect('market/' . $slug);
    }
}

render('ad_form', [
    'title'      => $ad ? t('Edit advertisement') : t('Post an advertisement'),
    'ad'         => $ad,
    'user'       => $user,
    'cities'     => all_cities(),
    'categories' => all_categories('ad'),
]);
