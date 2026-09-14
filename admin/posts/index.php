<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$posts = getDb()->query('SELECT id, title, slug, category, status, published_at, view_count FROM posts ORDER BY created_at DESC')->fetchAll();

$pageTitle = 'Blog Posts | Zibrah Code Admin';
$activeAdminNav = 'posts';
require __DIR__ . '/../includes/admin-header.php';
?>

<div class="flex justify-between items-center mb-10">
    <h1 class="font-display font-black text-3xl text-brand-black">Blog Posts</h1>
    <a href="/admin/posts/edit.php" class="bg-brand-black text-white px-6 py-3 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">+ New Post</a>
</div>

<!-- Mobile: stacked cards -->
<div class="md:hidden space-y-4">
    <?php foreach ($posts as $post): ?>
        <div class="bg-white border border-gray-100 p-5">
            <div class="flex justify-between items-start gap-4 mb-3">
                <p class="font-bold text-brand-black leading-snug"><?php echo e($post['title']); ?></p>
                <span class="text-xs font-bold uppercase px-3 py-1 flex-shrink-0 <?php echo $post['status'] === 'published' ? 'bg-brand-gold/20 text-brand-gold' : 'bg-gray-100 text-gray-500'; ?>">
                    <?php echo e($post['status']); ?>
                </span>
            </div>
            <div class="text-sm text-gray-500 space-y-1 mb-4">
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Category</span><?php echo e($post['category'] ?: '—'); ?></p>
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Published</span><?php echo $post['published_at'] ? date('M j, Y', strtotime($post['published_at'])) : '—'; ?></p>
                <p><span class="font-bold text-gray-400 uppercase text-xs tracking-widest mr-2">Views</span><?php echo number_format($post['view_count']); ?></p>
            </div>
            <div class="flex gap-6 pt-3 border-t border-gray-100">
                <a href="/admin/posts/edit.php?id=<?php echo $post['id']; ?>" class="text-xs font-bold uppercase text-brand-black hover:text-brand-gold">Edit</a>
                <form action="/admin/posts/delete" method="POST" onsubmit="return confirm('Delete this post permanently?');">
                    <?php echo csrfField(); ?>
                    <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                    <button type="submit" class="text-xs font-bold uppercase text-red-500 hover:text-red-700">Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($posts)): ?>
        <p class="p-10 text-center text-gray-400 italic bg-white border border-gray-100">No posts yet.</p>
    <?php endif; ?>
</div>

<!-- Desktop: table -->
<div class="hidden md:block bg-white border border-gray-100 overflow-x-auto">
    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-gray-100 text-xs uppercase tracking-widest text-gray-500">
                <th class="p-6">Title</th>
                <th class="p-6">Category</th>
                <th class="p-6">Status</th>
                <th class="p-6">Published</th>
                <th class="p-6">Views</th>
                <th class="p-6"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td class="p-6 font-bold text-brand-black"><?php echo e($post['title']); ?></td>
                    <td class="p-6 text-gray-500"><?php echo e($post['category'] ?: '—'); ?></td>
                    <td class="p-6">
                        <span class="text-xs font-bold uppercase px-3 py-1 <?php echo $post['status'] === 'published' ? 'bg-brand-gold/20 text-brand-gold' : 'bg-gray-100 text-gray-500'; ?>">
                            <?php echo e($post['status']); ?>
                        </span>
                    </td>
                    <td class="p-6 text-gray-500 text-sm"><?php echo $post['published_at'] ? date('M j, Y', strtotime($post['published_at'])) : '—'; ?></td>
                    <td class="p-6 text-gray-500 text-sm"><?php echo number_format($post['view_count']); ?></td>
                    <td class="p-6 text-right space-x-4 whitespace-nowrap">
                        <a href="/admin/posts/edit.php?id=<?php echo $post['id']; ?>" class="text-xs font-bold uppercase text-brand-black hover:text-brand-gold">Edit</a>
                        <form action="/admin/posts/delete" method="POST" class="inline" onsubmit="return confirm('Delete this post permanently?');">
                            <?php echo csrfField(); ?>
                            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="text-xs font-bold uppercase text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($posts)): ?>
                <tr><td colspan="6" class="p-10 text-center text-gray-400 italic">No posts yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
