<?php
/**
 * Shared admin <head> + sidebar chrome.
 * Caller sets $pageTitle and $activeAdminNav before including.
 */
$pageTitle = $pageTitle ?? 'Admin | Zibrah Code';
$activeAdminNav = $activeAdminNav ?? '';
$admin = currentAdmin();

$adminNavItems = [
    ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => '/admin/index.php'],
    ['key' => 'posts', 'label' => 'Blog Posts', 'href' => '/admin/posts/index.php'],
    ['key' => 'podcast', 'label' => 'Podcast', 'href' => '/admin/podcast/index.php'],
    ['key' => 'events', 'label' => 'Events', 'href' => '/admin/events/index.php'],
    ['key' => 'comments', 'label' => 'Comments', 'href' => '/admin/comments/index.php'],
    ['key' => 'inquiries', 'label' => 'Inquiries', 'href' => '/admin/inquiries/index.php'],
    ['key' => 'newsletter', 'label' => 'Newsletter', 'href' => '/admin/newsletter/index.php'],
    ['key' => 'contact', 'label' => 'Messages', 'href' => '/admin/contact/index.php'],
    ['key' => 'profile', 'label' => 'Profile', 'href' => '/admin/profile.php'],
    ['key' => 'settings', 'label' => 'Settings', 'href' => '/admin/settings.php'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pageTitle); ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <!-- Fonts must match includes/header.php exactly. The post editor's preview
         renders real article markup, and the blog's body copy is EB Garamond at
         weight 400 with italics for blockquotes. Loading only 600/700 here left
         the browser synthesising those faces, which is why the preview never
         looked like the published page. -->
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Inter:wght@200;300;400;500;600;700&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Mirrors the public theme in includes/header.php. The admin previously
        // defined only three brand colours, so the ~17 `brand-gray-*` classes
        // used across admin — including the preview's body-text colour —
        // silently resolved to nothing. Keep the two in sync.
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            black: '#1A1A1A',
                            true: '#1A1A1A',
                            white: '#FFFFFF',
                            gold: '#B89441',
                            'gold-light': '#D4B876',
                            'gold-dark': '#8A6F2E',
                            gray: {
                                50: '#FAFAFA', 100: '#F2F2F2', 200: '#E5E5E5', 300: '#D4D4D4',
                                400: '#A3A3A3', 500: '#737373', 600: '#525252', 700: '#404040',
                                800: '#262626', 900: '#171717'
                            },
                            navy: '#1A1A1A',
                            cream: '#FAFAFA',
                            slate: '#525252'
                        }
                    },
                    fontFamily: {
                        serif: ['"EB Garamond"', 'serif'],
                        display: ['"Playfair Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo ASSETS_VERSION; ?>">
    <meta name="csrf-token" content="<?php echo e(csrfToken()); ?>">
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        table { min-width: 640px; }
    </style>
</head>
<body class="bg-brand-gray-50 antialiased" style="background:#FAFAFA;" x-data="{ sidebarOpen: false }">
<div class="lg:flex min-h-screen">
    <!-- Mobile top bar -->
    <div class="lg:hidden flex items-center justify-between bg-brand-black text-white p-5">
        <div class="font-display font-black text-base tracking-widest uppercase">Zibrah Code <span class="text-brand-gold text-[10px] tracking-[0.3em] ml-1">Admin</span></div>
        <button @click="sidebarOpen = true" class="p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
    </div>

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" x-cloak
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-brand-black/60 z-40 lg:hidden" @click="sidebarOpen = false"></div>

    <aside
        class="w-64 bg-brand-black text-white flex-shrink-0 flex flex-col fixed lg:static inset-y-0 left-0 z-50 transform transition-transform duration-300 lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="p-8 flex items-center justify-between">
            <div>
                <div class="font-display font-black text-lg tracking-widest uppercase">Zibrah Code</div>
                <div class="text-[10px] text-brand-gold uppercase tracking-[0.3em] mt-1">Admin</div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden p-2 text-white/60">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 12" />
                </svg>
            </button>
        </div>
        <nav class="flex-grow px-4 space-y-1 overflow-y-auto">
            <?php foreach ($adminNavItems as $item): ?>
                <a href="<?php echo e($item['href']); ?>"
                   class="block px-4 py-3 text-sm font-medium rounded transition-colors <?php echo $activeAdminNav === $item['key'] ? 'bg-brand-gold text-brand-black font-bold' : 'text-white/60 hover:text-white hover:bg-white/5'; ?>">
                   <?php echo e($item['label']); ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="p-4 border-t border-white/10">
            <div class="px-4 py-2 flex items-center gap-3 text-xs text-white/40 mb-2">
                <?php if (!empty($admin['avatar_path'])): ?>
                    <img src="/<?php echo e($admin['avatar_path']); ?>" alt="<?php echo e($admin['display_name'] ?: $admin['username']); ?>" class="w-6 h-6 rounded-full object-cover flex-shrink-0">
                <?php else: ?>
                    <span class="w-6 h-6 rounded-full bg-white/10 text-brand-gold text-[10px] font-bold flex items-center justify-center flex-shrink-0"><?php echo e(mb_strtoupper(mb_substr($admin['display_name'] ?: $admin['username'], 0, 1))); ?></span>
                <?php endif; ?>
                <span>Signed in as <?php echo e($admin['display_name'] ?: $admin['username']); ?></span>
            </div>
            <a href="/admin/logout.php" class="block px-4 py-3 text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 rounded">Sign Out</a>
            <a href="/index.php" class="block px-4 py-3 text-sm font-medium text-white/60 hover:text-white hover:bg-white/5 rounded">View Site →</a>
        </div>
    </aside>
    <main class="flex-grow p-6 md:p-12 max-w-6xl overflow-x-hidden">
        <?php require __DIR__ . '/../../includes/flash.php'; ?>
