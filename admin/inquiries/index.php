<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$inquiries = getDb()->query('SELECT * FROM appointment_requests ORDER BY created_at DESC')->fetchAll();

$statusStyles = [
    'new' => 'border-brand-gold',
    'contacted' => 'border-gray-100',
    'scheduled' => 'border-gray-100',
    'closed' => 'border-gray-100',
];
$statusBadge = [
    'new' => 'bg-brand-gold/20 text-brand-gold',
    'contacted' => 'bg-blue-50 text-blue-600',
    'scheduled' => 'bg-green-50 text-green-600',
    'closed' => 'bg-gray-100 text-gray-500',
];

$pageTitle = 'Inquiries | Zibrah Code Admin';
$activeAdminNav = 'inquiries';
require __DIR__ . '/../includes/admin-header.php';
?>

<h1 class="font-display font-black text-3xl text-brand-black mb-10">Inquiries</h1>

<div class="space-y-4">
    <?php foreach ($inquiries as $inq): ?>
        <div class="bg-white border <?php echo $statusStyles[$inq['status']] ?? 'border-gray-100'; ?> p-8">
            <div class="flex flex-wrap justify-between items-start gap-4 mb-4">
                <div>
                    <p class="font-bold text-brand-black"><?php echo e($inq['name']); ?> <span class="font-normal text-gray-400">&lt;<?php echo e($inq['email']); ?>&gt;</span></p>
                    <?php if ($inq['phone']): ?><p class="text-sm text-gray-500 mt-1"><?php echo e($inq['phone']); ?></p><?php endif; ?>
                </div>
                <span class="text-xs font-bold uppercase px-3 py-1 <?php echo $statusBadge[$inq['status']] ?? 'bg-gray-100 text-gray-500'; ?>">
                    <?php echo e($inq['status']); ?>
                </span>
            </div>

            <div class="flex flex-wrap gap-x-8 gap-y-2 text-sm text-gray-500 mb-4">
                <?php if ($inq['topic']): ?><span><span class="font-bold text-brand-black">Topic:</span> <?php echo e($inq['topic']); ?></span><?php endif; ?>
                <?php if ($inq['preferred_date']): ?><span><span class="font-bold text-brand-black">Preferred Date:</span> <?php echo date('M j, Y', strtotime($inq['preferred_date'])); ?></span><?php endif; ?>
                <?php if ($inq['preferred_time']): ?><span><span class="font-bold text-brand-black">Preferred Time:</span> <?php echo e($inq['preferred_time']); ?></span><?php endif; ?>
                <span><span class="font-bold text-brand-black">Received:</span> <?php echo date('M j, Y g:i A', strtotime($inq['created_at'])); ?></span>
            </div>

            <?php if ($inq['message']): ?>
                <p class="text-gray-600 mb-6"><?php echo nl2br(e($inq['message'])); ?></p>
            <?php endif; ?>

            <div class="flex flex-wrap gap-4">
                <?php foreach (['contacted', 'scheduled', 'closed'] as $nextStatus): ?>
                    <?php if ($inq['status'] !== $nextStatus): ?>
                        <form action="/admin/inquiries/update-status" method="POST">
                            <?php echo csrfField(); ?>
                            <input type="hidden" name="id" value="<?php echo $inq['id']; ?>">
                            <input type="hidden" name="status" value="<?php echo $nextStatus; ?>">
                            <button type="submit" class="text-xs font-bold uppercase text-gray-500 hover:text-brand-black">Mark <?php echo ucfirst($nextStatus); ?></button>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($inquiries)): ?>
        <p class="p-10 text-center text-gray-400 italic bg-white border border-gray-100">No inquiries yet.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
