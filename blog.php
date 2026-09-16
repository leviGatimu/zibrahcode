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

$categories = $db->query('SELECT DISTINCT category FROM posts WHERE status = "published" AND category IS NOT NULL ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);

// The newest post is featured only on the unfiltered first page; every other
// view is a plain grid so search and category results stay predictable.
$featured = (!$isFiltered && $page === 1 && count($posts) > 1) ? array_shift($posts) : null;

$filterUrl = static function (string $cat = ''): string {
    return '/blog.php' . ($cat !== '' ? '?category=' . urlencode($cat) : '');
};
$pageUrl = static function (int $p) use ($search, $category): string {
    $q = ['page' => $p];
    if ($search !== '') { $q['s'] = $search; }
    if ($category !== '') { $q['category'] = $category; }
    return '/blog.php?' . http_build_query($q);
};
$episodeFor = static function (array $post): ?array {
    return $post['media_type']
        ? ['media_type' => $post['media_type'], 'audio_file_path' => $post['audio_file_path'], 'video_file_path' => $post['video_file_path'], 'cover_image_path' => $post['cover_image_path'], 'title' => $post['episode_title']]
        : null;
};
$metaLine = static function (array $post) use ($showViewCounts): string {
    $parts = [date('M j, Y', strtotime($post['published_at']))];
    if ($post['category']) { $parts[] = e($post['category']); }
    if ($showViewCounts) { $parts[] = number_format($post['view_count']) . ' views'; }
    return implode(' &middot; ', $parts);
};
?>

<!-- PAGE HEADER -->
<header class="bg-brand-gray-50 border-b border-brand-gray-100">
    <div class="section-container pt-24 lg:pt-40 pb-12 lg:pb-16">
        <div class="grid lg:grid-cols-12 gap-10 lg:gap-16 items-end">
            <div class="lg:col-span-7 reveal active">
                <p class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-6">Insights</p>
                <h1 class="text-5xl sm:text-6xl serif text-brand-black leading-none tracking-tighter font-black">Essays on truth, perception and belief.</h1>
                <p class="text-lg sm:text-xl text-brand-gray-600 font-light leading-relaxed mt-8 max-w-xl">Writing that extends the Zibrah Code framework into leadership, judgment and conflict.</p>
            </div>
            <form action="/blog.php" method="GET" role="search" class="lg:col-span-5 reveal active">
                <label for="blog-search" class="block text-xs font-bold uppercase tracking-widest text-brand-black mb-3">Search the blog</label>
                <div class="flex">
                    <input id="blog-search" type="search" name="s" value="<?php echo e($search); ?>" placeholder="Search essays"
                        class="flex-1 min-w-0 h-12 bg-white border border-brand-gray-200 px-4 text-sm text-brand-black placeholder-brand-gray-400 focus:outline-none focus:border-brand-gold transition-colors">
                    <button type="submit" class="h-12 px-5 bg-brand-black text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors">Search</button>
                </div>
            </form>
        </div>
    </div>
</header>

<main class="section-container py-12 lg:py-20">

    <!-- FILTERS + RESULT LINE -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-8 border-b border-brand-gray-200">
        <nav aria-label="Categories" class="flex flex-wrap gap-x-6 gap-y-2 text-sm">
            <a href="<?php echo $filterUrl(); ?>" class="<?php echo $category === '' && $search === '' ? 'text-brand-black font-semibold border-b-2 border-brand-gold' : 'text-brand-gray-500 hover:text-brand-black'; ?> pb-1 transition-colors">All</a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo $filterUrl($cat); ?>" class="<?php echo $category === $cat ? 'text-brand-black font-semibold border-b-2 border-brand-gold' : 'text-brand-gray-500 hover:text-brand-black'; ?> pb-1 transition-colors"><?php echo e($cat); ?></a>
            <?php endforeach; ?>
        </nav>
        <p class="text-sm text-brand-gray-500">
            <?php if ($isFiltered): ?>
                <?php echo $totalPosts; ?> result<?php echo $totalPosts === 1 ? '' : 's'; ?><?php if ($search !== ''): ?> for &ldquo;<?php echo e($search); ?>&rdquo;<?php endif; ?>
                &middot; <a href="/blog.php" class="text-brand-black underline decoration-brand-gray-300 hover:decoration-brand-gold">Clear</a>
            <?php else: ?>
                <?php echo $totalPosts; ?> essay<?php echo $totalPosts === 1 ? '' : 's'; ?>
            <?php endif; ?>
        </p>
    </div>

    <?php if (empty($posts) && !$featured): ?>
        <div class="empty-state p-12 md:p-16 text-center mt-12">
            <p class="serif text-2xl font-bold text-brand-black">Nothing matches that yet.</p>
            <p class="text-brand-gray-600 font-light mt-2">Try another word, or <a href="/blog.php" class="text-brand-black underline decoration-brand-gray-300 hover:decoration-brand-gold">browse every essay</a>.</p>
        </div>
    <?php endif; ?>

    <!-- FEATURED (latest) -->
    <?php if ($featured): ?>
        <article class="grid lg:grid-cols-12 gap-8 lg:gap-16 items-center py-12 lg:py-16 border-b border-brand-gray-200 group reveal active">
            <div class="lg:col-span-7 relative">
                <a href="/post.php?slug=<?php echo e($featured['slug']); ?>" class="block aspect-[16/10] overflow-hidden bg-brand-gray-100">
                    <img src="/<?php echo e($featured['featured_image_path']); ?>" alt="<?php echo e($featured['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="eager" fetchpriority="high">
                </a>
                <?php echo episodeBadgeHtml($episodeFor($featured), $featured['featured_image_path']); ?>
            </div>
            <div class="lg:col-span-5">
                <p class="text-brand-gold font-bold text-xs tracking-[0.3em] uppercase mb-4">Latest</p>
                <p class="text-xs text-brand-gray-500 mb-3"><?php echo $metaLine($featured); ?></p>
                <h2 class="serif text-3xl sm:text-4xl font-black text-brand-black tracking-tight leading-tight">
                    <a href="/post.php?slug=<?php echo e($featured['slug']); ?>" class="group-hover:text-brand-gold transition-colors"><?php echo e($featured['title']); ?></a>
                </h2>
                <p class="text-lg text-brand-gray-600 font-light leading-relaxed mt-5"><?php echo e($featured['excerpt']); ?></p>
                <a href="/post.php?slug=<?php echo e($featured['slug']); ?>" class="inline-block mt-6 text-xs font-bold uppercase tracking-widest text-brand-black hover:text-brand-gold transition-colors border-b border-brand-gray-300 hover:border-brand-gold pb-1">Read the essay &rarr;</a>
            </div>
        </article>
    <?php endif; ?>

    <!-- GRID -->
    <?php if ($posts): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12 pt-12 lg:pt-16">
            <?php foreach ($posts as $post): ?>
                <article class="group reveal active">
                    <div class="relative">
                        <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="block aspect-[16/10] overflow-hidden bg-brand-gray-100">
                            <img src="/<?php echo e($post['featured_image_path']); ?>" alt="<?php echo e($post['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                        </a>
                        <?php echo episodeBadgeHtml($episodeFor($post), $post['featured_image_path']); ?>
                    </div>
                    <p class="text-xs text-brand-gray-500 mt-6 mb-2"><?php echo $metaLine($post); ?></p>
                    <h2 class="serif text-xl sm:text-2xl font-bold text-brand-black leading-snug">
                        <a href="/post.php?slug=<?php echo e($post['slug']); ?>" class="group-hover:text-brand-gold transition-colors"><?php echo e($post['title']); ?></a>
                    </h2>
                    <p class="text-brand-gray-600 font-light leading-relaxed mt-3"><?php echo e($post['excerpt']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- PAGINATION -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Pagination" class="flex items-center justify-between gap-6 mt-16 pt-8 border-t border-brand-gray-200 text-sm">
            <?php if ($page > 1): ?>
                <a href="<?php echo $pageUrl($page - 1); ?>" class="font-semibold text-brand-black hover:text-brand-gold transition-colors">&larr; Newer</a>
            <?php else: ?><span></span><?php endif; ?>
            <ol class="flex items-center gap-2">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <li>
                        <a href="<?php echo $pageUrl($p); ?>" <?php echo $p === $page ? 'aria-current="page"' : ''; ?>
                           class="w-9 h-9 flex items-center justify-center text-xs font-semibold <?php echo $p === $page ? 'bg-brand-black text-white' : 'text-brand-gray-600 hover:text-brand-black'; ?>"><?php echo $p; ?></a>
                    </li>
                <?php endfor; ?>
            </ol>
            <?php if ($page < $totalPages): ?>
                <a href="<?php echo $pageUrl($page + 1); ?>" class="font-semibold text-brand-black hover:text-brand-gold transition-colors">Older &rarr;</a>
            <?php else: ?><span></span><?php endif; ?>
        </nav>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/episode-player-modal.php'; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
