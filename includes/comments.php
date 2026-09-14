<?php
/**
 * Shared comments partial for both blog posts and podcast episodes.
 * Expects $commentableType ('post'|'episode') and $commentableId to be set by the caller.
 */
$stmt = getDb()->prepare(
    'SELECT c.id, c.body, c.created_at, c.is_pinned, c.is_liked_by_admin, u.name AS user_name
     FROM comments c
     JOIN users u ON u.id = c.user_id
     WHERE c.commentable_type = ? AND c.commentable_id = ? AND c.status = "visible"
     ORDER BY c.is_pinned DESC, c.created_at ASC'
);
$stmt->execute([$commentableType, $commentableId]);
$comments = $stmt->fetchAll();
$commentsUser = currentUser();
$commentsAdmin = getDb()->query('SELECT display_name, avatar_path FROM admin_users LIMIT 1')->fetch();

$commentLikeCounts = [];
$commentLikedByViewer = [];
$commentIds = array_column($comments, 'id');
if ($commentIds) {
    $placeholders = implode(',', array_fill(0, count($commentIds), '?'));

    $countStmt = getDb()->prepare(
        "SELECT likeable_id, COUNT(*) AS cnt FROM likes WHERE likeable_type = 'comment' AND likeable_id IN ($placeholders) GROUP BY likeable_id"
    );
    $countStmt->execute($commentIds);
    foreach ($countStmt->fetchAll() as $row) {
        $commentLikeCounts[$row['likeable_id']] = (int) $row['cnt'];
    }

    if ($commentsUser) {
        $likedStmt = getDb()->prepare(
            "SELECT likeable_id FROM likes WHERE user_id = ? AND likeable_type = 'comment' AND likeable_id IN ($placeholders)"
        );
        $likedStmt->execute(array_merge([$commentsUser['id']], $commentIds));
    } else {
        $likedStmt = getDb()->prepare(
            "SELECT likeable_id FROM likes WHERE guest_token = ? AND likeable_type = 'comment' AND likeable_id IN ($placeholders)"
        );
        $likedStmt->execute(array_merge([guestToken()], $commentIds));
    }
    foreach ($likedStmt->fetchAll(PDO::FETCH_COLUMN) as $likedId) {
        $commentLikedByViewer[$likedId] = true;
    }
}
?>
<section id="comments" class="mt-12 md:mt-24 pt-16 border-t border-brand-gray-200">
    <h3 class="text-3xl serif font-black text-brand-black mb-10"><?php echo count($comments); ?> Comment<?php echo count($comments) === 1 ? '' : 's'; ?></h3>

    <div class="space-y-6 mb-10 md:mb-16">
        <?php foreach ($comments as $comment): ?>
            <div class="flex gap-4 pb-6 border-b border-brand-gray-100 <?php echo $comment['is_pinned'] ? 'bg-brand-gold/5 -mx-4 px-4 pt-4' : ''; ?>">
                <div class="w-10 h-10 rounded-full bg-brand-gold/15 text-brand-gold font-bold text-sm flex items-center justify-center flex-shrink-0">
                    <?php echo e(mb_strtoupper(mb_substr($comment['user_name'], 0, 1))); ?>
                </div>
                <div class="min-w-0">
                    <div class="flex flex-wrap items-baseline gap-x-3 mb-1.5">
                        <span class="text-sm font-bold text-brand-black"><?php echo e($comment['user_name']); ?></span>
                        <span class="text-xs text-brand-gray-400"><?php echo date('F j, Y', strtotime($comment['created_at'])); ?></span>
                        <?php if ($comment['is_pinned']): ?>
                            <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 bg-brand-gold/20 text-brand-gold">Pinned</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-brand-gray-700 font-light leading-relaxed mb-3"><?php echo nl2br(e($comment['body'])); ?></p>
                    <button onclick="toggleLike(this, 'comment', <?php echo (int) $comment['id']; ?>)"
                        data-liked="<?php echo !empty($commentLikedByViewer[$comment['id']]) ? '1' : '0'; ?>"
                        class="flex items-center gap-1.5 text-xs font-bold <?php echo !empty($commentLikedByViewer[$comment['id']]) ? 'text-brand-gold' : 'text-brand-gray-400'; ?> hover:text-brand-gold transition-colors">
                        <svg class="icon-heart-outline w-4 h-4 <?php echo !empty($commentLikedByViewer[$comment['id']]) ? 'hidden' : ''; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <svg class="icon-heart-filled w-4 h-4 <?php echo !empty($commentLikedByViewer[$comment['id']]) ? '' : 'hidden'; ?>" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                        </svg>
                        <span class="like-count"><?php echo $commentLikeCounts[$comment['id']] ?? 0; ?></span>
                    </button>
                    <?php if ($comment['is_liked_by_admin'] && $commentsAdmin): ?>
                        <div class="flex items-center gap-2 mt-3">
                            <?php if (!empty($commentsAdmin['avatar_path'])): ?>
                                <img src="/<?php echo e($commentsAdmin['avatar_path']); ?>" alt="" class="w-5 h-5 rounded-full object-cover">
                            <?php else: ?>
                                <span class="w-5 h-5 rounded-full bg-brand-black text-white text-[9px] font-bold flex items-center justify-center"><?php echo e(mb_strtoupper(mb_substr($commentsAdmin['display_name'] ?: 'Z', 0, 1))); ?></span>
                            <?php endif; ?>
                            <span class="text-xs text-brand-gray-500">&hearts; Liked by <?php echo e($commentsAdmin['display_name'] ?: 'the author'); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($comments)): ?>
            <p class="text-brand-gray-500 italic">Be the first to share your perspective.</p>
        <?php endif; ?>
    </div>

    <?php if ($commentsUser): ?>
        <form action="/actions/comment-add" method="POST" class="space-y-4">
            <?php echo csrfField(); ?>
            <input type="hidden" name="type" value="<?php echo e($commentableType); ?>">
            <input type="hidden" name="id" value="<?php echo (int) $commentableId; ?>">
            <input type="hidden" name="redirect" value="<?php echo e($_SERVER['REQUEST_URI']); ?>">
            <label class="text-xs uppercase tracking-[0.3em] text-brand-black font-black">Add a Comment</label>
            <textarea name="body" required rows="3" placeholder="Share your perspective..." class="form-textarea"></textarea>
            <div class="text-right">
                <button type="submit" class="btn-premium">Post Comment</button>
            </div>
        </form>
    <?php else: ?>
        <p class="text-brand-gray-600">
            <a href="/login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="text-brand-gold font-bold hover:underline">Sign in</a> to join the conversation.
        </p>
    <?php endif; ?>
</section>
