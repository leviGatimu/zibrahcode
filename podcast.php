<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'The Zibrah Code Podcast | Truth, Perception & Leadership';
$pageDescription = 'Conversations on truth, perception, belief, and leadership — the Zibrah Code podcast with Ibrahim Ngugi.';
$canonicalPath = '/podcast.php';
$activeNav = 'podcast';

$episodes = getDb()->query(
    'SELECT title, slug, description, cover_image_path, episode_number, published_at FROM podcast_episodes WHERE status = "published" ORDER BY published_at DESC'
)->fetchAll();

$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Podcast","item":"' . SITE_URL . '/podcast.php"}]}',
    '{"@context":"https://schema.org","@type":"ItemList","itemListElement":[' . implode(',', array_map(function ($ep, $i) {
        return '{"@type":"ListItem","position":' . ($i + 1) . ',"url":' . json_encode(SITE_URL . '/podcast-episode.php?slug=' . $ep['slug']) . ',"name":' . json_encode($ep['title']) . '}';
    }, $episodes, array_keys($episodes))) . ']}',
];

require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-40 pb-32">
    <div class="text-center mb-24 reveal active">
        <?php echo angleGlyph(75, 'w-12 h-12 mx-auto mb-4'); ?>
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Listen In</h4>
        <h1 class="text-4xl sm:text-5xl md:text-8xl serif text-brand-black leading-none tracking-tighter font-black">The Podcast.</h1>
        <p class="text-xl text-brand-gray-600 font-light leading-relaxed max-w-2xl mx-auto mt-10">Conversations on truth, perception, belief, and leadership — extending the Zibrah Code framework into voice.</p>
    </div>

    <?php if (empty($episodes)): ?>
        <div class="max-w-2xl mx-auto empty-state p-10 md:p-20 text-center reveal active">
            <p class="text-3xl serif italic text-brand-gray-600 mb-8">New episodes are coming soon.</p>
            <p class="text-brand-gray-500 mb-10">Subscribe below and we'll let you know the moment the first episode drops.</p>
            <a href="/index.php#connect" class="btn-premium">Join the Newsletter</a>
        </div>
    <?php else: ?>
        <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto">
            <?php foreach ($episodes as $episode): ?>
                <a href="/podcast-episode.php?slug=<?php echo e($episode['slug']); ?>" class="card-featured relative block p-6 md:p-10 group overflow-hidden">
                    <div class="aspect-video bg-brand-gray-100 mb-8 overflow-hidden">
                        <?php if ($episode['cover_image_path']): ?>
                            <img src="/<?php echo e($episode['cover_image_path']); ?>" alt="<?php echo e($episode['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <?php if ($episode['episode_number']): ?>
                        <span class="text-brand-gold font-black text-sm">EP. <?php echo (int) $episode['episode_number']; ?></span>
                    <?php endif; ?>
                    <h2 class="text-2xl serif font-bold text-brand-black mt-2 mb-3 group-hover:text-brand-gold transition-colors"><?php echo e($episode['title']); ?></h2>
                    <p class="text-brand-gray-600 font-light"><?php echo e($episode['description']); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
