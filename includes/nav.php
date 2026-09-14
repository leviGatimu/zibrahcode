<?php
/**
 * Shared nav — one items array drives both desktop nav and the mobile sidebar.
 * Expects $activeNav to be set by the including page.
 */
$navItems = [
    ['key' => 'home', 'label' => 'Home', 'href' => '/index.php', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
    ['key' => 'about', 'label' => 'About', 'href' => '/about.php', 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
    ['key' => 'book', 'label' => 'The Book', 'href' => '/book.php', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
    ['key' => 'framework', 'label' => 'Framework', 'href' => '/framework.php', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z'],
    ['key' => 'blog', 'label' => 'Blog', 'href' => '/blog.php', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'],
    ['key' => 'podcast', 'label' => 'Podcast', 'href' => '/podcast.php', 'icon' => 'M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z'],
    ['key' => 'events', 'label' => 'Events', 'href' => '/events.php', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3.75 18.75V7.5a2.25 2.25 0 012.25-2.25h12a2.25 2.25 0 012.25 2.25v11.25m-16.5 0A2.25 2.25 0 006 21h12a2.25 2.25 0 002.25-2.25m-16.5 0V9.75a2.25 2.25 0 012.25-2.25h12a2.25 2.25 0 012.25 2.25v9M6 12.75h.008v.008H6v-.008zm0 3h.008v.008H6v-.008zm2.25-3h.008v.008H8.25v-.008zm0 3h.008v.008H8.25v-.008zm2.25-3h.008v.008H10.5v-.008zm0 3h.008v.008H10.5v-.008zm2.25-3h.008v.008H12.75v-.008zm0 3h.008v.008H12.75v-.008zm2.25-3h.008v.008H15v-.008zm0 3h.008v.008H15v-.008zm2.25-3h.008v.008H17.25v-.008zm0 3h.008v.008H17.25v-.008z'],
    ['key' => 'inquire', 'label' => 'Inquire', 'href' => '/inquire.php', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
    ['key' => 'contact', 'label' => 'Contact', 'href' => '/contact.php', 'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75'],
];
$navUser = currentUser();
$navTransparentAtTop = $navTransparentAtTop ?? false;
?>
<!-- NAVIGATION: always has a translucent blurred backdrop, so text stays legible over any page
     content (photos, dark heroes, etc.) without needing per-page light/dark text variants.
     Pages that set $navTransparentAtTop (e.g. post.php) opt into a mobile-only variant where
     the nav has no background at all until scrolled — see .nav-mobile-transparent-top in style.css. -->
<nav class="fixed top-0 w-full z-50 transition-all duration-700 px-8 md:px-16 flex justify-between items-center nav-translucent py-8 <?php echo $navTransparentAtTop ? 'nav-mobile-transparent-top' : ''; ?>"
    :class="scrolled ? 'nav-scrolled py-4 shadow-sm' : ''">
    <a href="/index.php" class="font-bold tracking-[0.4em] text-sm uppercase text-brand-black">ZIBRAH CODE<span
            class="text-[8px] align-top ml-1 opacity-50">™</span></a>
    <div class="hidden lg:flex items-center space-x-10">
        <?php foreach ($navItems as $item): ?>
            <a href="<?php echo e($item['href']); ?>"
               class="nav-link text-[10px] font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors <?php echo $activeNav === $item['key'] ? 'active' : ''; ?>">
               <?php echo e($item['label']); ?>
            </a>
        <?php endforeach; ?>

        <?php if ($navUser): ?>
            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                <button @click="open = !open" class="text-[10px] font-bold uppercase tracking-widest text-brand-gray-600 hover:text-brand-gold transition-colors flex items-center gap-1">
                    My Account
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
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
    <button @click="mobileMenu = true" class="lg:hidden p-2 text-brand-black transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
    </button>
</nav>

<!-- MOBILE SIDEBAR MENU -->
<div x-show="mobileMenu" class="fixed inset-0 z-[60] lg:hidden" x-cloak>
    <div x-show="mobileMenu"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="absolute inset-0 bg-brand-black/60 backdrop-blur-sm" @click="mobileMenu = false"></div>
    <div x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="absolute right-0 top-0 bottom-0 w-[340px] max-w-[85vw] bg-white border-l-2 border-brand-gold shadow-2xl flex flex-col overflow-hidden">

        <!-- Background watermark -->
        <div class="absolute -bottom-10 -right-16 text-[9rem] font-display font-black text-brand-black/[0.04] leading-none uppercase select-none pointer-events-none rotate-12">ZC</div>

        <div class="relative z-10 flex flex-col h-full overflow-y-auto px-10 pt-10 pb-8">
            <div class="flex items-center justify-between mb-16">
                <div class="font-bold tracking-[0.3em] text-xs uppercase text-brand-black">ZIBRAH CODE<span class="text-brand-gold text-[8px] align-top ml-1">™</span></div>
                <button @click="mobileMenu = false" class="text-brand-black/50 hover:text-brand-gold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l18 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-grow">
                <?php foreach ($navItems as $item): ?>
                    <a href="<?php echo e($item['href']); ?>" @click="mobileMenu = false"
                       class="group flex items-center gap-4 py-4 border-b border-brand-gray-200">
                        <svg class="w-5 h-5 flex-shrink-0 <?php echo $activeNav === $item['key'] ? 'text-brand-gold' : 'text-brand-gray-400 group-hover:text-brand-gold'; ?> transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="<?php echo e($item['icon']); ?>" />
                        </svg>
                        <span class="text-2xl font-display font-black uppercase tracking-tight transition-colors <?php echo $activeNav === $item['key'] ? 'text-brand-gold' : 'text-brand-black group-hover:text-brand-gold'; ?>">
                            <?php echo e($item['label']); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </nav>

            <div class="pt-8 mt-4 border-t border-brand-gray-200 space-y-5">
                <?php if ($navUser): ?>
                    <a href="/account/index.php" @click="mobileMenu = false" class="block text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">My Account</a>
                    <a href="/account/bookmarks.php" @click="mobileMenu = false" class="block text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">Bookmarks</a>
                    <a href="/logout.php" @click="mobileMenu = false" class="block text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">Sign Out</a>
                <?php else: ?>
                    <a href="/login.php" @click="mobileMenu = false" class="block text-xs font-bold uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors">Sign In</a>
                <?php endif; ?>
                <a href="<?php echo e(AMAZON_URL); ?>" target="_blank" rel="noopener" class="btn-gold btn-buy text-center block mt-4">Buy Now</a>
                <p class="text-[10px] text-brand-gold/50 italic uppercase tracking-[0.3em] text-center pt-2">Angles show what words cannot tell</p>
            </div>
        </div>
    </div>
</div>
