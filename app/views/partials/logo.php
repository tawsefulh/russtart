<?php
/**
 * Logo: the same route as on the login page. It starts at a teal station,
 * passes a middle station and arrives at the orange point.
 * The white line draws itself on page load; on hover a teal-to-orange line travels along it.
 */
static $logoCount = 0;
$gid = 'logo-grad-' . (++$logoCount);
$route = 'M15 37V30a6 6 0 0 1 6-6h6a6 6 0 0 0 6-6V11';
?>
<a class="logo<?= !empty($light) ? ' logo-light' : '' ?>" href="<?= url() ?>" aria-label="RusStart">
    <svg class="logo-mark" viewBox="0 0 48 48" aria-hidden="true">
        <defs>
            <linearGradient id="<?= $gid ?>" gradientUnits="userSpaceOnUse" x1="15" y1="37" x2="33" y2="11">
                <stop offset="0" stop-color="#4AB8B8"/>
                <stop offset="1" stop-color="#EC5A24"/>
            </linearGradient>
        </defs>
        <rect class="logo-tile" width="48" height="48" rx="13"/>
        <path class="logo-route" d="<?= $route ?>" fill="none" stroke-width="3.6" stroke-linecap="round" pathLength="100"/>
        <path class="logo-travel" d="<?= $route ?>" fill="none" stroke="url(#<?= $gid ?>)" stroke-width="3.6" stroke-linecap="round" pathLength="100"/>
        <circle class="logo-ring logo-s1" cx="15" cy="37" r="3.5" stroke-width="2.6"/>
        <circle class="logo-ring logo-s2" cx="24" cy="24" r="3.3" stroke-width="2.4"/>
        <circle class="logo-dot" cx="33" cy="11" r="4.2"/>
    </svg>
    <span class="logo-word">rus<span>start</span></span>
</a>
