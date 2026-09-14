<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$db = getDb();
$admin = currentAdmin();
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$post = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM posts WHERE id = ?');
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    if (!$post) {
        flashSet('error', 'Post not found.');
        redirectTo('/admin/posts/index.php');
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfVerify()) {
        $error = 'Invalid form submission, please try again.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $slugInput = trim($_POST['slug'] ?? '');
        $excerpt = trim($_POST['excerpt'] ?? '');
        $body = $_POST['body'] ?? '';
        $category = trim($_POST['category'] ?? '');
        $status = ($_POST['status'] ?? '') === 'published' ? 'published' : 'draft';
        $metaDescription = trim($_POST['meta_description'] ?? '');
        $podcastEpisodeId = ($_POST['podcast_episode_id'] ?? '') !== '' ? (int) $_POST['podcast_episode_id'] : null;

        if ($title === '' || $body === '') {
            $error = 'Title and body are required.';
        } else {
            $slug = uniqueSlug(slugify($slugInput !== '' ? $slugInput : $title), 'posts', $post['id'] ?? null);
            $featuredImagePath = $post['featured_image_path'] ?? null;

            if (!empty($_FILES['featured_image']['name'])) {
                $uploaded = handleImageUpload($_FILES['featured_image'], 'blog/images/' . date('Y/m'), $title);
                if ($uploaded) {
                    $featuredImagePath = $uploaded;
                } else {
                    $error = 'Featured image upload failed — please use a JPG, PNG, or WEBP under 5MB.';
                }
            }

            if (!$error) {
                $publishedAt = $post['published_at'] ?? null;
                $isNewlyPublished = $status === 'published' && ($post['status'] ?? '') !== 'published';
                if ($status === 'published' && !$publishedAt) {
                    $publishedAt = date('Y-m-d H:i:s');
                }

                if ($post) {
                    $stmt = $db->prepare(
                        'UPDATE posts SET title=?, slug=?, excerpt=?, body=?, featured_image_path=?, category=?, podcast_episode_id=?, status=?, published_at=?, meta_description=?, updated_at=NOW() WHERE id=?'
                    );
                    $stmt->execute([$title, $slug, $excerpt, $body, $featuredImagePath, $category, $podcastEpisodeId, $status, $publishedAt, $metaDescription, $post['id']]);
                    flashSet('success', 'Post updated.');
                } else {
                    $stmt = $db->prepare(
                        'INSERT INTO posts (title, slug, excerpt, body, featured_image_path, category, podcast_episode_id, status, published_at, meta_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                    );
                    $stmt->execute([$title, $slug, $excerpt, $body, $featuredImagePath, $category, $podcastEpisodeId, $status, $publishedAt, $metaDescription]);
                    flashSet('success', 'Post created.');
                }

                // The real save superseded the autosaved copy — retire it so the
                // next visit doesn't offer to "recover" work that's already saved.
                // A failure here must never sink a save that already succeeded.
                try {
                    $db->prepare('DELETE FROM post_drafts WHERE admin_id = ? AND post_id = ?')
                        ->execute([$admin['id'], $post ? (int) $post['id'] : 0]);
                } catch (PDOException $e) {
                    error_log('Could not clear post draft after save: ' . $e->getMessage());
                }

                if ($isNewlyPublished) {
                    $postUrl = rtrim(SITE_URL, '/') . '/post.php?slug=' . urlencode($slug);
                    $imageUrl = $featuredImagePath ? rtrim(SITE_URL, '/') . '/' . $featuredImagePath : null;
                    $html = renderNotificationEmail(
                        'New Post',
                        $title,
                        $excerpt !== '' ? $excerpt : 'A new post is up on Zibrah Code.',
                        $imageUrl,
                        'Read the Post',
                        $postUrl
                    );
                    notifySubscribers('New Post: ' . $title, $html);
                }

                redirectTo('/admin/posts/index.php');
            }
        }
    }
}

$episodeOptions = $db->query('SELECT id, title FROM podcast_episodes ORDER BY created_at DESC')->fetchAll();

/**
 * Everything the form renders comes from $form, never straight from $post, so
 * there is one place that decides what the author sees. Three sources feed it,
 * in order of increasing recency: the saved post, an autosaved draft, and —
 * when a submission bounced — whatever was actually typed.
 */
