<?php
require_once __DIR__ . '/includes/bootstrap.php';

$slug = $_GET['slug'] ?? '';
$stmt = getDb()->prepare('SELECT * FROM podcast_episodes WHERE slug = ? AND status = "published"');
$stmt->execute([$slug]);
$episode = $stmt->fetch();

if (!$episode) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$pageTitle = $episode['title'] . ' | Zibrah Code™ Podcast';
$pageDescription = $episode['meta_description'] ?: ($episode['description'] ?: 'Listen to this episode of the Zibrah Code podcast.');
$canonicalPath = '/podcast-episode.php?slug=' . $episode['slug'];
$activeNav = 'podcast';
$ogImage = $episode['cover_image_path'] ? SITE_URL . '/' . $episode['cover_image_path'] : SITE_URL . '/assets/images/Front page.png';

$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"PodcastEpisode","name":' . json_encode($episode['title']) . ',"description":' . json_encode($pageDescription) . ',"datePublished":' . json_encode(date('c', strtotime($episode['published_at']))) . ',"associatedMedia":{"@type":"MediaObject","contentUrl":' . json_encode(SITE_URL . '/' . $episode['audio_file_path']) . '},"partOfSeries":{"@type":"PodcastSeries","name":"Zibrah Code Podcast"}}',
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Podcast","item":"' . SITE_URL . '/podcast.php"},{"@type":"ListItem","position":3,"name":' . json_encode($episode['title']) . ',"item":' . json_encode(SITE_URL . '/' . $canonicalPath) . '}]}',
];

require __DIR__ . '/includes/header.php';

$isBookmarked = false;
if ($user = currentUser()) {
    $bookmarkedStmt = getDb()->prepare('SELECT 1 FROM bookmarks WHERE user_id = ? AND bookmarkable_type = "episode" AND bookmarkable_id = ?');
    $bookmarkedStmt->execute([$user['id'], $episode['id']]);
    $isBookmarked = (bool) $bookmarkedStmt->fetchColumn();
}
?>

<main class="section-container pt-40 pb-32 max-w-4xl mx-auto">
    <div class="mb-10">
        <?php if ($episode['episode_number']): ?>
            <span class="text-brand-gold font-black text-sm">EPISODE <?php echo (int) $episode['episode_number']; ?></span>
        <?php endif; ?>
        <h1 class="text-4xl md:text-6xl serif font-black text-brand-black tracking-tight mt-4 mb-6"><?php echo e($episode['title']); ?></h1>
        <div class="flex items-center justify-between">
            <p class="text-sm text-brand-gray-500 uppercase tracking-widest"><?php echo date('F j, Y', strtotime($episode['published_at'])); ?></p>
            <?php if ($user): ?>
                <button onclick="toggleBookmark(this, 'episode', <?php echo (int) $episode['id']; ?>)"
                    data-bookmarked="<?php echo $isBookmarked ? '1' : '0'; ?>"
                    class="text-xs font-bold uppercase tracking-widest <?php echo $isBookmarked ? 'text-brand-gold' : 'text-brand-gray-400'; ?> hover:text-brand-gold transition-colors">
                    ★ <?php echo $isBookmarked ? 'Bookmarked' : 'Bookmark'; ?>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($episode['cover_image_path']): ?>
        <img src="/<?php echo e($episode['cover_image_path']); ?>" alt="<?php echo e($episode['title']); ?>" class="w-full h-auto mb-10 shadow-2xl">
    <?php endif; ?>

    <div class="bg-brand-gray-50 border border-brand-gray-200 p-8 mb-16">
        <audio controls class="audio-player">
            <source src="/<?php echo e($episode['audio_file_path']); ?>" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>

    <?php if ($episode['show_notes']): ?>
        <div class="serif text-xl text-brand-gray-700 leading-relaxed space-y-6 mb-16">
            <?php echo $episode['show_notes']; ?>
        </div>
    <?php endif; ?>

    <?php
    $commentableType = 'episode';
    $commentableId = $episode['id'];
    require __DIR__ . '/includes/comments.php';
    ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
