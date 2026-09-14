<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$subscribers = getDb()->query(
    'SELECT email, name, status, source, subscribed_at FROM newsletter_subscribers ORDER BY subscribed_at DESC'
)->fetchAll();

$pageTitle = 'Newsletter Subscribers | Zibrah Code Admin';
$activeAdminNav = 'newsletter';
require __DIR__ . '/../includes/admin-header.php';
?>

<div class="flex justify-between items-center mb-10">
    <h1 class="font-display font-black text-3xl text-brand-black">Newsletter Subscribers</h1>
    <a href="/admin/newsletter/export.php" class="bg-brand-black text-white px-6 py-3 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Export CSV</a>
</div>

<!-- Mobile: stacked cards -->
<div class="md:hidden space-y-4">
    <?php foreach ($subscribers as $sub): ?>
        <div class="bg-white border border-gray-100 p-5">
            <div class="flex justify-between items-start gap-4 mb-3">
                <p class="font-bold text-brand-black leading-snug break-all"><?php echo e($sub['email']); ?></p>
                <span class="text-xs font-bold uppercase px-3 py-1 flex-shrink-0 <?php echo $sub['status'] === 'subscribed' ? 'bg-brand-gold/20 text-brand-gold' : 'bg-gray-100 text-gray-500'; ?>">
                    <?php echo e($sub['status']); ?>
                </span>
            </div>
            <div class="text-sm text-gray-500 space-y-1">
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Name</span><?php echo e($sub['name'] ?: '—'); ?></p>
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Source</span><?php echo e($sub['source'] ?: '—'); ?></p>
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Subscribed</span><?php echo date('M j, Y', strtotime($sub['subscribed_at'])); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($subscribers)): ?>
        <p class="p-10 text-center text-gray-400 italic bg-white border border-gray-100">No subscribers yet.</p>
    <?php endif; ?>
</div>

<!-- Desktop: table -->
<div class="hidden md:block bg-white border border-gray-100 overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-gray-100 text-xs uppercase tracking-widest text-gray-500">
                <th class="p-6">Email</th>
                <th class="p-6">Name</th>
                <th class="p-6">Status</th>
                <th class="p-6">Source</th>
                <th class="p-6">Subscribed</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($subscribers as $sub): ?>
                <tr>
                    <td class="p-6 font-bold text-brand-black"><?php echo e($sub['email']); ?></td>
                    <td class="p-6 text-gray-500"><?php echo e($sub['name'] ?: '—'); ?></td>
                    <td class="p-6">
                        <span class="text-xs font-bold uppercase px-3 py-1 <?php echo $sub['status'] === 'subscribed' ? 'bg-brand-gold/20 text-brand-gold' : 'bg-gray-100 text-gray-500'; ?>">
                            <?php echo e($sub['status']); ?>
                        </span>
                    </td>
                    <td class="p-6 text-gray-500 text-sm"><?php echo e($sub['source'] ?: '—'); ?></td>
                    <td class="p-6 text-gray-500 text-sm"><?php echo date('M j, Y', strtotime($sub['subscribed_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($subscribers)): ?>
                <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">No subscribers yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
