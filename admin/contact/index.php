<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$db = getDb();

// Spam is excluded from the default view. It stays reachable under its own tab
// until the nightly purge, so a mistaken flag can still be undone — but it
// never clutters the inbox in the meantime.
$filter = $_GET['filter'] ?? '';
$validFilters = ['new', 'read', 'archived', 'spam'];
if (!in_array($filter, $validFilters, true)) {
    $filter = '';
}

if ($filter === '') {
    $messages = $db->query('SELECT * FROM contact_messages WHERE status != "spam" ORDER BY created_at DESC')->fetchAll();
} else {
    $stmt = $db->prepare('SELECT * FROM contact_messages WHERE status = ? ORDER BY created_at DESC');
    $stmt->execute([$filter]);
    $messages = $stmt->fetchAll();
}

$counts = ['' => 0, 'new' => 0, 'read' => 0, 'archived' => 0, 'spam' => 0];
foreach ($db->query('SELECT status, COUNT(*) AS n FROM contact_messages GROUP BY status')->fetchAll() as $row) {
    if (isset($counts[$row['status']])) {
        $counts[$row['status']] = (int) $row['n'];
    }
    if ($row['status'] !== 'spam') {
        $counts[''] += (int) $row['n'];
    }
}

$tabs = [
    '' => 'Inbox',
    'new' => 'New',
    'read' => 'Read',
    'archived' => 'Archived',
    'spam' => 'Spam',
];

$pageTitle = 'Contact Messages | Zibrah Code Admin';
$activeAdminNav = 'contact';
require __DIR__ . '/../includes/admin-header.php';
?>

<h1 class="font-display font-black text-3xl text-brand-black mb-6">Contact Messages</h1>

<div class="flex flex-wrap gap-2 mb-8 border-b border-brand-gray-200 pb-4">
    <?php foreach ($tabs as $key => $label): ?>
        <a href="/admin/contact/index.php<?php echo $key === '' ? '' : '?filter=' . $key; ?>"
           class="px-4 py-2 text-xs font-bold uppercase tracking-widest transition-colors <?php echo $filter === $key ? 'bg-brand-black text-white' : 'text-brand-gray-500 hover:text-brand-black'; ?>">
            <?php echo e($label); ?>
            <span class="<?php echo $filter === $key ? 'text-brand-gold-light' : 'text-brand-gray-400'; ?>">(<?php echo (int) $counts[$key]; ?>)</span>
        </a>
    <?php endforeach; ?>
</div>

<?php if ($filter === 'spam'): ?>
    <div class="mb-8 p-5 bg-red-50 border border-red-300">
        <p class="text-sm text-red-800 leading-relaxed">
            <strong class="block mb-1">Everything here is deleted automatically at 12:00 PM each day.</strong>
            Deletion is permanent and cannot be undone. If something was flagged by mistake,
            press <strong>Not Spam</strong> before noon to rescue it.
        </p>
    </div>
<?php endif; ?>

<div class="space-y-4">
    <?php foreach ($messages as $msg): ?>
        <?php $isSpam = $msg['status'] === 'spam'; ?>
        <div class="bg-white border <?php echo $isSpam ? 'border-red-300' : ($msg['status'] === 'new' ? 'border-brand-gold' : 'border-brand-gray-100'); ?> p-8">
            <div class="flex justify-between items-start mb-4 gap-4">
                <div>
                    <p class="font-bold text-brand-black"><?php echo e($msg['name']); ?> <span class="font-normal text-brand-gray-400">&lt;<?php echo e($msg['email']); ?>&gt;</span></p>
                    <?php if ($msg['subject']): ?><p class="text-sm text-brand-gray-500 mt-1"><?php echo e($msg['subject']); ?></p><?php endif; ?>
                    <?php if ($isSpam && !empty($msg['spam_marked_at'])): ?>
                        <p class="text-xs text-red-600 font-bold uppercase tracking-widest mt-2">
                            Flagged <?php echo e(date('M j, g:i A', strtotime($msg['spam_marked_at']))); ?> &middot; deletes at 12:00 PM
                        </p>
                    <?php endif; ?>
                </div>
                <span class="text-xs text-brand-gray-400 flex-shrink-0"><?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?></span>
            </div>
            <p class="text-brand-gray-600 mb-6"><?php echo nl2br(e($msg['message'])); ?></p>
            <div class="flex flex-wrap gap-4">
                <?php if (!$isSpam): ?>
                    <?php if ($msg['status'] !== 'read'): ?>
                        <form action="/admin/contact/update-status" method="POST">
                            <?php echo csrfField(); ?>
                            <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                            <input type="hidden" name="filter" value="<?php echo e($filter); ?>">
                            <input type="hidden" name="status" value="read">
                            <button type="submit" class="text-xs font-bold uppercase text-brand-black hover:text-brand-gold">Mark Read</button>
                        </form>
                    <?php endif; ?>
                    <?php if ($msg['status'] !== 'archived'): ?>
                        <form action="/admin/contact/update-status" method="POST">
                            <?php echo csrfField(); ?>
                            <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                            <input type="hidden" name="filter" value="<?php echo e($filter); ?>">
                            <input type="hidden" name="status" value="archived">
                            <button type="submit" class="text-xs font-bold uppercase text-brand-gray-500 hover:text-brand-black">Archive</button>
                        </form>
                    <?php endif; ?>
                    <form action="/admin/contact/update-status" method="POST" class="ml-auto"
                          onsubmit="return confirm('Mark this message as spam? It will be deleted permanently at 12:00 PM.');">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                        <input type="hidden" name="filter" value="<?php echo e($filter); ?>">
                        <input type="hidden" name="status" value="spam">
                        <button type="submit" class="text-xs font-bold uppercase text-brand-gray-400 hover:text-red-600">Mark Spam</button>
                    </form>
                <?php else: ?>
                    <form action="/admin/contact/update-status" method="POST">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="id" value="<?php echo $msg['id']; ?>">
                        <input type="hidden" name="filter" value="<?php echo e($filter); ?>">
                        <input type="hidden" name="status" value="read">
                        <button type="submit" class="text-xs font-bold uppercase text-brand-black hover:text-brand-gold">Not Spam</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($messages)): ?>
        <p class="p-10 text-center text-brand-gray-400 italic bg-white border border-brand-gray-100">
            <?php echo $filter === 'spam' ? 'No spam.' : 'No messages here.'; ?>
        </p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