$formFields = ['title', 'slug', 'excerpt', 'body', 'category', 'meta_description', 'status', 'podcast_episode_id'];
$form = [
    'title' => $post['title'] ?? '',
    'slug' => $post['slug'] ?? '',
    'excerpt' => $post['excerpt'] ?? '',
    'body' => $post['body'] ?? '',
    'category' => $post['category'] ?? '',
    'meta_description' => $post['meta_description'] ?? '',
    'status' => $post['status'] ?? 'draft',
    'podcast_episode_id' => $post['podcast_episode_id'] ?? '',
    'featured_image_path' => $post['featured_image_path'] ?? '',
];

$draftInfo = null;
$autosaveReady = true;
$contentTs = $post ? strtotime($post['updated_at'] ?: $post['created_at']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // A rejected submission must never send the author back to the saved
    // version — that would silently delete everything they just wrote. Show
    // exactly what they typed, with the error above it.
    foreach ($formFields as $field) {
        if (array_key_exists($field, $_POST)) {
            $form[$field] = $_POST[$field];
        }
    }
} else {
    // Autosave storage is a safety net, not a dependency. If the table isn't
    // there yet — the migration hasn't run, an upload was partial — the editor
    // still has to open. Losing autosave is an inconvenience; losing the editor
    // is an outage, and this page exists to protect people's writing.
    try {
        $stmt = $db->prepare('SELECT * FROM post_drafts WHERE admin_id = ? AND post_id = ?');
        $stmt->execute([$admin['id'], $id]);
        $draft = $stmt->fetch();
        if ($draft) {
            $isNewer = (string) $draft['title'] !== (string) $form['title']
                || (string) $draft['body'] !== (string) $form['body'];
            if ($isNewer) {
                foreach ($formFields as $field) {
                    if ($draft[$field] !== null && $draft[$field] !== '') {
                        $form[$field] = $draft[$field];
                    }
                }
                // Title and body are the article itself: carry them over verbatim,
                // including a deliberate blanking, rather than falling back.
                $form['title'] = (string) $draft['title'];
                $form['body'] = (string) $draft['body'];
                $draftInfo = $draft;
                $contentTs = strtotime($draft['updated_at']);
            } else {
                $db->prepare('DELETE FROM post_drafts WHERE id = ?')->execute([$draft['id']]);
            }
        }
    } catch (PDOException $e) {
        error_log('Autosave storage unavailable (post_drafts): ' . $e->getMessage());
        $autosaveReady = false;
    }
}

// Byline and dateline for the preview, derived the same way post.php does.
// An unpublished post has no published_at yet, so show today — that is the date
// it would carry if it were published now.
$previewAuthor = ($post['author_name'] ?? '') !== '' ? $post['author_name'] : AUTHOR_NAME;
$previewDate = date('F j, Y', !empty($post['published_at']) ? strtotime($post['published_at']) : time());

$pageTitle = ($post ? 'Edit Post' : 'New Post') . ' | Zibrah Code Admin';
$activeAdminNav = 'posts';
require __DIR__ . '/../includes/admin-header.php';
?>

