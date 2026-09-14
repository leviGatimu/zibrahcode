<?php
require_once __DIR__ . '/includes/bootstrap.php';

$slug = $_GET['slug'] ?? '';
$stmt = getDb()->prepare('SELECT * FROM posts WHERE slug = ? AND status = "published"');
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

getDb()->prepare('UPDATE posts SET view_count = view_count + 1 WHERE id = ?')->execute([$post['id']]);
$post['view_count']++;
$showViewCounts = getSetting('show_view_counts') === '1';

$pageTitle = $post['title'] . ' | Zibrah Code™';
$pageDescription = $post['meta_description'] ?: excerptText($post['excerpt'] ?: $post['body'], 160);
$canonicalPath = '/post.php?slug=' . $post['slug'];
$activeNav = 'blog';
$ogImage = SITE_URL . '/' . $post['featured_image_path'];
$navTransparentAtTop = true;

$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"Article","headline":' . json_encode($post['title']) . ',"description":' . json_encode($pageDescription) . ',"image":' . json_encode($ogImage) . ',"url":' . json_encode(SITE_URL . '/' . $canonicalPath) . ',"datePublished":' . json_encode(date('c', strtotime($post['published_at']))) . ',"author":{"@type":"Person","name":' . json_encode($post['author_name']) . '},"publisher":{"@type":"Organization","name":"Zibrah Code™","logo":{"@type":"ImageObject","url":"' . SITE_URL . '/assets/images/favicon.ico"}}}',
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Blog","item":"' . SITE_URL . '/blog.php"},{"@type":"ListItem","position":3,"name":' . json_encode($post['title']) . ',"item":' . json_encode(SITE_URL . '/' . $canonicalPath) . '}]}',
];

require __DIR__ . '/includes/header.php';

$wordCount = str_word_count(strip_tags($post['body']));
$readingMinutes = max(1, (int) ceil($wordCount / 200));

$bookmarkedStmt = null;
$isBookmarked = false;
if ($user = currentUser()) {
    $bookmarkedStmt = getDb()->prepare('SELECT 1 FROM bookmarks WHERE user_id = ? AND bookmarkable_type = "post" AND bookmarkable_id = ?');
    $bookmarkedStmt->execute([$user['id'], $post['id']]);
    $isBookmarked = (bool) $bookmarkedStmt->fetchColumn();
}

$likeCountStmt = getDb()->prepare('SELECT COUNT(*) FROM likes WHERE likeable_type = "post" AND likeable_id = ?');
$likeCountStmt->execute([$post['id']]);
$likeCount = (int) $likeCountStmt->fetchColumn();
if ($user) {
    $likedStmt = getDb()->prepare('SELECT 1 FROM likes WHERE user_id = ? AND likeable_type = "post" AND likeable_id = ?');
    $likedStmt->execute([$user['id'], $post['id']]);
} else {
    $likedStmt = getDb()->prepare('SELECT 1 FROM likes WHERE guest_token = ? AND likeable_type = "post" AND likeable_id = ?');
    $likedStmt->execute([guestToken(), $post['id']]);
}
$isLiked = (bool) $likedStmt->fetchColumn();

$commentCountStmt = getDb()->prepare('SELECT COUNT(*) FROM comments WHERE commentable_type = "post" AND commentable_id = ? AND status = "visible"');
$commentCountStmt->execute([$post['id']]);
$commentCount = (int) $commentCountStmt->fetchColumn();

$postUrl = rtrim(SITE_URL, '/') . '/post.php?slug=' . urlencode($post['slug']);

$linkedEpisode = null;
if (!empty($post['podcast_episode_id'])) {
    $episodeStmt = getDb()->prepare('SELECT title, media_type, audio_file_path, video_file_path, cover_image_path FROM podcast_episodes WHERE id = ?');
    $episodeStmt->execute([$post['podcast_episode_id']]);
    $linkedEpisode = $episodeStmt->fetch() ?: null;
}

// Related posts: same category first, fall back to latest to fill up to 3.
$related = [];
if (!empty($post['category'])) {
    $relStmt = getDb()->prepare(
        'SELECT id, title, slug, excerpt, featured_image_path, published_at FROM posts
         WHERE status = "published" AND id != ? AND category = ? ORDER BY published_at DESC LIMIT 3'
    );
    $relStmt->execute([$post['id'], $post['category']]);
    $related = $relStmt->fetchAll();
}
if (count($related) < 3) {
    $excludeIds = array_merge([$post['id']], array_column($related, 'id'));
    $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));
    $fillStmt = getDb()->prepare(
        "SELECT title, slug, excerpt, featured_image_path, published_at FROM posts
         WHERE status = \"published\" AND id NOT IN ($placeholders) ORDER BY published_at DESC LIMIT ?"
    );
    foreach ($excludeIds as $i => $excludeId) {
        $fillStmt->bindValue($i + 1, $excludeId, PDO::PARAM_INT);
    }
    $fillStmt->bindValue(count($excludeIds) + 1, 3 - count($related), PDO::PARAM_INT);
    $fillStmt->execute();
    $related = array_merge($related, $fillStmt->fetchAll());
}
?>

