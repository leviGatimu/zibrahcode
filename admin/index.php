<?php
require_once __DIR__ . '/includes/admin-auth-check.php';

$admin = currentAdmin();
$db = getDb();
$stats = [
    'published_posts' => $db->query('SELECT COUNT(*) FROM posts WHERE status = "published"')->fetchColumn(),
    'draft_posts' => $db->query('SELECT COUNT(*) FROM posts WHERE status = "draft"')->fetchColumn(),
    'published_episodes' => $db->query('SELECT COUNT(*) FROM podcast_episodes WHERE status = "published"')->fetchColumn(),
    'draft_episodes' => $db->query('SELECT COUNT(*) FROM podcast_episodes WHERE status = "draft"')->fetchColumn(),
    'new_messages' => $db->query('SELECT COUNT(*) FROM contact_messages WHERE status = "new"')->fetchColumn(),
    'new_inquiries' => $db->query('SELECT COUNT(*) FROM appointment_requests WHERE status = "new"')->fetchColumn(),
    'subscribers' => $db->query('SELECT COUNT(*) FROM newsletter_subscribers WHERE status = "subscribed"')->fetchColumn(),
    'total_comments' => $db->query('SELECT COUNT(*) FROM comments WHERE status = "visible"')->fetchColumn(),
];

// Unified activity feed — merge the 3 recent-activity sources into one timeline.
$recentComments = $db->query(
    'SELECT c.id, c.body AS text, c.created_at, u.name AS name, c.commentable_type, c.commentable_id
     FROM comments c JOIN users u ON u.id = c.user_id
     WHERE c.status = "visible" ORDER BY c.created_at DESC LIMIT 5'
)->fetchAll();
$recentMessages = $db->query(
    'SELECT id, COALESCE(subject, message) AS text, created_at, name FROM contact_messages ORDER BY created_at DESC LIMIT 5'
)->fetchAll();
$recentInquiries = $db->query(
    'SELECT id, COALESCE(topic, "General inquiry") AS text, created_at, name FROM appointment_requests ORDER BY created_at DESC LIMIT 5'
)->fetchAll();

$activity = [];
foreach ($recentComments as $row) {
    $activity[] = ['type' => 'comment', 'name' => $row['name'], 'text' => 'commented on ' . $row['commentable_type'] . ' #' . $row['commentable_id'], 'created_at' => $row['created_at']];
}
foreach ($recentMessages as $row) {
    $activity[] = ['type' => 'message', 'name' => $row['name'], 'text' => 'sent a message: ' . $row['text'], 'created_at' => $row['created_at']];
}
foreach ($recentInquiries as $row) {
    $activity[] = ['type' => 'inquiry', 'name' => $row['name'], 'text' => 'requested a time: ' . $row['text'], 'created_at' => $row['created_at']];
}
usort($activity, fn($a, $b) => strtotime($b['created_at']) <=> strtotime($a['created_at']));
$activity = array_slice($activity, 0, 6);

$overviewStats = [
    ['label' => 'Published Posts', 'value' => $stats['published_posts']],
    ['label' => 'Draft Posts', 'value' => $stats['draft_posts']],
    ['label' => 'Published Episodes', 'value' => $stats['published_episodes']],
    ['label' => 'Draft Episodes', 'value' => $stats['draft_episodes']],
    ['label' => 'Comments', 'value' => $stats['total_comments']],
    ['label' => 'Subscribers', 'value' => $stats['subscribers']],
];

$attentionItems = [
    [
        'label' => 'New Messages', 'value' => $stats['new_messages'], 'href' => '/admin/contact/index.php',
        'icon' => 'M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75',
    ],
    [
        'label' => 'New Inquiries', 'value' => $stats['new_inquiries'], 'href' => '/admin/inquiries/index.php',
        'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5',
    ],
    [
        'label' => 'Draft Episodes', 'value' => $stats['draft_episodes'], 'href' => '/admin/podcast/index.php',
        'icon' => 'M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3.75 3.75 0 01-3.75-3.75V4.5a3.75 3.75 0 117.5 0v7.5a3.75 3.75 0 01-3.75 3.75z',
    ],
];

