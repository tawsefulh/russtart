<?php
/**
 * Default settings (local XAMPP).
 * To override anything (production database, Google keys), copy
 * config.local.example.php to config.local.php and edit that file.
 * config.local.php is not committed to git.
 */
$config = [
    'app_name' => 'RusStart',

    // The city the project is centred on (slug from the cities table).
    // It is listed first everywhere and highlighted in the hero.
    'main_city' => 'novosibirsk',

    'db' => [
        'host' => '127.0.0.1',
        'port' => 3307,          // XAMPP MySQL was moved to 3307 on this PC
        'name' => 'russtart',
        'user' => 'root',
        'pass' => '',
    ],

    // Google sign-in. Leave empty to hide the Google button.
    // Create keys at https://console.cloud.google.com/apis/credentials
    'google' => [
        'client_id'     => '',
        'client_secret' => '',
    ],

    // Show detailed PHP errors (turn off in production)
    'debug' => true,

    // Suggestions shown in the university field. People can type any other.
    'universities' => [
        'Lomonosov Moscow State University (MSU)',
        'HSE University',
        'RUDN University',
        'Bauman Moscow State Technical University',
        'Moscow Institute of Physics and Technology (MIPT)',
        'Sechenov University',
        'Pirogov Russian National Research Medical University',
        'MGIMO University',
        'Saint Petersburg State University (SPbU)',
        'ITMO University',
        'Peter the Great St. Petersburg Polytechnic University',
        'Kazan Federal University (KFU)',
        'Kazan State Medical University',
        'Novosibirsk State University (NSU)',
        'Tomsk State University (TSU)',
        'Tomsk Polytechnic University (TPU)',
        'Ural Federal University (UrFU)',
        'Lobachevsky University (UNN)',
        'Samara University',
        'Southern Federal University',
        'Kursk State Medical University',
        'Far Eastern Federal University (FEFU)',
        'Immanuel Kant Baltic Federal University',
        'Belgorod State University',
        'Voronezh State University',
    ],
];

$local = __DIR__ . '/config.local.php';
if (is_file($local)) {
    $config = array_replace_recursive($config, require $local);
}

return $config;
