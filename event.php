<?php
require_once __DIR__ . '/includes/bootstrap.php';

$slug = $_GET['slug'] ?? '';
$stmt = getDb()->prepare('SELECT * FROM events WHERE slug = ? AND status = "published"');
$stmt->execute([$slug]);
$event = $stmt->fetch();

if (!$event) {
    http_response_code(404);
    require __DIR__ . '/404.php';
    exit;
}

$galleryStmt = getDb()->prepare('SELECT image_path FROM event_images WHERE event_id = ? ORDER BY sort_order, id');
$galleryStmt->execute([$event['id']]);
$galleryImages = array_map(fn($row) => '/' . $row['image_path'], $galleryStmt->fetchAll());

$isPast = strtotime($event['event_date']) < strtotime(date('Y-m-d'));
$dateLabel = date('F j, Y', strtotime($event['event_date']));
if ($event['event_time']) {
    $dateLabel .= ' at ' . date('g:i A', strtotime($event['event_time']));
}
if ($event['end_date'] && $event['end_date'] !== $event['event_date']) {
    $dateLabel .= ' – ' . date('F j, Y', strtotime($event['end_date']));
}

$pageTitle = $event['title'] . ' | Zibrah Code™ Events';
$pageDescription = $event['location'] ? ($event['title'] . ' — ' . $dateLabel . ' at ' . $event['location']) : ($event['title'] . ' — ' . $dateLabel);
$canonicalPath = '/event.php?slug=' . $event['slug'];
$activeNav = 'events';
$ogImage = $event['cover_image_path'] ? SITE_URL . '/' . $event['cover_image_path'] : SITE_URL . '/assets/images/Front page.png';

$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"Event","name":' . json_encode($event['title']) . ',"startDate":' . json_encode(date('c', strtotime($event['event_date'] . ' ' . ($event['event_time'] ?: '00:00')))) . ',"location":{"@type":"Place","name":' . json_encode($event['location'] ?: 'TBA') . '},"description":' . json_encode($pageDescription) . ($event['cover_image_path'] ? ',"image":' . json_encode($ogImage) : '') . ',"eventAttendanceMode":"https://schema.org/OfflineEventAttendanceMode","eventStatus":"https://schema.org/EventScheduled"}',
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Events","item":"' . SITE_URL . '/events.php"},{"@type":"ListItem","position":3,"name":' . json_encode($event['title']) . ',"item":' . json_encode(SITE_URL . '/' . $canonicalPath) . '}]}',
];

require __DIR__ . '/includes/header.php';
?>

<main class="section-container pt-28 md:pt-40 pb-16 md:pb-32 max-w-4xl mx-auto">
    <div class="mb-10">
        <a href="/events.php" class="text-xs font-black uppercase tracking-widest text-brand-gray-400 hover:text-brand-gold transition-colors">← Back to Events</a>
    </div>

    <div class="mb-10">
        <span class="text-brand-gold font-black text-sm uppercase tracking-wide"><?php echo $isPast ? 'Past Event' : 'Upcoming Event'; ?></span>
        <h1 class="text-4xl md:text-6xl serif font-black text-brand-black tracking-tight mt-4 mb-6"><?php echo e($event['title']); ?></h1>
        <div class="flex flex-wrap gap-x-8 gap-y-2 text-sm text-brand-gray-600 uppercase tracking-widest">
            <span>🗓 <?php echo $dateLabel; ?></span>
            <?php if ($event['location']): ?><span>📍 <?php echo e($event['location']); ?></span><?php endif; ?>
        </div>
    </div>

    <?php if ($event['cover_image_path']): ?>
        <img src="/<?php echo e($event['cover_image_path']); ?>" alt="<?php echo e($event['title']); ?>" class="w-full h-auto mb-10 shadow-2xl">
    <?php endif; ?>

    <?php if ($event['description']): ?>
        <div class="serif text-xl text-brand-gray-700 leading-relaxed space-y-6 mb-10 md:mb-16">
            <?php echo $event['description']; ?>
        </div>
    <?php endif; ?>

    <?php if ($galleryImages): ?>
        <div x-data="{ lightboxOpen: false, activeImage: 0, images: <?php echo e(json_encode($galleryImages)); ?> }">
            <h2 class="text-xs font-black uppercase tracking-widest text-brand-gray-400 mb-8">Photos</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <?php foreach ($galleryImages as $i => $img): ?>
                    <button type="button" @click="activeImage = <?php echo $i; ?>; lightboxOpen = true" class="aspect-square overflow-hidden group">
                        <img src="<?php echo e($img); ?>" alt="<?php echo e($event['title']); ?> photo <?php echo $i + 1; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy">
                    </button>
                <?php endforeach; ?>
            </div>

            <div x-show="lightboxOpen" x-cloak @click="lightboxOpen = false" x-transition.opacity class="fixed inset-0 z-[150] bg-black/95 flex items-center justify-center p-4" style="display: none;">
                <button type="button" @click.stop="lightboxOpen = false" class="absolute top-5 right-5 text-white/80 hover:text-white w-11 h-11 flex items-center justify-center text-2xl" aria-label="Close">✕</button>
                <button type="button" @click.stop="activeImage = (activeImage - 1 + images.length) % images.length" class="absolute left-2 sm:left-5 text-white/80 hover:text-white w-11 h-11 flex items-center justify-center text-3xl" aria-label="Previous photo">‹</button>
                <img :src="images[activeImage]" alt="" class="max-w-full max-h-full object-contain" @click.stop>
                <button type="button" @click.stop="activeImage = (activeImage + 1) % images.length" class="absolute right-2 sm:right-5 text-white/80 hover:text-white w-11 h-11 flex items-center justify-center text-3xl" aria-label="Next photo">›</button>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
