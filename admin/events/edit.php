<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$db = getDb();
$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$event = null;
if ($id) {
    $stmt = $db->prepare('SELECT * FROM events WHERE id = ?');
    $stmt->execute([$id]);
    $event = $stmt->fetch();
    if (!$event) {
        flashSet('error', 'Event not found.');
        redirectTo('/admin/events/index.php');
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrfVerify()) {
        $error = 'Invalid form submission, please try again.';
    } else {
        $title = trim($_POST['title'] ?? '');
        $slugInput = trim($_POST['slug'] ?? '');
        $description = $_POST['description'] ?? '';
        $location = trim($_POST['location'] ?? '');
        $eventDate = trim($_POST['event_date'] ?? '');
        $eventTime = trim($_POST['event_time'] ?? '') ?: null;
        $endDate = trim($_POST['end_date'] ?? '') ?: null;
        $status = ($_POST['status'] ?? '') === 'published' ? 'published' : 'draft';

        if ($title === '') {
            $error = 'Title is required.';
        } elseif ($eventDate === '') {
            $error = 'Event date is required.';
        } else {
            $coverPath = $event['cover_image_path'] ?? null;
            if (!empty($_FILES['cover_image']['name'])) {
                $uploadedCover = handleImageUpload($_FILES['cover_image'], 'events/covers', $title);
                if ($uploadedCover) {
                    $coverPath = $uploadedCover;
                }
            }

            $slug = uniqueSlug(slugify($slugInput !== '' ? $slugInput : $title), 'events', $event['id'] ?? null);

            if ($event) {
                $stmt = $db->prepare(
                    'UPDATE events SET title=?, slug=?, description=?, location=?, event_date=?, event_time=?, end_date=?, cover_image_path=?, status=?, updated_at=NOW() WHERE id=?'
                );
                $stmt->execute([$title, $slug, $description, $location, $eventDate, $eventTime, $endDate, $coverPath, $status, $event['id']]);
                $eventId = $event['id'];
                flashSet('success', 'Event updated.');
            } else {
                $stmt = $db->prepare(
                    'INSERT INTO events (title, slug, description, location, event_date, event_time, end_date, cover_image_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
                );
                $stmt->execute([$title, $slug, $description, $location, $eventDate, $eventTime, $endDate, $coverPath, $status]);
                $eventId = (int) $db->lastInsertId();
                flashSet('success', 'Event created.');
            }

            if (!empty($_FILES['gallery_images']['name'][0])) {
                $galleryStmt = $db->prepare('INSERT INTO event_images (event_id, image_path) VALUES (?, ?)');
                foreach ($_FILES['gallery_images']['name'] as $i => $name) {
                    if ($name === '') {
                        continue;
                    }
                    $file = [
                        'name' => $_FILES['gallery_images']['name'][$i],
                        'type' => $_FILES['gallery_images']['type'][$i],
                        'tmp_name' => $_FILES['gallery_images']['tmp_name'][$i],
                        'error' => $_FILES['gallery_images']['error'][$i],
                        'size' => $_FILES['gallery_images']['size'][$i],
                    ];
                    $uploadedGalleryImage = handleImageUpload($file, 'events/gallery', $title . '-' . $i);
                    if ($uploadedGalleryImage) {
                        $galleryStmt->execute([$eventId, $uploadedGalleryImage]);
                    }
                }
            }

            redirectTo('/admin/events/edit.php?id=' . $eventId);
        }
    }
}

$galleryImages = [];
if ($event) {
    $galleryStmt = $db->prepare('SELECT id, image_path FROM event_images WHERE event_id = ? ORDER BY sort_order, id');
    $galleryStmt->execute([$event['id']]);
    $galleryImages = $galleryStmt->fetchAll();
}

$pageTitle = ($event ? 'Edit Event' : 'New Event') . ' | Zibrah Code Admin';
$activeAdminNav = 'events';
require __DIR__ . '/../includes/admin-header.php';
?>

