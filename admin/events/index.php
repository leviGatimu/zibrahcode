<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$events = getDb()->query('SELECT id, title, location, status, event_date FROM events ORDER BY event_date DESC')->fetchAll();

$pageTitle = 'Events | Zibrah Code Admin';
$activeAdminNav = 'events';
require __DIR__ . '/../includes/admin-header.php';
?>

<div class="flex justify-between items-center mb-10">
    <h1 class="font-display font-black text-3xl text-brand-black">Events</h1>
    <a href="/admin/events/edit.php" class="bg-brand-black text-white px-6 py-3 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">+ New Event</a>
</div>

<!-- Mobile: stacked cards -->
<div class="md:hidden space-y-4">
    <?php foreach ($events as $event): ?>
        <div class="bg-white border border-gray-100 p-5">
            <div class="flex justify-between items-start gap-4 mb-3">
                <p class="font-bold text-brand-black leading-snug"><?php echo e($event['title']); ?></p>
                <span class="text-xs font-bold uppercase px-3 py-1 flex-shrink-0 <?php echo $event['status'] === 'published' ? 'bg-brand-gold/20 text-brand-gold' : 'bg-gray-100 text-gray-500'; ?>">
                    <?php echo e($event['status']); ?>
                </span>
            </div>
            <div class="text-sm text-gray-500 space-y-1 mb-4">
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Date</span><?php echo date('M j, Y', strtotime($event['event_date'])); ?></p>
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Location</span><?php echo e($event['location'] ?: '—'); ?></p>
            </div>
            <div class="flex gap-6 pt-3 border-t border-gray-100">
                <a href="/admin/events/edit.php?id=<?php echo $event['id']; ?>" class="text-xs font-bold uppercase text-brand-black hover:text-brand-gold">Edit</a>
                <form action="/admin/events/delete" method="POST" onsubmit="return confirm('Delete this event permanently?');">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                    <button type="submit" class="text-xs font-bold uppercase text-red-500 hover:text-red-700">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($events)): ?>
        <p class="p-10 text-center text-gray-400 italic bg-white border border-gray-100">No events yet — add your first one.</p>
    <?php endif; ?>
</div>

<!-- Desktop: table -->
<div class="hidden md:block bg-white border border-gray-100 overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-gray-100 text-xs uppercase tracking-widest text-gray-500">
                <th class="p-6">Title</th>
                <th class="p-6">Date</th>
                <th class="p-6">Location</th>
                <th class="p-6">Status</th>
                <th class="p-6"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($events as $event): ?>
                <tr>
                    <td class="p-6 font-bold text-brand-black"><?php echo e($event['title']); ?></td>
                    <td class="p-6 text-gray-500 text-sm"><?php echo date('M j, Y', strtotime($event['event_date'])); ?></td>
                    <td class="p-6 text-gray-500"><?php echo e($event['location'] ?: '—'); ?></td>
                    <td class="p-6">
                        <span class="text-xs font-bold uppercase px-3 py-1 <?php echo $event['status'] === 'published' ? 'bg-brand-gold/20 text-brand-gold' : 'bg-gray-100 text-gray-500'; ?>">
                            <?php echo e($event['status']); ?>
                        </span>
                    </td>
                    <td class="p-6 text-right space-x-4 whitespace-nowrap">
                        <a href="/admin/events/edit.php?id=<?php echo $event['id']; ?>" class="text-xs font-bold uppercase text-brand-black hover:text-brand-gold">Edit</a>
                        <form action="/admin/events/delete" method="POST" class="inline" onsubmit="return confirm('Delete this event permanently?');">
                            <?php echo csrfField(); ?>
                            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                            <button type="submit" class="text-xs font-bold uppercase text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($events)): ?>
                <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">No events yet — add your first one.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