<!-- FULL-BLEED FEATURED IMAGE — mobile only -->
<header class="lg:hidden relative h-[55vh] min-h-[380px] w-full overflow-hidden mt-0 cursor-pointer" x-data="{ lightboxOpen: false }" @click="lightboxOpen = true" role="button" tabindex="0" @keydown.enter="lightboxOpen = true" aria-label="View full-size image">
    <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>"
        class="absolute inset-0 w-full h-full object-cover" fetchpriority="high">
    <div class="absolute inset-0 bg-gradient-to-t from-brand-black via-brand-black/60 to-transparent"></div>
    <div class="absolute inset-0 bg-brand-black/20"></div>
    <span class="absolute bottom-24 right-5 w-11 h-11 rounded-full bg-black/50 backdrop-blur-sm flex items-center justify-center text-white pointer-events-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
        </svg>
    </span>
    <div class="absolute bottom-0 left-0 right-0 section-container pb-10 reveal active">
        <span class="text-[10px] font-black text-brand-gold uppercase tracking-wider"><?php echo date('F j, Y', strtotime($post['published_at'])); ?> &middot; <?php echo $readingMinutes; ?> min read<?php echo $showViewCounts ? ' &middot; ' . number_format($post['view_count']) . ' views' : ''; ?></span>
        <h1 class="text-3xl sm:text-4xl serif font-black text-white tracking-tight mt-3"><?php echo e($post['title']); ?></h1>
    </div>

    <div x-show="lightboxOpen" x-cloak @click.stop="lightboxOpen = false" x-transition.opacity class="fixed inset-0 z-[150] bg-black/95 flex items-center justify-center p-4" style="display: none;">
        <button type="button" @click.stop="lightboxOpen = false" class="absolute top-5 right-5 text-white/80 hover:text-white w-11 h-11 flex items-center justify-center text-2xl" aria-label="Close full-size image">✕</button>
        <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="max-w-full max-h-full object-contain" @click.stop>
    </div>
</header>

