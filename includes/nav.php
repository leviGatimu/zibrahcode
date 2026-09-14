<?php
/**
 * Shared nav — one $navLinks table drives three views:
 *   - desktop top bar (lg+): the primary pages inline, the rest grouped into
 *     two dropdowns so the bar stays readable at a glance;
 *   - mobile bottom tab bar (< lg): the four most-visited pages plus "More";
 *   - mobile "More" sheet: everything the tab bar doesn't have room for,
 *     plus account links and the Buy Now CTA.
 * Expects $activeNav (a $navLinks key, or '') to be set by the including page.
 */
$navLinks = [
    'home' => ['label' => 'Home', 'short' => 'Home', 'href' => '/index.php', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
    'about' => ['label' => 'About', 'short' => 'About', 'href' => '/about.php', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
    'book' => ['label' => 'The Book', 'short' => 'Book', 'href' => '/book.php', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
    'framework' => ['label' => 'Framework', 'short' => 'Framework', 'href' => '/framework.php', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
    'blog' => ['label' => 'Blog', 'short' => 'Blog', 'href' => '/blog.php', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
    'podcast' => ['label' => 'Podcast', 'short' => 'Podcast', 'href' => '/podcast.php', 'icon' => 'M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z'],
    'events' => ['label' => 'Events', 'short' => 'Events', 'href' => '/events.php', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3.75 18.75V7.5a2.25 2.25 0 012.25-2.25h12a2.25 2.25 0 012.25 2.25v11.25m-16.5 0A2.25 2.25 0 006 21h12a2.25 2.25 0 002.25-2.25m-16.5 0V9.75a2.25 2.25 0 012.25-2.25h12a2.25 2.25 0 012.25 2.25v9M6 12.75h.008v.008H6v-.008zm0 3h.008v.008H6v-.008zm2.25-3h.008v.008H8.25v-.008zm0 3h.008v.008H8.25v-.008zm2.25-3h.008v.008H10.5v-.008zm0 3h.008v.008H10.5v-.008zm2.25-3h.008v.008H12.75v-.008zm0 3h.008v.008H12.75v-.008zm2.25-3h.008v.008H15v-.008zm0 3h.008v.008H15v-.008zm2.25-3h.008v.008H17.25v-.008zm0 3h.008v.008H17.25v-.008z'],
    'inquire' => ['label' => 'Inquire', 'short' => 'Inquire', 'href' => '/inquire.php', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
    'contact' => ['label' => 'Contact', 'short' => 'Contact', 'href' => '/contact.php', 'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
];

// Desktop bar order. A 'group' entry becomes a dropdown; it reads as active
// when any page inside it is the current one.
$desktopNav = [
    ['link' => 'home'],
    ['link' => 'about'],
    ['link' => 'book'],
    ['link' => 'framework'],
    ['group' => 'Insights', 'links' => ['blog', 'podcast']],
    ['group' => 'Connect', 'links' => ['events', 'inquire', 'contact']],
];

$mobileBarLinks = ['home', 'book', 'blog', 'podcast'];
$mobileMoreLinks = ['about', 'framework', 'events', 'inquire', 'contact'];
$mobileMoreActive = in_array($activeNav, $mobileMoreLinks, true);

$navUser = currentUser();
$navTransparentAtTop = $navTransparentAtTop ?? false;
?>
<!-- NAVIGATION: always has a translucent blurred backdrop, so text stays legible over any page
     content (photos, dark heroes, etc.) without needing per-page light/dark text variants.
     Pages that set $navTransparentAtTop (e.g. post.php) opt into a mobile-only variant where
     the nav has no background at all until scrolled — see .nav-mobile-transparent-top in style.css. -->
<nav class="fixed top-0 w-full z-50 transition-all duration-700 px-6 md:px-16 flex justify-between items-center nav-translucent py-6 lg:py-8 <?php echo $navTransparentAtTop ? 'nav-mobile-transparent-top' : ''; ?>"
    :class="scrolled ? 'nav-scrolled py-4 shadow-sm' : ''" aria-label="Primary">
    <a href="/index.php" class="font-bold tracking-[0.4em] text-sm uppercase text-brand-black">ZIBRAH CODE<span
            class="text-[8px] align-top ml-1 opacity-50">™</span></a>

    <!-- Desktop links -->
    <div class="hidden lg:flex items-center space-x-10">
        <?php foreach ($desktopNav as $entry): ?>
            <?php if (isset($entry['link'])): $item = $navLinks[$entry['link']]; ?>
                <a href="<?php echo e($item['href']); ?>"
                   class="nav-link text-[10px] font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors <?php echo $activeNav === $entry['link'] ? 'active' : ''; ?>"
                   <?php echo $activeNav === $entry['link'] ? 'aria-current="page"' : ''; ?>>
                   <?php echo e($item['label']); ?>
                </a>
            <?php else: $groupActive = in_array($activeNav, $entry['links'], true); ?>
                <!-- Opens on hover for mouse users and on click/Enter for keyboard users.
                     The panel's top padding sits inside the hover area, so the pointer
                     can cross the gap between the label and the menu without closing it. -->
                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false"
                     @click.outside="open = false" @keydown.escape="open = false">
                    <button type="button" @click="open = !open" :aria-expanded="open" aria-haspopup="true"
                            class="nav-link text-[10px] font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors flex items-center gap-1 <?php echo $groupActive ? 'active' : ''; ?>">
                        <?php echo e($entry['group']); ?>
                        <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" x-transition x-cloak class="absolute left-1/2 -translate-x-1/2 pt-5 z-50">
                        <div class="w-48 bg-white shadow-2xl border border-brand-gray-200 py-2">
                            <?php foreach ($entry['links'] as $key): $item = $navLinks[$key]; ?>
                                <a href="<?php echo e($item['href']); ?>"
                                   class="block px-6 py-3 text-xs uppercase tracking-widest font-bold hover:bg-brand-gray-50 hover:text-brand-gold transition-colors <?php echo $activeNav === $key ? 'text-brand-gold' : 'text-brand-black'; ?>"
                                   <?php echo $activeNav === $key ? 'aria-current="page"' : ''; ?>>
                                    <?php echo e($item['label']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if ($navUser): ?>
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
                <button type="button" @click="open = !open" :aria-expanded="open" aria-haspopup="true" class="text-[10px] font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors flex items-center gap-1">
                    My Account
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
                <div x-show="open" x-transition x-cloak class="absolute right-0 mt-4 w-48 bg-white shadow-2xl border border-brand-gray-200 py-2 z-50">
                    <a href="/account/index.php" class="block px-6 py-3 text-xs uppercase tracking-widest font-bold text-brand-black hover:text-brand-gold hover:bg-brand-gray-50">Account</a>
                    <a href="/account/bookmarks.php" class="block px-6 py-3 text-xs uppercase tracking-widest font-bold text-brand-black hover:text-brand-gold hover:bg-brand-gray-50">Bookmarks</a>
                    <a href="/logout.php" class="block px-6 py-3 text-xs uppercase tracking-widest font-bold text-brand-black hover:text-brand-gold hover:bg-brand-gray-50">Sign Out</a>
                </div>
            </div>
        <?php else: ?>
            <a href="/login.php" class="nav-link text-[10px] font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors">Sign In</a>
        <?php endif; ?>

        <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener"
            class="btn-gold btn-buy text-[10px] px-8 py-3">Buy Now</a>
    </div>

    <!-- Mobile: the commerce CTA stays visible up top; navigation lives in the bottom bar -->
    <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener"
        class="lg:hidden btn-gold btn-buy text-[9px] px-4 py-2 tracking-[0.2em]">Buy Now</a>
</nav>

<!-- MOBILE BOTTOM TAB BAR (body gets matching bottom padding in style.css) -->
<nav class="mobile-tab-bar lg:hidden fixed bottom-0 inset-x-0 z-50 bg-white border-t border-brand-gray-200" aria-label="Primary mobile">
    <div class="grid grid-cols-5">
        <?php foreach ($mobileBarLinks as $key): $item = $navLinks[$key]; $isActive = $activeNav === $key; ?>
            <a href="<?php echo e($item['href']); ?>"
               class="flex flex-col items-center justify-center gap-1 pt-2.5 pb-2 text-[9px] font-bold uppercase tracking-widest transition-colors <?php echo $isActive ? 'text-brand-gold' : 'text-brand-gray-500 hover:text-brand-black'; ?>"
               <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="<?php echo $isActive ? '2' : '1.5'; ?>" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($item['icon']); ?>" />
                </svg>
                <span><?php echo e($item['short']); ?></span>
            </a>
        <?php endforeach; ?>
        <button type="button" @click="moreSheet = true" :aria-expanded="moreSheet" aria-controls="mobile-more-sheet"
                class="flex flex-col items-center justify-center gap-1 pt-2.5 pb-2 text-[9px] font-bold uppercase tracking-widest transition-colors <?php echo $mobileMoreActive ? 'text-brand-gold' : 'text-brand-gray-500 hover:text-brand-black'; ?>">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="<?php echo $mobileMoreActive ? '2' : '1.5'; ?>" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <span>More</span>
        </button>
    </div>
</nav>

<!-- MOBILE "MORE" SHEET — slides up from behind the tab bar -->
<div x-show="moreSheet" x-cloak class="fixed inset-0 z-[60] lg:hidden" id="mobile-more-sheet"
     role="dialog" aria-modal="true" aria-label="More pages" @keydown.escape.window="moreSheet = false">
    <div x-show="moreSheet"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-brand-black/60 backdrop-blur-sm" @click="moreSheet = false"></div>
    <div x-show="moreSheet"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-full"
         x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0"
         x-transition:leave-end="translate-y-full"
         class="mobile-more-sheet absolute inset-x-0 bottom-0 bg-white border-t-2 border-brand-gold shadow-2xl px-6 pt-6 max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <div class="font-bold tracking-[0.3em] text-xs uppercase text-brand-black">ZIBRAH CODE<span class="text-brand-gold text-[8px] align-top ml-1">™</span></div>
            <button type="button" @click="moreSheet = false" class="w-11 h-11 -mr-2 flex items-center justify-center text-brand-black/50 hover:text-brand-gold transition-colors" aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <nav class="grid grid-cols-2 gap-3" aria-label="More pages">
            <?php foreach ($mobileMoreLinks as $key): $item = $navLinks[$key]; $isActive = $activeNav === $key; ?>
                <a href="<?php echo e($item['href']); ?>" @click="moreSheet = false"
                   class="flex items-center gap-3 px-4 py-4 border transition-colors <?php echo $isActive ? 'border-brand-gold text-brand-gold' : 'border-brand-gray-200 text-brand-black hover:border-brand-gold hover:text-brand-gold'; ?>"
                   <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($item['icon']); ?>" />
                    </svg>
                    <span class="text-xs font-bold uppercase tracking-widest"><?php echo e($item['label']); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="mt-6 pt-5 border-t border-brand-gray-200 flex flex-wrap items-center gap-x-6 gap-y-3">
            <?php if ($navUser): ?>
                <a href="/account/index.php" @click="moreSheet = false" class="text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">My Account</a>
                <a href="/account/bookmarks.php" @click="moreSheet = false" class="text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">Bookmarks</a>
                <a href="/logout.php" @click="moreSheet = false" class="text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">Sign Out</a>
            <?php else: ?>
                <a href="/login.php" @click="moreSheet = false" class="text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">Sign In</a>
            <?php endif; ?>
            <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-gold btn-buy text-[10px] px-6 py-3 ml-auto">Buy Now</a>
        </div>
        <p class="text-[10px] text-brand-gold/50 italic uppercase tracking-[0.3em] text-center pt-6 pb-4">Angles show what words cannot tell</p>
    </div>
</div>
