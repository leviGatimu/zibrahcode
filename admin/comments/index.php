<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$comments = getDb()->query(
    'SELECT c.id, c.body, c.commentable_type, c.commentable_id, c.created_at, c.is_pinned, c.is_liked_by_admin, u.name AS user_name,
        COALESCE(p.title, e.title) AS content_title
     FROM comments c
     JOIN users u ON u.id = c.user_id
     LEFT JOIN posts p ON p.id = c.commentable_id AND c.commentable_type = "post"
     LEFT JOIN podcast_episodes e ON e.id = c.commentable_id AND c.commentable_type = "episode"
     WHERE c.status = "visible"
     ORDER BY c.is_pinned DESC, c.created_at DESC'
)->fetchAll();

$pageTitle = 'Comments | Zibrah Code Admin';
$activeAdminNav = 'comments';
require __DIR__ . '/../includes/admin-header.php';
?>

<h1 class="font-display font-black text-3xl text-brand-black mb-10">Comments</h1>

<div class="bg-white border border-gray-100 divide-y divide-gray-100">
    <?php foreach ($comments as $comment): ?>
        <div class="p-6 flex justify-between items-start gap-6 <?php echo $comment['is_pinned'] ? 'bg-brand-gold/5' : ''; ?>">
            <div>
                <div class="flex flex-wrap items-center gap-2 mb-1">
                    <p class="text-sm font-bold text-brand-black">
                        <?php echo e($comment['user_name']); ?>
                        <span class="font-normal text-gray-400">on <?php echo e($comment['content_title'] ?: $comment['commentable_type'] . ' #' . $comment['commentable_id']); ?></span>
                    </p>
                    <?php if ($comment['is_pinned']): ?>
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 bg-brand-gold/20 text-brand-gold">Pinned</span>
                    <?php endif; ?>
                    <?php if ($comment['is_liked_by_admin']): ?>
                        <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 bg-red-50 text-red-500">&hearts; Liked</span>
                    <?php endif; ?>
                </div>
                <p class="text-gray-600 mt-1"><?php echo e($comment['body']); ?></p>
                <p class="text-xs text-gray-400 mt-2"><?php echo date('M j, Y g:i A', strtotime($comment['created_at'])); ?></p>
            </div>
            <div class="flex flex-col items-end gap-3 flex-shrink-0">
                <div class="flex gap-4">
                    <form action="/admin/comments/toggle-pin" method="POST">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                        <button type="submit" class="text-xs font-bold uppercase text-gray-500 hover:text-brand-black"><?php echo $comment['is_pinned'] ? 'Unpin' : 'Pin'; ?></button>
                    </form>
                    <form action="/admin/comments/toggle-like" method="POST">
                        <?php echo csrfField(); ?>
                        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                        <button type="submit" class="text-xs font-bold uppercase <?php echo $comment['is_liked_by_admin'] ? 'text-red-500 hover:text-red-700' : 'text-gray-500 hover:text-brand-black'; ?>"><?php echo $comment['is_liked_by_admin'] ? '&hearts; Liked' : '&#9825; Like'; ?></button>
                    </form>
                </div>
                <form action="/admin/comments/delete" method="POST" onsubmit="return confirm('Delete this comment?');">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                    <button type="submit" class="text-xs font-bold uppercase text-red-500 hover:text-red-700">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($comments)): ?>
        <p class="p-10 text-center text-gray-400 italic">No comments yet.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