$activityIcons = [
    'comment' => ['color' => 'bg-blue-400', 'label' => 'Comment'],
    'message' => ['color' => 'bg-brand-gold', 'label' => 'Message'],
    'inquiry' => ['color' => 'bg-emerald-400', 'label' => 'Inquiry'],
];

$hour = (int) date('G');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
$adminFirstName = trim(explode(' ', $admin['display_name'] ?: $admin['username'])[0]);

$pageTitle = 'Dashboard | Zibrah Code Admin';
$activeAdminNav = 'dashboard';
require __DIR__ . '/includes/admin-header.php';
?>

<div class="mb-12">
    <h1 class="font-display font-black text-3xl text-brand-black"><?php echo e($greeting); ?>, <?php echo e($adminFirstName); ?>.</h1>
    <p class="text-xs uppercase tracking-[0.3em] text-brand-gold font-bold mt-2"><?php echo date('l, F j, Y'); ?></p>
</div>

<!-- OVERVIEW -->
<div class="bg-brand-black text-white p-10 md:p-14 mb-8">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-10 md:divide-x md:divide-white/10">
        <?php foreach ($overviewStats as $stat): ?>
            <div class="text-center px-2 md:px-4">
                <p class="text-3xl md:text-4xl font-display font-black text-white"><?php echo (int) $stat['value']; ?></p>
                <p class="text-[10px] uppercase tracking-[0.2em] text-white/40 mt-3"><?php echo e($stat['label']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- NEEDS ATTENTION -->
<div class="grid md:grid-cols-3 gap-4 mb-16">
    <?php foreach ($attentionItems as $item): ?>
        <a href="<?php echo e($item['href']); ?>"
           class="group flex items-center gap-5 p-6 bg-white border border-brand-gray-200 hover:border-brand-gold transition-colors">
            <svg class="w-7 h-7 flex-shrink-0 <?php echo $item['value'] > 0 ? 'text-brand-gold' : 'text-brand-gray-300'; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo $item['icon']; ?>" />
            </svg>
            <div class="flex-grow">
                <p class="text-2xl font-display font-black <?php echo $item['value'] > 0 ? 'text-brand-black' : 'text-brand-gray-400'; ?>"><?php echo (int) $item['value']; ?></p>
                <p class="text-xs uppercase tracking-widest text-gray-500 mt-1"><?php echo e($item['label']); ?></p>
            </div>
            <span class="text-brand-gold opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all">&rarr;</span>
        </a>
    <?php endforeach; ?>
</div>

<div class="grid lg:grid-cols-3 gap-12">
    <!-- ACTIVITY FEED -->
    <div class="lg:col-span-2">
        <h2 class="font-display font-black text-xl text-brand-black mb-6">Recent Activity</h2>
        <div class="bg-white border border-gray-100 divide-y divide-gray-100">
            <?php if (empty($activity)): ?>
                <p class="p-8 text-gray-500 italic text-center">Nothing yet — it'll show up here.</p>
            <?php endif; ?>
            <?php foreach ($activity as $item): ?>
                <div class="p-6 flex items-start gap-4">
                    <span class="w-2 h-2 rounded-full mt-2 flex-shrink-0 <?php echo $activityIcons[$item['type']]['color']; ?>"></span>
                    <div class="min-w-0 flex-grow">
                        <p class="text-sm text-brand-black"><span class="font-bold"><?php echo e($item['name']); ?></span> <?php echo e($item['text']); ?></p>
                    </div>
                    <span class="text-xs text-gray-400 flex-shrink-0"><?php echo date('M j', strtotime($item['created_at'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div>
        <h2 class="font-display font-black text-xl text-brand-black mb-6">Quick Actions</h2>
        <div class="space-y-3">
            <a href="/admin/posts/edit.php" class="flex items-center justify-between px-6 py-5 bg-brand-black text-white hover:bg-brand-gold transition-all group">
                <span class="text-xs font-bold uppercase tracking-widest">New Post</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </a>
            <a href="/admin/podcast/edit.php" class="flex items-center justify-between px-6 py-5 bg-white border border-brand-gray-200 hover:border-brand-gold transition-all">
                <span class="text-xs font-bold uppercase tracking-widest text-brand-black">New Episode</span>
                <svg class="w-5 h-5 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/admin-footer.php'; ?>