<div x-data="{ previewMode: false }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 sticky top-0 bg-brand-gray-50/95 backdrop-blur py-4 z-10 -mx-6 md:-mx-12 px-6 md:px-12 border-b border-gray-200">
        <h1 class="font-display font-black text-2xl text-brand-black"><?php echo $post ? 'Edit Post' : 'New Post'; ?></h1>
        <div class="flex flex-wrap items-center gap-3">
            <span id="autosave-status" aria-live="polite" class="text-[11px] font-bold uppercase tracking-widest text-gray-400"></span>
            <div class="flex bg-white border border-gray-200">
                <button type="button" @click="previewMode = false" :class="!previewMode ? 'bg-brand-black text-white' : 'text-gray-500'" class="px-4 sm:px-5 py-2 text-xs font-bold uppercase tracking-widest transition-colors">Edit</button>
                <button type="button" @click="previewMode = true" :class="previewMode ? 'bg-brand-black text-white' : 'text-gray-500'" class="px-4 sm:px-5 py-2 text-xs font-bold uppercase tracking-widest transition-colors">Preview</button>
            </div>
            <select name="status" form="post-form" class="bg-white border border-gray-200 px-4 py-2 text-xs font-bold uppercase tracking-widest focus:outline-none focus:border-brand-gold">
                <option value="draft" <?php echo $form['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                <option value="published" <?php echo $form['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
            </select>
            <button type="submit" form="post-form" class="bg-brand-black text-white px-6 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Save Post</button>
        </div>
    </div>

    <?php if ($draftInfo): ?>
        <div class="mb-8 p-5 bg-amber-50 border border-amber-300 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <p class="text-sm text-amber-900 leading-relaxed">
                <strong class="block mb-1">Unsaved work recovered.</strong>
                You're looking at an autosaved copy from <strong><?php echo e(date('M j, Y \a\t g:i a', strtotime($draftInfo['updated_at']))); ?></strong>.
                Nothing was lost. Press <strong>Save Post</strong> to keep it<?php echo $post ? ', or discard it to return to the saved version.' : '.'; ?>
            </p>
            <button type="button" id="discard-draft-btn" class="flex-shrink-0 text-[10px] font-bold uppercase tracking-widest text-amber-700 hover:text-brand-black border border-amber-300 px-4 py-2 transition-colors">Discard draft</button>
        </div>
    <?php endif; ?>

    <?php if (!$autosaveReady): ?>
        <div class="mb-8 p-5 bg-red-50 border border-red-300">
            <p class="text-sm text-red-800 leading-relaxed">
                <strong class="block mb-1">Server autosave is unavailable.</strong>
                The <code class="font-mono text-xs">post_drafts</code> table is missing, so drafts can't be saved to the
                server. Your work is still being copied into this browser as you type, but don't rely on it —
                save often, and tell your developer to check the site error log.
            </p>
        </div>
    <?php endif; ?>

    <div id="local-restore-bar" class="hidden mb-8 p-5 bg-blue-50 border border-blue-300 flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
        <p class="text-sm text-blue-900 leading-relaxed">
            <strong class="block mb-1">A newer copy exists in this browser.</strong>
            Saved here at <strong id="local-restore-time"></strong>, but the server never received it — most likely the connection dropped.
        </p>
        <div class="flex-shrink-0 flex gap-2">
            <button type="button" id="local-restore-btn" class="text-[10px] font-bold uppercase tracking-widest text-white bg-brand-black hover:bg-brand-gold px-4 py-2 transition-colors">Restore it</button>
            <button type="button" id="local-dismiss-btn" class="text-[10px] font-bold uppercase tracking-widest text-blue-700 hover:text-brand-black border border-blue-300 px-4 py-2 transition-colors">Ignore</button>
        </div>
    </div>

    <?php if ($error): ?><p class="mb-8 p-4 bg-red-50 border border-red-300 text-red-700 text-sm"><?php echo e($error); ?></p><?php endif; ?>

    <!-- EDIT VIEW -->
    <form id="post-form" method="POST" enctype="multipart/form-data" x-show="!previewMode" class="grid lg:grid-cols-3 gap-10">
        <?php echo csrfField(); ?>
        <?php if ($post): ?><input type="hidden" name="id" value="<?php echo $post['id']; ?>"><?php endif; ?>

        <div class="lg:col-span-2 space-y-6">
            <textarea name="title" id="title-input" required rows="1" placeholder="Post title&hellip;"
                class="w-full text-4xl md:text-5xl serif font-black text-brand-black placeholder-gray-300 border-0 border-b-2 border-transparent focus:border-brand-gold focus:outline-none bg-transparent pb-4 transition-colors resize-none overflow-hidden"><?php echo e($form['title']); ?></textarea>

            <div>
                <div id="quill-editor" style="height: 500px;" class="bg-white"></div>
                <textarea name="body" id="body-input" class="hidden"><?php echo e($form['body']); ?></textarea>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Featured Image</label>
                <div class="mt-2">
                    <img id="featured-image-preview" src="<?php echo $form['featured_image_path'] !== '' ? '/' . e($form['featured_image_path']) : ''; ?>" alt="Featured image preview"
                        class="w-full h-auto border border-gray-200 mb-3" style="<?php echo $form['featured_image_path'] === '' ? 'display:none' : ''; ?>">
                    <input type="file" name="featured_image" id="featured-image-input" accept="image/jpeg,image/png,image/webp" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm">
                </div>
            </div>
            <?php
            $presetCategories = ['Framework & Theory', 'Strategic Research', 'Leadership', 'Conflict & Mediation', 'Case Studies', 'Announcements'];
            $currentCategory = $form['category'];
            $isPresetCategory = $currentCategory === '' || in_array($currentCategory, $presetCategories, true);
            ?>
            <div x-data="{ customCategory: <?php echo $isPresetCategory ? 'false' : 'true'; ?> }">
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Category</label>
                <select @change="customCategory = ($event.target.value === '__other__')" :name="customCategory ? null : 'category'" x-show="!customCategory"
                    class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                    <option value="">— None —</option>
                    <?php foreach ($presetCategories as $option): ?>
                        <option value="<?php echo e($option); ?>" <?php echo $currentCategory === $option ? 'selected' : ''; ?>><?php echo e($option); ?></option>
                    <?php endforeach; ?>
                    <option value="__other__" <?php echo !$isPresetCategory ? 'selected' : ''; ?>>Other…</option>
                </select>
                <div x-show="customCategory" x-cloak class="mt-2 flex gap-2">
                    <input type="text" :name="customCategory ? 'category' : null" value="<?php echo e($currentCategory); ?>" placeholder="New category name"
                        class="w-full bg-gray-50 border border-gray-200 px-4 py-3 focus:outline-none focus:border-brand-gold">
                    <button type="button" @click="customCategory = false" class="text-xs font-bold uppercase text-gray-400 hover:text-brand-black flex-shrink-0 px-2">Cancel</button>
                </div>
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Linked Podcast Episode</label>
                <select name="podcast_episode_id" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                    <option value="">— None —</option>
                    <?php foreach ($episodeOptions as $option): ?>
                        <option value="<?php echo $option['id']; ?>" <?php echo (int) $form['podcast_episode_id'] === (int) $option['id'] ? 'selected' : ''; ?>><?php echo e($option['title']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Slug <span class="font-normal normal-case text-gray-400">(auto-generated if blank)</span></label>
                <input type="text" name="slug" value="<?php echo e($form['slug']); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Excerpt</label>
                <textarea name="excerpt" rows="3" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold"><?php echo e($form['excerpt']); ?></textarea>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Meta Description</label>
                    <button type="button" id="generate-meta-btn" class="text-[10px] font-bold uppercase tracking-widest text-brand-gold hover:text-brand-black transition-colors">✦ Generate with AI</button>
                </div>
                <input type="text" name="meta_description" id="meta-description-input" maxlength="300" value="<?php echo e($form['meta_description']); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                <p id="generate-meta-error" class="text-xs text-red-500 mt-2 hidden"></p>
            </div>
        </div>
    </form>

    <!-- PREVIEW VIEW
         A faithful reproduction of post.php's desktop article column. The
         column is pinned to 747px because that is what the live page actually
         resolves to: max-w-7xl (1280) − md:px-16 padding (128) = 1152, split
         into a 3-column grid with two 4rem gaps, of which the article takes two
         columns plus one gap. Matching it means line breaks and image scale in
         the preview land exactly where they will on the published page. -->
    <div x-show="previewMode" x-cloak class="bg-white border border-brand-gray-200 -mx-6 md:-mx-12">
        <div class="px-6 sm:px-10 md:px-16 py-12 md:py-20">
            <div class="mx-auto" style="max-width: 747px">
                <span class="text-[10px] font-black text-brand-gold uppercase tracking-wider">
                    <?php echo e($previewDate); ?> &middot; <span id="preview-readtime">1</span> min read
                </span>
                <h1 id="preview-title" class="text-5xl md:text-6xl serif font-black text-brand-black tracking-tight mt-4 mb-6"><?php echo $form['title'] !== '' ? e($form['title']) : 'Post title…'; ?></h1>

                <div class="flex items-center justify-between mb-10">
                    <p class="text-sm text-brand-gray-500 uppercase tracking-widest">By <?php echo e($previewAuthor); ?></p>
                </div>

                <img id="preview-image" src="<?php echo $form['featured_image_path'] !== '' ? '/' . e($form['featured_image_path']) : ''; ?>" alt="<?php echo e($form['title']); ?>"
                    class="w-full h-auto shadow-2xl mb-8" style="<?php echo $form['featured_image_path'] === '' ? 'display:none' : ''; ?>">

                <!-- The live page's action bar. Inert here — it exists so the
                     rule above the body copy sits at the right rhythm. -->
                <div class="flex items-center gap-8 mb-12 pb-8 border-b border-brand-gray-100 text-brand-gray-500 pointer-events-none select-none" aria-hidden="true">
                    <span class="flex items-center gap-2 text-sm font-bold">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                        0
                    </span>
                    <span class="flex items-center gap-2 text-sm font-bold">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" /></svg>
                        0
                    </span>
                    <span class="flex items-center gap-2 text-sm font-bold ml-auto">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                        Share
                    </span>
                </div>

                <div id="preview-body" class="article-body drop-cap serif text-2xl text-brand-gray-700 leading-relaxed"><?php echo $form['body']; ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Sign back in without losing the page. Shown only when the server tells us
     the session is gone; everything typed stays exactly where it is. -->
<div id="reauth-modal" class="hidden fixed inset-0 z-[100] bg-brand-black/80 items-center justify-center p-6">
    <div class="bg-white w-full max-w-md p-8 sm:p-10 shadow-2xl">
        <h2 class="font-display font-black text-xl text-brand-black mb-2">Session expired</h2>
        <p class="text-sm text-brand-gray-500 mb-6 leading-relaxed">Your writing is safe — nothing has been lost. Sign in again here and you'll carry on from exactly where you are.</p>
        <form id="reauth-form" class="space-y-4">
            <div class="space-y-2">
                <label class="text-xs uppercase tracking-[0.2em] font-bold text-brand-black">Username or Email</label>
                <input type="text" name="username" autocomplete="username" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 focus:outline-none focus:border-brand-gold">
            </div>
            <div class="space-y-2">
                <label class="text-xs uppercase tracking-[0.2em] font-bold text-brand-black">Password</label>
                <input type="password" name="password" autocomplete="current-password" required class="w-full bg-gray-50 border border-gray-200 px-4 py-3 focus:outline-none focus:border-brand-gold">
            </div>
            <p id="reauth-error" class="hidden text-sm text-red-600"></p>
            <button type="submit" class="w-full bg-brand-black text-white py-3.5 text-xs font-bold uppercase tracking-[0.2em] hover:bg-brand-gold transition-colors">Sign in &amp; continue</button>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.js"></script>
<script>
    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                ['blockquote', 'link'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['image'],
                ['clean'],
            ],
        },
    });
    const bodyInput = document.getElementById('body-input');
    const titleInput = document.getElementById('title-input');
    const previewTitle = document.getElementById('preview-title');
    const previewBody = document.getElementById('preview-body');
    const featuredImageInput = document.getElementById('featured-image-input');
    const featuredImagePreview = document.getElementById('featured-image-preview');
    const previewImage = document.getElementById('preview-image');

    quill.root.innerHTML = bodyInput.value;

    const previewReadTime = document.getElementById('preview-readtime');

    function syncPreview() {
        bodyInput.value = quill.root.innerHTML;
        previewBody.innerHTML = quill.root.innerHTML;
        previewTitle.textContent = titleInput.value || 'Post title…';
        // Same formula as post.php: ceil(words / 200), never less than 1.
        const words = quill.getText().trim().split(/\s+/).filter(Boolean).length;
        previewReadTime.textContent = Math.max(1, Math.ceil(words / 200));
    }
    function autoGrowTitle() {
        titleInput.style.height = 'auto';
        titleInput.style.height = titleInput.scrollHeight + 'px';
    }
    quill.on('text-change', syncPreview);
    titleInput.addEventListener('input', () => { autoGrowTitle(); syncPreview(); });
    autoGrowTitle();
    syncPreview(); // so the reading time is right before the first edit

    featuredImageInput.addEventListener('change', () => {
        if (featuredImageInput.files && featuredImageInput.files[0]) {
            const objectUrl = URL.createObjectURL(featuredImageInput.files[0]);
            featuredImagePreview.src = objectUrl;
            featuredImagePreview.style.display = '';
            previewImage.src = objectUrl;
            previewImage.style.display = '';
        }
    });

    // Custom image handler: upload the file, then insert it at the cursor
    // instead of Quill's default "paste an image URL" prompt.
    quill.getModule('toolbar').addHandler('image', () => {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/jpeg,image/png,image/webp');
        input.click();
        input.onchange = async () => {
            const file = input.files[0];
            if (!file) return;
            const formData = new FormData();
            formData.append('image', file);
            formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);
            const range = quill.getSelection(true);
            try {
                const response = await fetch('/admin/posts/upload-image', { method: 'POST', body: formData });
                const data = await response.json();
                if (data.url) {
                    quill.insertEmbed(range.index, 'image', data.url);
                    quill.setSelection(range.index + 1);
                } else {
                    alert(data.error || 'Image upload failed.');
                }
            } catch (e) {
                alert('Image upload failed — please try again.');
            }
        };
    });

    document.getElementById('generate-meta-btn').addEventListener('click', async function () {
        const btn = this;
        const errorEl = document.getElementById('generate-meta-error');
        const metaInput = document.getElementById('meta-description-input');
        const title = titleInput.value.trim();
        const body = quill.getText().trim() || document.querySelector('textarea[name="excerpt"]').value.trim();

        errorEl.classList.add('hidden');
        if (!title) {
            errorEl.textContent = 'Add a title first.';
            errorEl.classList.remove('hidden');
            return;
        }

        const originalText = btn.textContent;
        btn.textContent = 'Generating…';
        btn.disabled = true;

        try {
            const formData = new FormData();
            formData.append('title', title);
            formData.append('body', body);
            formData.append('csrf_token', document.querySelector('meta[name="csrf-token"]').content);
            const response = await fetch('/admin/posts/generate-meta', { method: 'POST', body: formData });
            const data = await response.json();
            if (data.description) {
                metaInput.value = data.description;
            } else {
                errorEl.textContent = data.error || 'Could not generate a description.';
                errorEl.classList.remove('hidden');
            }
        } catch (e) {
            errorEl.textContent = 'Could not reach the AI service — please try again.';
            errorEl.classList.remove('hidden');
        } finally {
            btn.textContent = originalText;
            btn.disabled = false;
        }
    });