<main class="pt-16 lg:pt-32 pb-16 px-8 md:px-16 max-w-7xl mx-auto">
    <a href="/blog.php" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-brand-gray-500 hover:text-brand-gold transition-colors mb-10 py-2 -my-2 reveal active">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Blog
    </a>

    <div class="lg:grid lg:grid-cols-3 lg:gap-x-16 lg:items-start">
        <article class="lg:col-start-1 lg:col-span-2 lg:row-start-1">
            <!-- DESKTOP TITLE BLOCK -->
            <div class="hidden lg:block mb-10 reveal active">
                <span class="text-[10px] font-black text-brand-gold uppercase tracking-wider"><?php echo date('F j, Y', strtotime($post['published_at'])); ?> &middot; <?php echo $readingMinutes; ?> min read<?php echo $showViewCounts ? ' &middot; ' . number_format($post['view_count']) . ' views' : ''; ?></span>
                <h1 class="text-5xl md:text-6xl serif font-black text-brand-black tracking-tight mt-4 mb-6"><?php echo e($post['title']); ?></h1>
            </div>

            <div class="flex items-center justify-between mb-10 reveal active">
                <p class="text-sm text-brand-gray-500 uppercase tracking-widest">By <?php echo e($post['author_name']); ?></p>
                <?php if ($user): ?>
                    <button onclick="toggleBookmark(this, 'post', <?php echo (int) $post['id']; ?>)"
                        data-bookmarked="<?php echo $isBookmarked ? '1' : '0'; ?>"
                        class="text-xs font-bold uppercase tracking-widest <?php echo $isBookmarked ? 'text-brand-gold' : 'text-brand-gray-400'; ?> hover:text-brand-gold transition-colors">
                        ★ <?php echo $isBookmarked ? 'Bookmarked' : 'Bookmark'; ?>
                    </button>
                <?php endif; ?>
            </div>

            <div class="hidden lg:block relative mb-8 reveal active">
                <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-auto shadow-2xl" fetchpriority="high">
                <?php echo episodeBadgeHtml($linkedEpisode, $post['featured_image_path']); ?>
            </div>

            <!-- LIKE / COMMENT / SHARE ACTION BAR -->
            <div class="flex items-center gap-8 mb-12 pb-8 border-b border-brand-gray-100 reveal active">
                <button onclick="toggleLike(this, 'post', <?php echo (int) $post['id']; ?>)"
                    data-liked="<?php echo $isLiked ? '1' : '0'; ?>"
                    class="flex items-center gap-2 text-sm font-bold <?php echo $isLiked ? 'text-brand-gold' : 'text-brand-gray-500'; ?> hover:text-brand-gold transition-colors">
                    <svg class="icon-heart-outline w-6 h-6 <?php echo $isLiked ? 'hidden' : ''; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    <svg class="icon-heart-filled w-6 h-6 <?php echo $isLiked ? '' : 'hidden'; ?>" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                    </svg>
                    <span class="like-count"><?php echo $likeCount; ?></span>
                </button>

                <a href="#comments" class="flex items-center gap-2 text-sm font-bold text-brand-gray-500 hover:text-brand-gold transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                    </svg>
                    <span><?php echo $commentCount; ?></span>
                </a>

                <div class="relative ml-auto" x-data="{ shareOpen: false }" @click.outside="shareOpen = false">
                    <button type="button"
                        @click="navigator.share ? navigator.share({ title: <?php echo e(json_encode($post['title'])); ?>, url: <?php echo e(json_encode($postUrl)); ?> }).catch(() => {}) : (shareOpen = !shareOpen)"
                        class="flex items-center gap-2 text-sm font-bold text-brand-gray-500 hover:text-brand-gold transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                        </svg>
                        Share
                    </button>
                    <div x-show="shareOpen" x-transition x-cloak
                        class="absolute right-0 mt-4 w-56 bg-white shadow-2xl border border-brand-gray-200 py-2 z-50">
                        <button type="button" onclick="copyShareLink('<?php echo e($postUrl); ?>', this)"
                            class="block w-full text-left px-6 py-3 text-xs uppercase tracking-widest font-bold text-brand-black hover:text-brand-gold hover:bg-brand-gray-50">Copy Link</button>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($postUrl); ?>&text=<?php echo urlencode($post['title']); ?>" target="_blank" rel="noopener"
                            class="block px-6 py-3 text-xs uppercase tracking-widest font-bold text-brand-black hover:text-brand-gold hover:bg-brand-gray-50">Share to X</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($postUrl); ?>" target="_blank" rel="noopener"
                            class="block px-6 py-3 text-xs uppercase tracking-widest font-bold text-brand-black hover:text-brand-gold hover:bg-brand-gray-50">Share to Facebook</a>
                        <a href="https://wa.me/?text=<?php echo urlencode($post['title'] . ' ' . $postUrl); ?>" target="_blank" rel="noopener"
                            class="block px-6 py-3 text-xs uppercase tracking-widest font-bold text-brand-black hover:text-brand-gold hover:bg-brand-gray-50">Share to WhatsApp</a>
                    </div>
                </div>
            </div>

            <div class="article-body drop-cap serif text-xl text-brand-gray-700 leading-relaxed reveal active">
                <?php echo $post['body']; ?>
            </div>
        </article>

        <!-- RELATED POSTS — sticky sidebar on desktop, unchanged stacked position on mobile -->
        <?php if ($related): ?>
            <aside class="mt-16 lg:mt-0 pt-16 lg:pt-0 border-t lg:border-t-0 border-brand-gray-100 reveal active lg:col-start-3 lg:row-start-1 lg:row-span-2 lg:sticky lg:top-32">
                <h3 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">More Perspectives</h3>
                <div class="grid sm:grid-cols-3 lg:grid-cols-1 gap-10">
                    <?php foreach ($related as $more): ?>
                        <a href="/post.php?slug=<?php echo e($more['slug']); ?>" class="group block">
                            <div class="relative aspect-[16/10] bg-brand-gray-100 mb-4 overflow-hidden">
                                <img src="/<?php echo e($more['featured_image_path']); ?>" alt="<?php echo e($more['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                            </div>
                            <h5 class="font-bold serif text-lg text-brand-black group-hover:text-brand-gold transition-colors leading-snug"><?php echo e($more['title']); ?></h5>
                        </a>
                    <?php endforeach; ?>
                </div>
            </aside>
        <?php endif; ?>

        <div class="lg:col-start-1 lg:col-span-2 lg:row-start-2">
            <?php
            $commentableType = 'post';
            $commentableId = $post['id'];
            require __DIR__ . '/includes/comments.php';
            ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/includes/episode-player-modal.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