<div x-data="{ previewMode: false }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 sticky top-0 bg-brand-gray-50/95 backdrop-blur py-4 z-10 -mx-6 md:-mx-12 px-6 md:px-12 border-b border-gray-200">
        <h1 class="font-display font-black text-2xl text-brand-black"><?php echo $event ? 'Edit Event' : 'New Event'; ?></h1>
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex bg-white border border-gray-200">
                <button type="button" @click="previewMode = false" :class="!previewMode ? 'bg-brand-black text-white' : 'text-gray-500'" class="px-4 sm:px-5 py-2 text-xs font-bold uppercase tracking-widest transition-colors">Edit</button>
                <button type="button" @click="previewMode = true" :class="previewMode ? 'bg-brand-black text-white' : 'text-gray-500'" class="px-4 sm:px-5 py-2 text-xs font-bold uppercase tracking-widest transition-colors">Preview</button>
            </div>
            <select name="status" form="event-form" class="bg-white border border-gray-200 px-4 py-2 text-xs font-bold uppercase tracking-widest focus:outline-none focus:border-brand-gold">
                <option value="draft" <?php echo ($event['status'] ?? 'draft') === 'draft' ? 'selected' : ''; ?>>Draft</option>
                <option value="published" <?php echo ($event['status'] ?? '') === 'published' ? 'selected' : ''; ?>>Published</option>
            </select>
            <button type="submit" form="event-form" class="bg-brand-black text-white px-6 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-all">Save Event</button>
        </div>
    </div>

    <?php if ($error): ?><p class="mb-8 p-4 bg-red-50 border border-red-300 text-red-700 text-sm"><?php echo e($error); ?></p><?php endif; ?>

    <!-- EDIT VIEW -->
    <form id="event-form" method="POST" enctype="multipart/form-data" x-show="!previewMode" class="grid lg:grid-cols-3 gap-10">
        <?php echo csrfField(); ?>
        <?php if ($event): ?><input type="hidden" name="id" value="<?php echo $event['id']; ?>"><?php endif; ?>

        <div class="lg:col-span-2 space-y-6">
            <textarea name="title" id="title-input" required rows="1" placeholder="Event title&hellip;"
                class="w-full text-4xl md:text-5xl serif font-black text-brand-black placeholder-gray-300 border-0 border-b-2 border-transparent focus:border-brand-gold focus:outline-none bg-transparent pb-4 transition-colors resize-none overflow-hidden"><?php echo e($event['title'] ?? ''); ?></textarea>

            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black block mb-2">Description</label>
                <div id="quill-editor" style="height: 300px;" class="bg-white"></div>
                <textarea name="description" id="body-input" class="hidden"><?php echo e($event['description'] ?? ''); ?></textarea>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Photo Gallery</label>
                </div>
                <?php if ($galleryImages): ?>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
                        <?php foreach ($galleryImages as $img): ?>
                            <div class="relative group">
                                <img src="/<?php echo e($img['image_path']); ?>" alt="" class="w-full h-24 object-cover border border-gray-200">
                                <button type="submit" form="delete-img-<?php echo $img['id']; ?>" class="absolute top-1 right-1 w-6 h-6 flex items-center justify-center bg-black/70 text-white text-xs hover:bg-red-600 transition-colors">✕</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <input type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/webp" multiple class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm">
                <p class="text-xs text-gray-400 mt-2">Add one or more photos. New photos are added to the gallery when you save — existing photos above aren't affected unless removed.</p>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Cover Image</label>
                <div class="mt-2">
                    <img id="cover-image-preview" src="<?php echo !empty($event['cover_image_path']) ? '/' . e($event['cover_image_path']) : ''; ?>" alt="Cover image preview"
                        class="w-full h-auto border border-gray-200 mb-3" style="<?php echo empty($event['cover_image_path']) ? 'display:none' : ''; ?>">
                    <input type="file" name="cover_image" id="cover-image-input" accept="image/jpeg,image/png,image/webp" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Event Date</label>
                    <input type="date" name="event_date" required value="<?php echo e($event['event_date'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Time <span class="font-normal normal-case text-gray-400">(optional)</span></label>
                    <input type="time" name="event_time" value="<?php echo e($event['event_time'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
                </div>
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">End Date <span class="font-normal normal-case text-gray-400">(optional, for multi-day events)</span></label>
                <input type="date" name="end_date" value="<?php echo e($event['end_date'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Location</label>
                <input type="text" name="location" value="<?php echo e($event['location'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
            <div>
                <label class="text-xs uppercase tracking-widest font-bold text-brand-black">Slug <span class="font-normal normal-case text-gray-400">(auto-generated if blank)</span></label>
                <input type="text" name="slug" value="<?php echo e($event['slug'] ?? ''); ?>" class="w-full bg-gray-50 border border-gray-200 px-4 py-3 mt-2 focus:outline-none focus:border-brand-gold">
            </div>
        </div>
    </form>

    <?php foreach ($galleryImages as $img): ?>
        <form id="delete-img-<?php echo $img['id']; ?>" action="/admin/events/delete-image" method="POST" onsubmit="return confirm('Remove this photo?');" class="hidden">
            <?php echo csrfField(); ?>
            <input type="hidden" name="id" value="<?php echo $img['id']; ?>">
            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
        </form>
    <?php endforeach; ?>

    <!-- PREVIEW VIEW -->
    <div x-show="previewMode" x-cloak class="bg-white border border-gray-100 max-w-4xl mx-auto">
        <div class="p-10 md:p-20">
            <img id="preview-cover" src="<?php echo !empty($event['cover_image_path']) ? '/' . e($event['cover_image_path']) : ''; ?>" alt="<?php echo e($event['title'] ?? ''); ?>"
                class="w-full h-auto mb-10 shadow-2xl" style="<?php echo empty($event['cover_image_path']) ? 'display:none' : ''; ?>">
            <h1 id="preview-title" class="text-4xl md:text-6xl serif font-black text-brand-black tracking-tight mb-8"><?php echo e($event['title'] ?? 'Event title…'); ?></h1>
            <div id="preview-body" class="serif text-xl text-brand-gray-700 leading-relaxed space-y-6"><?php echo $event['description'] ?? ''; ?></div>
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
        previewTitle.textContent = titleInput.value || 'Event title…';
    }
    function autoGrowTitle() {
        titleInput.style.height = 'auto';
        titleInput.style.height = titleInput.scrollHeight + 'px';
    }
    quill.on('text-change', syncPreview);
    titleInput.addEventListener('input', () => { autoGrowTitle(); syncPreview(); });
    document.getElementById('event-form').addEventListener('submit', syncPreview);
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
                const response = await fetch('/admin/events/upload-image', { method: 'POST', body: formData });
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
</script>

<?php require __DIR__ . '/../includes/admin-footer.php'; ?>