</script>

<script>
/**
 * Autosave.
 *
 * Writing a long article used to be a gamble: the editor makes no requests
 * while you type, so the session quietly expired and pressing Save redirected
 * to the login page, taking hours of work with it. Four safety nets now sit
 * under the author, in order of preference:
 *
 *   1. Server autosave — a draft row, written on a pause in typing and at
 *      least every 20 seconds while typing continues.
 *   2. Heartbeat — a cheap ping on idle so the session never goes stale.
 *   3. localStorage — an instant copy that survives a dead network, a closed
 *      laptop, or a browser crash.
 *   4. Inline re-authentication — if the session dies anyway, sign back in
 *      without ever leaving the page.
 *
 * Nothing here can lose text. If every network path fails, the browser copy
 * remains and is offered back on the next visit.
 */
(function () {
    const POST_ID = <?php echo (int) $id; ?>;
    const SERVER_TS = <?php echo (int) $contentTs; ?>;
    const AUTOSAVE_READY = <?php echo $autosaveReady ? 'true' : 'false'; ?>;
    const AUTOSAVE_URL = '/admin/posts/autosave';
    const REAUTH_URL = '/admin/reauth';
    const LS_KEY = 'zibrah_post_draft_' + POST_ID;
    const TRACKED = ['title', 'body', 'excerpt', 'slug', 'category', 'meta_description', 'status', 'podcast_episode_id'];

    const DEBOUNCE_MS = 1500;    // save shortly after typing pauses
    const INTERVAL_MS = 20000;   // ...and regularly even if it never pauses
    const HEARTBEAT_MS = 240000; // keep the session warm while idle

    const form = document.getElementById('post-form');
    const statusEl = document.getElementById('autosave-status');
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const reauthModal = document.getElementById('reauth-modal');

    let dirty = false;
    let saving = false;
    let submitting = false;
    let sessionDead = false;
    let preflightPassed = false;
    let debounceTimer = null;
    let lastSentSnapshot = null;
    let afterReauth = null;

    function field(name) { return document.querySelector('[name="' + name + '"]'); }
    function val(name) { const el = field(name); return el ? el.value : ''; }

    function collect() {
        return {
            title: titleInput.value,
            body: quill.root.innerHTML,
            excerpt: val('excerpt'),
            slug: val('slug'),
            category: val('category'),
            meta_description: val('meta_description'),
            status: val('status'),
            podcast_episode_id: val('podcast_episode_id'),
        };
    }

    function setStatus(text, tone) {
        statusEl.textContent = text;
        statusEl.className = 'text-[11px] font-bold uppercase tracking-widest ' +
            (tone === 'error' ? 'text-red-600' : tone === 'warn' ? 'text-amber-600' : 'text-gray-400');
    }

    function saveLocal(data) {
        try {
            localStorage.setItem(LS_KEY, JSON.stringify({ ts: Math.floor(Date.now() / 1000), data: data }));
        } catch (e) { /* quota or private browsing — the server copy is the primary path */ }
    }
    function clearLocal() {
        try { localStorage.removeItem(LS_KEY); } catch (e) {}
    }

    function payload(data, action) {
        const fd = new FormData();
        fd.append('action', action || 'save');
        fd.append('post_id', POST_ID);
        fd.append('csrf_token', csrfMeta.content);
        if (data) { Object.keys(data).forEach(function (k) { fd.append(k, data[k]); }); }
        return fd;
    }

    async function autosave(data, force) {
        if (!AUTOSAVE_READY) {
            // Server-side drafts are down; the browser copy in flush() is all
            // there is. Say so plainly rather than showing a reassuring "Saved".
            setStatus('Saved in this browser only', 'warn');
            return false;
        }
        if (saving || submitting || sessionDead) { return false; }
        const snap = JSON.stringify(data);
        if (!force && snap === lastSentSnapshot) { dirty = false; return true; }

        saving = true;
        setStatus('Saving…');
        try {
            const res = await fetch(AUTOSAVE_URL, { method: 'POST', body: payload(data), credentials: 'same-origin' });
            if (res.status === 401 || res.status === 403) { sessionExpired(); return false; }
            if (!res.ok) { throw new Error('HTTP ' + res.status); }
            const json = await res.json();
            lastSentSnapshot = snap;
            dirty = false;
            setStatus('Draft saved ' + (json.label || ''));
            return true;
        } catch (e) {
            // Network trouble, not lost work — saveLocal() already ran.
            setStatus('Offline — saved in this browser', 'warn');
            return false;
        } finally {
            saving = false;
        }
    }

    function flush(force) {
        const data = collect();
        saveLocal(data);
        return autosave(data, force);
    }

    function markDirty() {
        dirty = true;
        if (!sessionDead) { setStatus('Unsaved changes…', 'warn'); }
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () { flush(); }, DEBOUNCE_MS);
    }

    function sessionExpired() {
        sessionDead = true;
        saving = false;
        setStatus('Session expired — work saved in this browser', 'error');
        saveLocal(collect());
        reauthModal.classList.remove('hidden');
        reauthModal.classList.add('flex');
        const u = reauthModal.querySelector('[name="username"]');
        if (u) { u.focus(); }
    }

    // --- change tracking ---------------------------------------------------
    // Delegated rather than bound per field, because the category control
    // swaps its name between a <select> and an <input> as Alpine toggles it.
    function isTracked(el) {
        return el && el.name && TRACKED.indexOf(el.name) !== -1 && !reauthModal.contains(el);
    }
    document.addEventListener('input', function (e) { if (isTracked(e.target)) { markDirty(); } });
    document.addEventListener('change', function (e) { if (isTracked(e.target)) { markDirty(); } });
    quill.on('text-change', markDirty);

    setInterval(function () { if (dirty) { flush(); } }, INTERVAL_MS);
    setInterval(async function () {
        if (dirty || sessionDead || saving || submitting || !AUTOSAVE_READY) { return; }
        try {
            const res = await fetch(AUTOSAVE_URL, { method: 'POST', body: payload(null, 'ping'), credentials: 'same-origin' });
            if (res.status === 401 || res.status === 403) { sessionExpired(); }
        } catch (e) { /* transient — the next tick tries again */ }
    }, HEARTBEAT_MS);

    // --- leaving the page --------------------------------------------------
    function beacon() {
        const data = collect();
        saveLocal(data);
        if (sessionDead) { return; }
        try { navigator.sendBeacon(AUTOSAVE_URL, payload(data)); } catch (e) {}
    }
    document.addEventListener('visibilitychange', function () {
        if (document.visibilityState === 'hidden' && dirty) { beacon(); }
    });
    window.addEventListener('pagehide', function () { if (dirty && !submitting) { beacon(); } });
    window.addEventListener('beforeunload', function (e) {
        if (dirty && !submitting) { e.preventDefault(); e.returnValue = ''; }
    });

    // --- saving for real ---------------------------------------------------
    // Check the session is alive *before* handing the browser a POST it would
    // otherwise fire into a redirect that discards the body.
    form.addEventListener('submit', function (e) {
        syncPreview();
        if (preflightPassed) { submitting = true; return; }
        e.preventDefault();
        preflight();
    });
    form.addEventListener('invalid', function () { preflightPassed = false; submitting = false; }, true);

    async function preflight() {
        setStatus('Saving post…');
        const data = collect();
        saveLocal(data);

        let alive = true;
        if (AUTOSAVE_READY) {
            try {
                const res = await fetch(AUTOSAVE_URL, { method: 'POST', body: payload(data), credentials: 'same-origin' });
                // Only an auth failure means "signed out". A 500 here means the
                // draft table is unhappy — that must not block a real save, nor
                // wrongly demand a password from someone who is still signed in.
                alive = !(res.status === 401 || res.status === 403);
            } catch (e) {
                // Can't tell offline from logged-out here; let the real POST
                // decide rather than blocking a save that might well succeed.
                alive = true;
            }
        }

        if (!alive) {
            afterReauth = preflight;
            sessionExpired();
            return;
        }
        preflightPassed = true;
        submitting = true;
        clearLocal();
        if (form.requestSubmit) { form.requestSubmit(); } else { form.submit(); }
    }

    // --- inline re-authentication -----------------------------------------
    document.getElementById('reauth-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const errEl = document.getElementById('reauth-error');
        const btn = this.querySelector('button[type="submit"]');
        const label = btn.textContent;
        errEl.classList.add('hidden');
        btn.disabled = true;
        btn.textContent = 'Signing in…';

        try {
            const res = await fetch(REAUTH_URL, { method: 'POST', body: new FormData(this), credentials: 'same-origin' });
            const json = await res.json();
            if (res.ok && json.ok) {
                // The new session carries a new CSRF token — every form on the
                // page needs it or the next save would fail for a fresh reason.
                csrfMeta.content = json.csrf_token;
                document.querySelectorAll('input[name="csrf_token"]').forEach(function (i) { i.value = json.csrf_token; });
                sessionDead = false;
                lastSentSnapshot = null;
                reauthModal.classList.add('hidden');
                reauthModal.classList.remove('flex');
                this.reset();
                if (afterReauth) {
                    const resume = afterReauth;
                    afterReauth = null;
                    resume();
                } else {
                    flush(true);
                }
            } else {
                errEl.textContent = json.error || 'Sign in failed.';
                errEl.classList.remove('hidden');
            }
        } catch (e) {
            errEl.textContent = 'Could not reach the server — check your connection and try again.';
            errEl.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.textContent = label;
        }
    });

    // --- discard the recovered draft ---------------------------------------
    const discardBtn = document.getElementById('discard-draft-btn');
    if (discardBtn) {
        discardBtn.addEventListener('click', async function () {
            if (!confirm('Discard the recovered draft? The autosaved copy will be deleted and this editor will reload the last saved version.')) { return; }
            discardBtn.disabled = true;
            try { await fetch(AUTOSAVE_URL, { method: 'POST', body: payload(null, 'discard'), credentials: 'same-origin' }); } catch (e) {}
            clearLocal();
            dirty = false;
            submitting = true; // suppress the unsaved-changes prompt on the way out
            window.location.href = POST_ID ? '/admin/posts/edit?id=' + POST_ID : '/admin/posts/edit';
        });
    }

    // --- offer back a browser copy the server never got ---------------------
    (function checkLocalCopy() {
        let saved;
        try {
            const raw = localStorage.getItem(LS_KEY);
            if (!raw) { return; }
            saved = JSON.parse(raw);
        } catch (e) { return; }
        if (!saved || !saved.data) { clearLocal(); return; }

        const current = collect();
        if (saved.data.title === current.title && saved.data.body === current.body) {
            clearLocal(); // the server already has it
            return;
        }
        if (saved.ts <= SERVER_TS + 5) {
            return; // what's on screen is at least as new
        }

        const bar = document.getElementById('local-restore-bar');
        document.getElementById('local-restore-time').textContent = new Date(saved.ts * 1000).toLocaleString();
        bar.classList.remove('hidden');
        bar.classList.add('flex');

        document.getElementById('local-restore-btn').addEventListener('click', function () {
            titleInput.value = saved.data.title || '';
            quill.root.innerHTML = saved.data.body || '';
            ['excerpt', 'slug', 'category', 'meta_description', 'status', 'podcast_episode_id'].forEach(function (n) {
                const el = field(n);
                if (el && typeof saved.data[n] !== 'undefined') { el.value = saved.data[n]; }
            });
            autoGrowTitle();
            syncPreview();
            bar.classList.add('hidden');
            bar.classList.remove('flex');
            markDirty();
        });
        document.getElementById('local-dismiss-btn').addEventListener('click', function () {
            bar.classList.add('hidden');
            bar.classList.remove('flex');
            clearLocal();
        });
    })();

    <?php if ($draftInfo): ?>
    setStatus('Draft recovered', 'warn');
    <?php endif; ?>
})();
</script>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
