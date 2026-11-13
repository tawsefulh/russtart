<?php
/**
 * One topic shown as a small "page": a folded-corner sheet with a soft
 * winter scene on top (a different sky for each card) and the topic's icon.
 * Needs: $t (name, slug, total), $n (position in the list).
 */

// sky top, sky bottom, sun, hills, trees
$skies = [
    ['#143C56', '#63A9CA', '#FFF1DC', '#7FB4CF', '#1E5374'],   // blue dusk
    ['#1C6570', '#93D8D2', '#FFFFFF', '#BFE9E4', '#17525B'],   // teal morning
    ['#2A5F85', '#F4A77F', '#FFE2C4', '#E9B89B', '#1F4F70'],   // orange sunset
    ['#3B86AE', '#CFE8F2', '#FFFFFF', '#E3F2F8', '#2A6A90'],   // bright day
    ['#0F2C42', '#2F7297', '#DDEFF7', '#3E86AB', '#0C2638'],   // night
];
[$top, $bottom, $sun, $hill, $tree] = $skies[$n % count($skies)];

// simple line icons, 24 x 24
$icons = [
    'visa-documents'       => 'M6 3h12v18H6zM12 8.2a2.3 2.3 0 1 0 .01 0M9 16.5h6',
    'arrival-registration' => 'M3 12.5l18-8-5.5 15.5-3.8-6.3zM11.7 13.7L21 4.5',
    'housing-dormitory'    => 'M4 11.5l8-7.5 8 7.5V20H4zM10 20v-5.5h4V20',
    'university-life'      => 'M2 9l10-5 10 5-10 5zM6 11.2V16c3 2.6 9 2.6 12 0v-4.8',
    'money-banking'        => 'M12 3a9 9 0 1 0 .01 0M10 17V7.5h3a2.6 2.6 0 0 1 0 5.2H8.5M8.5 15h5',
    'sim-internet'         => 'M5 20v-3M10 20v-7M15 20V9M20 20V4',
    'transport'            => 'M6.5 4h11A2.5 2.5 0 0 1 20 6.5V16H4V6.5A2.5 2.5 0 0 1 6.5 4zM4 11h16M8.5 16l-1.5 4M15.5 16l1.5 4',
    'food-groceries'       => 'M3.5 10.5h17l-2 9.5h-13zM9 10.5l3-6.5 3 6.5',
    'health-insurance'     => 'M9.5 4h5v5.5H20v5h-5.5V20h-5v-5.5H4v-5h5.5z',
    'russian-language'     => 'M4 5h16v11H10.5L6 19.5V16H4zM8 9h8M8 12.5h5',
    'part-time-work'       => 'M3 8h18v11.5H3zM9 8V5h6v3M3 13h18',
    'winter'               => 'M12 3v18M4.2 7.5l15.6 9M19.8 7.5l-15.6 9M12 3l-2 2M12 3l2 2M12 21l-2-2M12 21l2-2',
    'culture-daily-life'   => 'M12 3c3.2 2.6 4.4 4.8 4.4 7H7.6c0-2.2 1.2-4.4 4.4-7zM7.5 10h9v10h-9zM10.5 20v-4h3v4',
];
$icon = $icons[$t['slug']] ?? 'M7 4h10v16H7zM10 9h4M10 13h4';

// position of the sun and shape of the hills change from card to card
$sx = [150, 44, 132, 60, 160][$n % 5];
$sy = [46, 40, 58, 34, 30][$n % 5];
$lift = [0, 8, -4, 6, -2][$n % 5];
$gid = 'tc' . $n;
?>
<li>
    <a class="page-card" href="<?= url('articles?category=' . $t['slug']) ?>">
        <span class="page-art" aria-hidden="true">
            <svg class="page-scene" viewBox="0 0 200 120" preserveAspectRatio="xMidYMid slice" focusable="false">
                <defs>
                    <linearGradient id="<?= $gid ?>" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stop-color="<?= $top ?>"/><stop offset="1" stop-color="<?= $bottom ?>"/>
                    </linearGradient>
                </defs>
                <rect width="200" height="120" fill="url(#<?= $gid ?>)"/>
                <circle cx="<?= $sx ?>" cy="<?= $sy ?>" r="30" fill="<?= $sun ?>" opacity=".22"/>
                <circle cx="<?= $sx ?>" cy="<?= $sy ?>" r="13" fill="<?= $sun ?>" opacity=".75"/>
                <path fill="<?= $hill ?>" opacity=".7" d="M-10 <?= 86 + $lift ?>C30 <?= 66 + $lift ?> 70 <?= 80 - $lift ?> 110 <?= 72 + $lift ?>s70 <?= -8 - $lift ?> 100 6V130H-10Z"/>
                <g fill="<?= $tree ?>">
                    <?php foreach ([[18, 30], [36, 22], [168, 26], [184, 34], [150, 18]] as $k => [$x, $h]): ?>
                        <?php $x += ($n * 7 + $k * 3) % 9 - 4; ?>
                        <polygon points="<?= $x ?>,<?= 100 - $h ?> <?= $x - $h * 0.3 ?>,104 <?= $x + $h * 0.3 ?>,104"/>
                    <?php endforeach ?>
                </g>
                <path fill="#FFFFFF" opacity=".92" d="M-10 104C40 96 90 106 130 100s60-4 80 0V130H-10Z"/>
            </svg>
            <svg class="page-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                <path d="<?= $icon ?>"/>
            </svg>
        </span>
        <span class="page-text">
            <span class="page-title"><?= e($t['name']) ?></span>
            <small><?= e(tn((int) $t['total'], 'article')) ?></small>
        </span>
    </a>
</li>
