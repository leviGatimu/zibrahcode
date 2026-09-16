<?php
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Events | Zibrah Code™';
$pageDescription = 'Upcoming appearances, talks, and past events from Ibrahim Ngugi and the Zibrah Code framework.';
$canonicalPath = '/events.php';
$activeNav = 'events';

$db = getDb();
$upcomingEvents = $db->query(
    'SELECT title, slug, location, cover_image_path, event_date, event_time FROM events WHERE status = "published" AND event_date >= CURDATE() ORDER BY event_date ASC'
)->fetchAll();
$pastEvents = $db->query(
    'SELECT title, slug, location, cover_image_path, event_date, event_time FROM events WHERE status = "published" AND event_date < CURDATE() ORDER BY event_date DESC'
)->fetchAll();

$extraJsonLd = [
    '{"@context":"https://schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"name":"Home","item":"' . SITE_URL . '/"},{"@type":"ListItem","position":2,"name":"Events","item":"' . SITE_URL . '/events.php"}]}',
];

require __DIR__ . '/includes/header.php';

function eventCard(array $event): string
{
    $dateLabel = date('M j, Y', strtotime($event['event_date']));
    if (!empty($event['event_time'])) {
        $dateLabel .= ' &middot; ' . date('g:i A', strtotime($event['event_time']));
    }
    ob_start();
    ?>
    <a href="/event.php?slug=<?php echo e($event['slug']); ?>" class="card-featured relative block p-6 md:p-10 group overflow-hidden">
        <div class="aspect-video bg-brand-gray-100 mb-8 overflow-hidden">
            <?php if ($event['cover_image_path']): ?>
                <img src="/<?php echo e($event['cover_image_path']); ?>" alt="<?php echo e($event['title']); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy">
            <?php endif; ?>
        </div>
        <span class="text-brand-gold font-black text-sm uppercase tracking-wide"><?php echo $dateLabel; ?></span>
        <h2 class="text-2xl serif font-bold text-brand-black mt-2 mb-3 group-hover:text-brand-gold transition-colors"><?php echo e($event['title']); ?></h2>
        <?php if ($event['location']): ?>
            <p class="text-brand-gray-600 font-light">📍 <?php echo e($event['location']); ?></p>
        <?php endif; ?>
        <span class="inline-block mt-4 text-[10px] font-black uppercase tracking-widest text-brand-gold">View Details →</span>
    </a>
    <?php
    return ob_get_clean();
}
?>

<main class="section-container pt-28 md:pt-40 pb-16 md:pb-32">
    <div class="text-center mb-12 md:mb-24 reveal active">
        <h4 class="text-brand-gold font-bold text-xs tracking-[0.6em] uppercase mb-10">Appearances</h4>
        <h1 class="text-4xl sm:text-5xl md:text-8xl serif text-brand-black leading-none tracking-tighter font-black">Events.</h1>
        <p class="text-xl text-brand-gray-600 font-light leading-relaxed max-w-2xl mx-auto mt-10">Talks, book signings, and appearances: where to find Ibrahim Ngugi and the Zibrah Code framework in person.</p>
    </div>

    <?php if (empty($upcomingEvents) && empty($pastEvents)): ?>
        <div class="max-w-2xl mx-auto empty-state p-10 md:p-20 text-center reveal active">
            <p class="text-3xl serif italic text-brand-gray-600 mb-8">No events scheduled yet.</p>
            <p class="text-brand-gray-500 mb-10">Subscribe below and we'll let you know the moment one is announced.</p>
            <a href="/index.php#connect" class="btn-premium">Join the Newsletter</a>
        </div>
    <?php else: ?>
        <?php if ($upcomingEvents): ?>
            <div class="mb-28">
                <h2 class="text-xs font-black uppercase tracking-widest text-brand-gray-400 mb-10 reveal active">Upcoming Events</h2>
                <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="reveal active"><?php echo eventCard($event); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($pastEvents): ?>
            <div>
                <h2 class="text-xs font-black uppercase tracking-widest text-brand-gray-400 mb-10 reveal active">Past Events</h2>
                <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto opacity-75">
                    <?php foreach ($pastEvents as $event): ?>
                        <div class="reveal active"><?php echo eventCard($event); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
