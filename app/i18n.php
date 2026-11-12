<?php
/**
 * Languages. The URL decides the language: /ru/... is Russian, everything else English.
 * English text in the code is the key; lang/ru.php holds the
 * Russian for each key. Anything missing from lang/ru.php shows in English.
 */
const LANGS = ['en' => 'English', 'ru' => 'Русский'];

/** Language the visitor most likely wants (used to send first-time visitors to /ru). */
function preferred_lang(): string
{
    // 1. The visitor chose a language with the switcher
    $chosen = $_COOKIE['lang'] ?? '';
    if (is_string($chosen) && isset(LANGS[$chosen])) {
        return $chosen;
    }
    // 2. Visitor is in Russia (country header, present when the site is behind Cloudflare)
    if (strtoupper($_SERVER['HTTP_CF_IPCOUNTRY'] ?? '') === 'RU') {
        return 'ru';
    }
    // 3. The browser's main language is Russian
    $browser = strtolower(ltrim($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? ''));
    return str_starts_with($browser, 'ru') ? 'ru' : 'en';
}

define('LANG', URL_LANG);

$GLOBALS['strings'] = LANG === 'en' ? [] : require ROOT . '/lang/' . LANG . '.php';

/** Translate. Extra arguments fill %s / %d placeholders. */
function t(string $text, ...$args): string
{
    $text = $GLOBALS['strings'][$text] ?? $text;
    return $args ? vsprintf($text, $args) : $text;
}

/** Translate and escape for HTML. */
function et(string $text, ...$args): string
{
    return htmlspecialchars(t($text, ...$args), ENT_QUOTES, 'UTF-8');
}

/** Number + correctly pluralised word: "1 article", "3 articles", "5 статей". */
function tn(int $n, string $word): string
{
    static $english = [
        'article'       => ['article', 'articles'],
        'advertisement' => ['advertisement', 'advertisements'],
        'view'          => ['view', 'views'],
        'day'           => ['day', 'days'],
    ];
    if (LANG === 'ru' && isset($GLOBALS['strings']['_plural'][$word])) {
        $f = $GLOBALS['strings']['_plural'][$word];
        $m10 = $n % 10;
        $m100 = $n % 100;
        $form = ($m10 === 1 && $m100 !== 11) ? $f[0]
            : (($m10 >= 2 && $m10 <= 4 && ($m100 < 12 || $m100 > 14)) ? $f[1] : $f[2]);
        return $n . ' ' . $form;
    }
    $f = $english[$word] ?? [$word, $word . 's'];
    return $n . ' ' . ($n === 1 ? $f[0] : $f[1]);
}

/** SQL for a city/category name in the current language (falls back to the English name). */
function name_sql(string $alias): string
{
    return LANG === 'ru' ? "COALESCE(NULLIF($alias.name_ru, ''), $alias.name)" : "$alias.name";
}

function month_name(int $month, bool $short): string
{
    static $ru = [
        ['янв', 'фев', 'мар', 'апр', 'мая', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'],
        ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
    ];
    if (LANG === 'ru') {
        return $ru[$short ? 0 : 1][$month - 1];
    }
    return date($short ? 'M' : 'F', mktime(0, 0, 0, $month, 1));
}

function long_date(string $datetime): string
{
    $t = strtotime($datetime);
    return date('j', $t) . ' ' . month_name((int) date('n', $t), false) . ' ' . date('Y', $t);
}
