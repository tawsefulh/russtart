<?php
/**
 * Hero background: a soft-focus Russian winter landscape drawn in SVG
 * (dusk sky, low sun, hills, onion-domed church, fir forest, snow fields).
 * To use a real photo instead, save it as assets/img/hero.jpg.
 */
$photo = is_file(ROOT . '/assets/img/hero.jpg');

// repeatable "random" numbers so the forest looks the same on every load
$rand = function (int $n): float {
    $x = sin($n * 127.1 + 311.7) * 43758.5453;
    return $x - floor($x);
};

// one fir tree: three stacked triangles
$fir = function (float $x, float $base, float $h): string {
    $w = $h * 0.34;
    $out = '';
    foreach ([[1.0, 0.0], [0.78, 0.26], [0.56, 0.5]] as [$scale, $lift]) {
        $top = $base - $h * ($lift + 0.5 * $scale + 0.18);
        $bottom = $base - $h * $lift;
        $out .= sprintf('<polygon points="%.1f,%.1f %.1f,%.1f %.1f,%.1f"/>', $x, $top, $x - $w * $scale, $bottom, $x + $w * $scale, $bottom);
    }
    return $out;
};

// one church tower with an onion dome
$dome = function (float $cx, float $base, float $w, float $towerH): string {
    $y = $base - $towerH;
    return sprintf('<rect x="%.1f" y="%.1f" width="%.1f" height="%.1f"/>', $cx - $w * 0.3, $y, $w * 0.6, $towerH)
        . sprintf('<path d="M%.1f %.1f C%.1f %.1f %.1f %.1f %.1f %.1f C%.1f %.1f %.1f %.1f %.1f %.1fZ"/>',
            $cx - $w * 0.36, $y,
            $cx - $w * 0.95, $y - $w * 0.55, $cx - $w * 0.22, $y - $w * 0.95, $cx, $y - $w * 1.55,
            $cx + $w * 0.22, $y - $w * 0.95, $cx + $w * 0.95, $y - $w * 0.55, $cx + $w * 0.36, $y);
};
?>
<div class="hero-bg">
<?php if ($photo): ?>
    <div class="hero-scene hero-photo" style="background-image: url('<?= asset('img/hero.jpg') ?>')" aria-hidden="true"></div>
<?php else: ?>
    <svg class="hero-scene" viewBox="0 0 1440 800" preserveAspectRatio="xMaxYMax slice" aria-hidden="true" focusable="false">
        <defs>
            <linearGradient id="hs-sky" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#143C56"/>
                <stop offset=".5" stop-color="#2A6A90"/>
                <stop offset=".78" stop-color="#63A9CA"/>
                <stop offset="1" stop-color="#A9D3E5"/>
            </linearGradient>
            <radialGradient id="hs-sun" cx=".5" cy=".5" r=".5">
                <stop offset="0" stop-color="#FFF4E6" stop-opacity=".95"/>
                <stop offset=".25" stop-color="#FFE3C7" stop-opacity=".5"/>
                <stop offset="1" stop-color="#FFE3C7" stop-opacity="0"/>
            </radialGradient>
            <linearGradient id="hs-snow" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0" stop-color="#F4FAFD"/>
                <stop offset="1" stop-color="#C5DEEA"/>
            </linearGradient>
            <filter id="hs-far" x="-5%" y="-20%" width="110%" height="140%"><feGaussianBlur stdDeviation="12"/></filter>
            <filter id="hs-mid" x="-5%" y="-20%" width="110%" height="140%"><feGaussianBlur stdDeviation="5"/></filter>
            <filter id="hs-near" x="-5%" y="-20%" width="110%" height="140%"><feGaussianBlur stdDeviation="2.4"/></filter>
        </defs>

        <rect width="1440" height="800" fill="url(#hs-sky)"/>
        <circle cx="1090" cy="430" r="330" fill="url(#hs-sun)"/>

        <!-- distant hills -->
        <path filter="url(#hs-far)" fill="#7FB4CF" opacity=".75"
              d="M-40 560C140 470 330 520 520 500S860 420 1060 470s300-50 420-20V800H-40Z"/>

        <!-- church with onion domes on the horizon -->
        <g filter="url(#hs-mid)" fill="#2C6C90">
            <rect x="952" y="520" width="180" height="90"/>
            <?= $dome(1042, 520, 62, 86) ?>
            <?= $dome(978, 520, 40, 44) ?>
            <?= $dome(1106, 520, 40, 44) ?>
            <?= $dome(1010, 520, 30, 70) ?>
            <?= $dome(1074, 520, 30, 70) ?>
        </g>

        <!-- far forest -->
        <g filter="url(#hs-mid)" fill="#3D82A6">
            <?php for ($i = 0; $i < 46; $i++): ?>
                <?= $fir(-20 + $i * 33 + $rand($i) * 18, 612 + $rand($i + 90) * 10, 62 + $rand($i + 40) * 46) ?>
            <?php endfor ?>
        </g>

        <!-- far snow field -->
        <path filter="url(#hs-mid)" fill="#CFE5EF"
              d="M-40 618C180 588 420 606 660 600s520-26 860 4V800H-40Z"/>

        <!-- near forest, left and right of the open field -->
        <g filter="url(#hs-near)" fill="#1E5374">
            <?php for ($i = 0; $i < 13; $i++): ?>
                <?= $fir(-30 + $i * 44 + $rand($i + 7) * 22, 664 + $rand($i + 17) * 14, 120 + $rand($i + 27) * 90) ?>
            <?php endfor ?>
            <?php for ($i = 0; $i < 6; $i++): ?>
                <?= $fir(1228 + $i * 46 + $rand($i + 57) * 20, 660 + $rand($i + 67) * 14, 110 + $rand($i + 77) * 100) ?>
            <?php endfor ?>
        </g>

        <!-- near snow drifts -->
        <path filter="url(#hs-near)" fill="url(#hs-snow)"
              d="M-40 676C120 646 320 668 520 660s380-34 600-22 250 22 360 8V800H-40Z"/>
        <path filter="url(#hs-near)" fill="#FFFFFF" opacity=".85"
              d="M-40 742C200 708 470 738 760 726s460-22 720-4V800H-40Z"/>
    </svg>
<?php endif ?>

<canvas class="hero-snow" data-snow aria-hidden="true"></canvas>

    <div class="hero-flag" aria-hidden="true"><?php for ($i = 0; $i < 30; $i++): ?><i style="--i:<?= $i ?>"></i><?php endfor ?></div>
</div>
