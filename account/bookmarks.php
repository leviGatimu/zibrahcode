<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireLogin();

$pageTitle = 'My Bookmarks | Zibrah Code™';
$pageDescription = 'Your saved Zibrah Code articles and episodes.';
$canonicalPath = '/account/bookmarks.php';
$activeNav = '';
$robotsMeta = 'noindex, nofollow';
require __DIR__ . '/../includes/header.php';

$user = currentUser();
$db = getDb();

$postBookmarks = $db->prepare(
    'SELECT p.title, p.slug, p.excerpt, p.featured_image_path FROM bookmarks b
     JOIN posts p ON p.id = b.bookmarkable_id
     WHERE b.user_id = ? AND b.bookmarkable_type = "post"
     ORDER BY b.created_at DESC'
);
$postBookmarks->execute([$user['id']]);
$postBookmarks = $postBookmarks->fetchAll();

$episodeBookmarks = $db->prepare(
    'SELECT e.title, e.slug, e.description FROM bookmarks b
     JOIN podcast_episodes e ON e.id = b.bookmarkable_id
     WHERE b.user_id = ? AND b.bookmarkable_type = "episode"
     ORDER BY b.created_at DESC'
);
$episodeBookmarks->execute([$user['id']]);
$episodeBookmarks = $episodeBookmarks->fetchAll();
?>

<main class="section-container pt-28 md:pt-40 pb-16 md:pb-32 max-w-5xl mx-auto">
    <div class="mb-10 md:mb-16 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-3">My Account</h4>
        <h1 class="text-4xl md:text-5xl serif text-brand-black leading-none tracking-tighter font-black">Bookmarks.</h1>
    </div>

    <nav class="flex gap-8 border-b border-brand-gray-200 mb-10 md:mb-16">
        <a href="/account/index.php" class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gray-500 hover:text-brand-black">Profile</a>
        <span class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gold border-b-2 border-brand-gold">Bookmarks</span>
        <a href="/account/preferences.php" class="pb-4 text-xs font-black uppercase tracking-widest text-brand-gray-500 hover:text-brand-black">Preferences</a>
    </nav>

    <div class="grid lg:grid-cols-2 gap-8">
        <div class="bg-brand-gray-50 border border-brand-gray-200 p-8 md:p-10 reveal active">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h3 class="text-xs font-black uppercase tracking-[0.3em] text-brand-black">Articles</h3>
            </div>
            <?php if (empty($postBookmarks)): ?>
                <div class="empty-state p-8 text-center">
                    <p class="text-brand-gray-500 italic">No bookmarked articles yet.</p>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($postBookmarks as $post): ?>
                        <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="flex gap-5 group">
                            <div class="w-24 h-20 flex-shrink-0 overflow-hidden bg-brand-gray-100">
                                <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-full object-cover" loading="lazy">
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-brand-black group-hover:text-brand-gold transition-colors truncate"><?php echo e($post['title']); ?></h4>
                                <p class="text-sm text-brand-gray-500 line-clamp-2"><?php echo e($post['excerpt']); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-brand-gray-50 border border-brand-gray-200 p-8 md:p-10 reveal active">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.483 0-.964-.078-1.423-.23l-.892-.3A2.25 2.25 0 010.75 12.36V11.64a2.25 2.25 0 011.445-2.107l.892-.3A5.98 5.98 0 004.51 8.25H6.75z" />
                </svg>
                <h3 class="text-xs font-black uppercase tracking-[0.3em] text-brand-black">Episodes</h3>
            </div>
            <?php if (empty($episodeBookmarks)): ?>
                <div class="empty-state p-8 text-center">
                    <p class="text-brand-gray-500 italic">No bookmarked episodes yet.</p>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($episodeBookmarks as $episode): ?>
                        <a href="/podcast-episode.php?slug=<?php echo e($episode['slug']); ?>" class="block group">
                            <h4 class="font-bold text-brand-black group-hover:text-brand-gold transition-colors"><?php echo e($episode['title']); ?></h4>
                            <p class="text-sm text-brand-gray-500 line-clamp-2"><?php echo e($episode['description']); ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
