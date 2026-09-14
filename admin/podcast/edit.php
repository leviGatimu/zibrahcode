<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$db = getDb();
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$episode = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM podcast_episodes WHERE id = ?');
    $stmt->execute([$id]);
    $episode = $stmt->fetch();
    if (!$episode) {
        flashSet('error', 'Episode not found.');
        redirectTo('/admin/podcast/index.php');
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfVerify()) {
        $error = 'Invalid form submission, please try again.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $slugInput = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $metaDescription = trim($_POST['meta_description'] ?? '');
        $showNotes = $_POST['show_notes'] ?? '';
        $episodeNumber = ($_POST['episode_number'] ?? '') !== '' ? (int) $_POST['episode_number'] : null;
        $seasonNumber = ($_POST['season_number'] ?? '') !== '' ? (int) $_POST['season_number'] : 1;
        $status = ($_POST['status'] ?? '') === 'published' ? 'published' : 'draft';
        $mediaType = ($_POST['media_type'] ?? '') === 'video' ? 'video' : 'audio';

        if ($title === '') {
            $error = 'Title is required.';
        } else {
            $audioPath = $episode['audio_file_path'] ?? null;
            $videoPath = $episode['video_file_path'] ?? null;
            $coverPath = $episode['cover_image_path'] ?? null;

            if ($mediaType === 'audio') {
                if (!empty($_FILES['audio_file']['name'])) {
                    $uploadedAudio = handleAudioUpload($_FILES['audio_file'], 'podcast/audio/' . date('Y'), $title);
                    if ($uploadedAudio) {
                        $audioPath = $uploadedAudio;
                    } else {
                        $error = 'Audio upload failed — please use an MP3 file under 200MB.';
                    }
                } elseif (!$audioPath) {
                    $error = 'An audio file is required for an audio episode.';
                }
            } else {
                if (!empty($_FILES['video_file']['name'])) {
                    $uploadedVideo = handleVideoUpload($_FILES['video_file'], 'podcast/video/' . date('Y'), $title);
                    if ($uploadedVideo) {
                        $videoPath = $uploadedVideo;
                    } else {
                        $error = 'Video upload failed — please use an MP4 file under 500MB.';
                    }
                } elseif (!$videoPath) {
                    $error = 'A video file is required for a video episode.';
                }
            }

            if (!empty($_FILES['cover_image']['name'])) {
                $uploadedCover = handleImageUpload($_FILES['cover_image'], 'podcast/covers', $title);
                if ($uploadedCover) {
                    $coverPath = $uploadedCover;
                }
            }

            if (!$error) {
                $slug = uniqueSlug(slugify($slugInput !== '' ? $slugInput : $title), 'podcast_episodes', $episode['id'] ?? null);
                $publishedAt = $episode['published_at'] ?? null;
                $isNewlyPublished = $status === 'published' && ($episode['status'] ?? '') !== 'published';
                if ($status === 'published' && !$publishedAt) {
                    $publishedAt = date('Y-m-d H:i:s');
                }

                if ($episode) {
                    $stmt = $db->prepare(
                        'UPDATE podcast_episodes SET title=?, slug=?, description=?, meta_description=?, show_notes=?, media_type=?, audio_file_path=?, video_file_path=?, cover_image_path=?, episode_number=?, season_number=?, status=?, published_at=?, updated_at=NOW() WHERE id=?'
                    );
                    $stmt->execute([$title, $slug, $description, $metaDescription, $showNotes, $mediaType, $audioPath, $videoPath, $coverPath, $episodeNumber, $seasonNumber, $status, $publishedAt, $episode['id']]);
                    flashSet('success', 'Episode updated.');
                } else {
                    $stmt = $db->prepare(
                        'INSERT INTO podcast_episodes (title, slug, description, meta_description, show_notes, media_type, audio_file_path, video_file_path, cover_image_path, episode_number, season_number, status, published_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
                    );
                    $stmt->execute([$title, $slug, $description, $metaDescription, $showNotes, $mediaType, $audioPath, $videoPath, $coverPath, $episodeNumber, $seasonNumber, $status, $publishedAt]);
                    flashSet('success', 'Episode created.');
                }

                if ($isNewlyPublished) {
                    $episodeUrl = rtrim(SITE_URL, '/') . '/podcast-episode.php?slug=' . urlencode($slug);
                    $imageUrl = $coverPath ? rtrim(SITE_URL, '/') . '/' . $coverPath : null;
                    $html = renderNotificationEmail(
                        'New Episode',
                        $title,
                        $description !== '' ? $description : 'A new episode is up on the Zibrah Code podcast.',
                        $imageUrl,
                        $mediaType === 'video' ? 'Watch the Episode' : 'Listen to the Episode',
                        $episodeUrl
                    );
                    notifySubscribers('New Episode: ' . $title, $html);
                }

                redirectTo('/admin/podcast/index.php');
            }
        }
    }
}

