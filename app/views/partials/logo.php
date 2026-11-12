<?php /** Logo: the "r" is a route from a station ring to an orange arrival point. */ ?>
<a class="logo<?= !empty($light) ? ' logo-light' : '' ?>" href="<?= url() ?>" aria-label="RusStart home">
    <svg class="logo-mark" viewBox="0 0 48 48" aria-hidden="true">
        <rect class="logo-tile" width="48" height="48" rx="13"/>
        <path class="logo-route" d="M17 33V24a10 10 0 0 1 10-10h4" fill="none" stroke-width="4.6" stroke-linecap="round"/>
        <circle class="logo-ring" cx="17" cy="34" r="4.4" stroke-width="3.2"/>
        <circle class="logo-dot" cx="33" cy="14" r="4.8"/>
    </svg>
    <span class="logo-word">rus<span>start</span></span>
</a>
