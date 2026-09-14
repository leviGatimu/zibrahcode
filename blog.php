<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Blog & Insights | Zibrah Code™ on Truth and Leadership';
$pageDescription = 'Explore essays, frameworks, and geometric insights on conflict, belief, and leadership from the Zibrah Code model by Ibrahim Ngugi.';
$activeNav = 'blog';
$ogImage = SITE_URL . '/assets/images/wisdom.jpg';

$db = getDb();
$search = trim($_GET['s'] ?? '');
$category = trim($_GET['category'] ?? '');
$perPage = 6;
$page = max(1, (int) ($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;

$isFiltered = $search !== '' || $category !== '';
$canonicalPath = '/blog.php' . ($page > 1 ? '?page=' . $page : '');
$robotsMeta = $isFiltered ? 'noindex, follow' : 'index, follow';
$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Blog","item":"' . SITE_URL . '/blog.php"}]}',
];

require __DIR__ . '/includes/header.php';

$where = ['posts.status = "published"'];
$params = [];
if ($search !== '') {
    $where[] = '(posts.title LIKE :search OR posts.excerpt LIKE :search OR posts.body LIKE :search)';
    $params['search'] = '%' . $search . '%';
}
if ($category !== '') {
    $where[] = 'posts.category = :category';
    $params['category'] = $category;
}
$whereSql = implode(' AND ', $where);

$countStmt = $db->prepare("SELECT COUNT(*) FROM posts WHERE $whereSql");
$countStmt->execute($params);
$totalPosts = (int) $countStmt->fetchColumn();
$totalPages = max(1, (int) ceil($totalPosts / $perPage));

$showViewCounts = getSetting('show_view_counts') === '1';

$stmt = $db->prepare(
    "SELECT posts.title, posts.slug, posts.excerpt, posts.featured_image_path, posts.category, posts.published_at, posts.view_count,
        pe.media_type, pe.audio_file_path, pe.video_file_path, pe.cover_image_path, pe.title AS episode_title
     FROM posts
     LEFT JOIN podcast_episodes pe ON pe.id = posts.podcast_episode_id
     WHERE $whereSql ORDER BY posts.published_at DESC LIMIT :limit OFFSET :offset"
);
foreach ($params as $key => $value) {
    $stmt->bindValue(":$key", $value);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();

$latestUpdates = $db->query('SELECT title, slug, featured_image_path, published_at FROM posts WHERE status = "published" ORDER BY published_at DESC LIMIT 3')->fetchAll();
$categories = $db->query('SELECT DISTINCT category FROM posts WHERE status = "published" AND category IS NOT NULL ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
?>

<div class="pt-40 pb-8 section-container text-center reveal active">
    <?php echo angleGlyph(75, 'w-12 h-12 mx-auto mb-4'); ?>
    <h1 class="text-4xl sm:text-5xl font-display font-black text-brand-black uppercase tracking-tight mb-4">Blog & Insights</h1>
    <hr class="gold-divider w-24 mx-auto">
</div>

<main class="max-w-6xl mx-auto px-6 md:px-24 pb-32 pt-16">
    <div class="grid lg:grid-cols-12 gap-16">
        <!-- POSTS -->
        <div class="lg:col-span-8">
            <?php if ($search !== '' || $category !== ''): ?>
                <p class="text-sm text-brand-gray-500 uppercase tracking-widest mb-10">
                    <?php echo $totalPosts; ?> result<?php echo $totalPosts === 1 ? '' : 's'; ?>
                    <?php if ($search !== ''): ?> for "<?php echo e($search); ?>"<?php endif; ?>
                    <?php if ($category !== ''): ?> in <?php echo e($category); ?><?php endif; ?>
                    — <a href="/blog.php" class="text-brand-gold underline">Clear</a>
                </p>
            <?php endif; ?>

            <?php if (empty($posts)): ?>
                <div class="empty-state p-16 text-center">
                    <p class="text-2xl serif italic text-brand-gray-600">No posts found.</p>
                </div>
            <?php endif; ?>

            <div class="space-y-16">
                <?php foreach ($posts as $post): ?>
                    <article class="flex flex-col sm:flex-row gap-8 bg-white overflow-hidden group reveal active">
                        <div class="sm:w-2/5 relative flex-shrink-0">
                            <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="block h-full overflow-hidden">
                                <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-full object-cover min-h-[200px] shadow-sm transform group-hover:scale-105 transition-transform duration-700" loading="lazy">
                            </a>
                            <?php echo episodeBadgeHtml(
                                $post['media_type'] ? ['media_type' => $post['media_type'], 'audio_file_path' => $post['audio_file_path'], 'video_file_path' => $post['video_file_path'], 'cover_image_path' => $post['cover_image_path'], 'title' => $post['episode_title']] : null,
                                $post['featured_image_path']
                            ); ?>
                        </div>
                        <div class="sm:w-3/5 flex flex-col justify-center py-2">
                            <span class="text-[10px] font-black text-brand-gold uppercase tracking-wider mb-2"><?php echo date('M j, Y', strtotime($post['published_at'])); ?><?php echo $post['category'] ? ' &middot; ' . e($post['category']) : ''; ?><?php echo $showViewCounts ? ' &middot; ' . number_format($post['view_count']) . ' views' : ''; ?></span>
                            <h2 class="text-2xl serif font-bold text-brand-black leading-snug mb-3 group-hover:text-brand-gold transition-colors">
                                <a href="/post.php?slug=<?php echo e($post['slug']); ?>"><?php echo e($post['title']); ?></a>
                            </h2>
                            <p class="text-brand-gray-600 text-[15px] leading-relaxed italic mb-4"><?php echo e($post['excerpt']); ?></p>
                            <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="text-[10px] font-black uppercase tracking-widest text-brand-gold">Read More</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center gap-4 pt-16">
                    <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                        <a href="/blog.php?page=<?php echo $p; ?><?php echo $search !== '' ? '&s=' . urlencode($search) : ''; ?><?php echo $category !== '' ? '&category=' . urlencode($category) : ''; ?>"
                           class="w-10 h-10 flex items-center justify-center text-xs font-bold <?php echo $p === $page ? 'bg-brand-black text-white' : 'text-brand-black hover:text-brand-gold'; ?>">
                           <?php echo $p; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- SIDEBAR -->
        <aside class="lg:col-span-4 space-y-10">
            <form action="/blog.php" method="GET" class="relative shadow-sm">
                <input type="text" name="s" value="<?php echo e($search); ?>" placeholder="Search..." class="w-full bg-brand-gray-50 border border-brand-gray-200 py-3.5 px-5 pr-12 text-[15px] focus:ring-2 focus:ring-brand-gold outline-none text-brand-gray-700 placeholder-brand-gray-400">
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-gray-400 hover:text-brand-gold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>

            <div class="space-y-5">
                <div class="bg-brand-black text-white uppercase tracking-wider text-[13px] py-3 px-4 font-bold">Latest Updates</div>
                <div class="space-y-6">
                    <?php foreach ($latestUpdates as $update): ?>
                        <div class="flex gap-4 group">
                            <div class="w-24 h-[72px] flex-shrink-0 overflow-hidden shadow-sm">
                                <img src="/<?php echo e($update['featured_image_path']); ?>" alt="<?php echo e($update['title']); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" loading="lazy">
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="text-[10px] font-black text-brand-gold uppercase tracking-wider mb-1"><?php echo date('M j, Y', strtotime($update['published_at'])); ?></span>
                                <h4 class="text-[13px] font-black text-brand-black leading-snug group-hover:text-brand-gold transition-colors">
                                    <a href="/post.php?slug=<?php echo e($update['slug']); ?>"><?php echo e($update['title']); ?></a>
                                </h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($categories): ?>
                <div class="space-y-5">
                    <div class="bg-brand-black text-white uppercase tracking-wider text-[13px] py-3 px-4 font-bold">Categories</div>
                    <ul class="text-[13px] font-black text-brand-black uppercase space-y-3 pl-2">
                        <?php foreach ($categories as $cat): ?>
                            <li>
                                <a href="/blog.php?category=<?php echo urlencode($cat); ?>" class="hover:text-brand-gold cursor-pointer flex items-center gap-3 transition-colors">
                                    <span class="w-1.5 h-1.5 bg-brand-gold"></span> <?php echo e($cat); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </aside>
    </div>
</main>

<?php require __DIR__ . '/includes/episode-player-modal.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