$pageTitle = ($episode ? 'Edit Episode' : 'New Episode') . ' | Zibrah Code Admin';
$activeAdminNav = 'podcast';
require __DIR__ . '/../includes/admin-header.php';

$currentMediaType = $episode['media_type'] ?? 'audio';
?>

<div x-data="{ previewMode: false, mediaType: <?php echo e(json_encode($currentMediaType)); ?> }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 sticky top-0 bg-brand-gray-50/95 backdrop-blur py-4 z-10 -mx-6 md:-mx-12 px-6 md:px-12 border-b border-gray-200">
        <h1 class="font-display font-black text-2xl text-brand-black"><?php echo $episode ? 'Edit Episode' : 'New Episode'; ?></h1>
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex bg-white border border-gray-200">
                <button type="button" @click="previewMode = false" :class="!previewMode ? 'bg-brand-black text-white' : 'text-gray-500'" class="px-4 sm:px-5 py-2 text-xs font-bold uppercase tracking-widest transition-colors">Edit</button>
                <button type="button" @click="previewMode = true" :class="previewMode ? 'bg-brand-black text-white' : 'text-gray-500'" class="px-4 sm:px-5 py-2 text-xs font-bold uppercase tracking-widest transition-colors">Preview</button>
            </div>
            <select name="status" form="episode-form" class="bg-white border border-gray-200 px-4 py-2 text-xs font-bold uppercase tracking-widest focus:outline-none focus:border-brand-gold">
                <option value="draft" <?php echo ($episode['status'] ?? 'draft') === 'draft' ? 'selected' : ''; ?>>Draft</option>
                <option value="published" <?php echo ($episode['status'] ?? '') === 'published' ? 'selected' : ''; ?>>Published</option>
            </select>
            <button type="submit" form="episode-form" class="bg-brand-black text-white px-6 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Save Episode</button>
        </div>
    </div>

    <?php if ($error): ?><p class="mb-8 p-4 bg-red-50 border border-red-300 text-red-700 text-sm"><?php echo e($error); ?></p><?php endif; ?>

    <!-- EDIT VIEW -->
    <form id="episode-form" method="POST" enctype="multipart/form-data" x-show="!previewMode" class="grid lg:grid-cols-3 gap-10">
        <?php echo csrfField(); ?>
        <?php if ($episode): ?><input type="hidden" name="id" value="<?php echo $episode['id']; ?>"><?php endif; ?>

        <div class="lg:col-span-2 space-y-6">
            <textarea name="title" id="title-input" required rows="1" placeholder="Episode title&hellip;"
                class="w-full text-4xl md:text-5xl serif font-black text-brand-black placeholder-gray-300 border-0 border-b-2 border-transparent focus:border-brand-gold focus:outline-none bg-transparent pb-4 transition-colors resize-none overflow-hidden"><?php echo e($episode['title'] ?? ''); ?></textarea>

            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black block mb-2">Show Notes</label>
                <div id="quill-editor" style="height: 400px;" class="bg-white"></div>
                <textarea name="show_notes" id="body-input" class="hidden"><?php echo e($episode['show_notes'] ?? ''); ?></textarea>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Cover Image</label>
                <div class="mt-2">
                    <img id="cover-image-preview" src="<?php echo !empty($episode['cover_image_path']) ? '/' . e($episode['cover_image_path']) : ''; ?>" alt="Cover image preview"
                        class="w-full h-auto border border-gray-200 mb-3" style="<?php echo empty($episode['cover_image_path']) ? 'display:none' : ''; ?>">
                    <input type="file" name="cover_image" id="cover-image-input" accept="image/jpeg,image/png,image/webp" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm">
                </div>
            </div>

            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black block mb-2">Media Type</label>
                <div class="flex bg-white border border-gray-200">
                    <button type="button" @click="mediaType = 'audio'" :class="mediaType === 'audio' ? 'bg-brand-black text-white' : 'text-gray-500'" class="flex-1 px-4 py-2.5 text-xs font-bold uppercase tracking-widest transition-colors">Audio</button>
                    <button type="button" @click="mediaType = 'video'" :class="mediaType === 'video' ? 'bg-brand-black text-white' : 'text-gray-500'" class="flex-1 px-4 py-2.5 text-xs font-bold uppercase tracking-widest transition-colors">Video</button>
                </div>
                <input type="hidden" name="media_type" :value="mediaType">
            </div>

            <div x-show="mediaType === 'audio'">
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Audio File (MP3)</label>
                <?php if (!empty($episode['audio_file_path'])): ?>
                    <audio controls class="audio-player my-3"><source src="/<?php echo e($episode['audio_file_path']); ?>" type="audio/mpeg"></audio>
                <?php endif; ?>
                <input type="file" name="audio_file" accept="audio/mpeg" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 text-sm">
            </div>
            <div x-show="mediaType === 'video'" x-cloak>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Video File (MP4)</label>
                <?php if (!empty($episode['video_file_path'])): ?>
                    <video controls class="w-full my-3"><source src="/<?php echo e($episode['video_file_path']); ?>" type="video/mp4"></video>
                <?php endif; ?>
                <input type="file" name="video_file" accept="video/mp4" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 text-sm">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Episode #</label>
                    <input type="number" name="episode_number" value="<?php echo e($episode['episode_number'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Season #</label>
                    <input type="number" name="season_number" value="<?php echo e($episode['season_number'] ?? 1); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                </div>
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Slug <span class="font-normal normal-case text-gray-400">(auto-generated if blank)</span></label>
                <input type="text" name="slug" value="<?php echo e($episode['slug'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Description</label>
                <textarea name="description" id="episode-description-input" rows="3" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold"><?php echo e($episode['description'] ?? ''); ?></textarea>
            </div>
            <div>
                <div class="flex items-center justify-between">
                    <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Meta Description</label>
                    <button type="button" id="generate-meta-btn" class="text-[10px] font-bold uppercase tracking-widest text-brand-gold hover:text-brand-black transition-colors">✦ Generate with AI</button>
                </div>
                <input type="text" name="meta_description" id="meta-description-input" maxlength="300" value="<?php echo e($episode['meta_description'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                <p id="generate-meta-error" class="text-xs text-red-500 mt-2 hidden"></p>
            </div>
        </div>
    </form>

    <!-- PREVIEW VIEW — mirrors podcast-episode.php's real markup -->
    <div x-show="previewMode" x-cloak class="bg-white border border-gray-100 max-w-4xl mx-auto">
        <div class="p-10 md:p-20">
            <img id="preview-cover" src="<?php echo !empty($episode['cover_image_path']) ? '/' . e($episode['cover_image_path']) : ''; ?>" alt="<?php echo e($episode['title'] ?? ''); ?>"
                class="w-full h-auto mb-10 shadow-2xl" style="<?php echo empty($episode['cover_image_path']) ? 'display:none' : ''; ?>">
            <h1 id="preview-title" class="text-4xl md:text-6xl serif font-black text-brand-black tracking-tight mb-8"><?php echo e($episode['title'] ?? 'Episode title…'); ?></h1>

            <div class="bg-brand-gray-50 border border-brand-gray-200 p-8 mb-10" x-show="mediaType === 'audio'">
                <audio id="preview-audio" controls class="audio-player" src="<?php echo !empty($episode['audio_file_path']) ? '/' . e($episode['audio_file_path']) : ''; ?>"></audio>
            </div>
            <div class="bg-brand-gray-50 border border-brand-gray-200 p-8 mb-10" x-show="mediaType === 'video'" x-cloak>
                <video id="preview-video" controls class="w-full" src="<?php echo !empty($episode['video_file_path']) ? '/' . e($episode['video_file_path']) : ''; ?>"></video>
            </div>

            <div id="preview-body" class="serif text-xl text-brand-gray-700 leading-relaxed space-y-6"><?php echo $episode['show_notes'] ?? ''; ?></div>
        </div>
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
    const coverImageInput = document.getElementById('cover-image-input');
    const coverImagePreview = document.getElementById('cover-image-preview');
    const previewCover = document.getElementById('preview-cover');

    quill.root.innerHTML = bodyInput.value;

    function syncPreview() {
        bodyInput.value = quill.root.innerHTML;
        previewBody.innerHTML = quill.root.innerHTML;
        previewTitle.textContent = titleInput.value || 'Episode title…';
    }
    function autoGrowTitle() {
        titleInput.style.height = 'auto';
        titleInput.style.height = titleInput.scrollHeight + 'px';
    }
    quill.on('text-change', syncPreview);
    titleInput.addEventListener('input', () => { autoGrowTitle(); syncPreview(); });
    document.getElementById('episode-form').addEventListener('submit', syncPreview);
    autoGrowTitle();

    coverImageInput.addEventListener('change', () => {
        if (coverImageInput.files && coverImageInput.files[0]) {
            const objectUrl = URL.createObjectURL(coverImageInput.files[0]);
            coverImagePreview.src = objectUrl;
            coverImagePreview.style.display = '';
            previewCover.src = objectUrl;
            previewCover.style.display = '';
        }
    });

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
                const response = await fetch('/admin/podcast/upload-image', { method: 'POST', body: formData });
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
        const body = document.getElementById('episode-description-input').value.trim();

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

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
