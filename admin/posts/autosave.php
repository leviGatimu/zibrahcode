<?php
/**
 * Autosave endpoint for the post editor.
 *
 * Note this deliberately does NOT use admin-auth-check.php: requireAdmin()
 * answers an expired session with a 302 to the login page, and an XHR that
 * follows a redirect to an HTML page is indistinguishable from success. The
 * editor needs an unambiguous 401 so it can put up the re-authentication
 * prompt instead of silently believing the work was saved.
 *
 * Actions:
 *   save    — upsert the draft (default)
 *   ping    — keep-alive; touches the session so GC never sees it as idle
 *   discard — drop the draft and go back to the saved version
 */
require_once __DIR__ . '/../../includes/bootstrap.php';

header('Content-Type: application/json');
header('Cache-Control: no-store');

$admin = currentAdmin();
if (!$admin) {
    http_response_code(401);
    echo json_encode(['error' => 'Your session expired. Sign in again to keep saving.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

$action = $_POST['action'] ?? 'save';
$postId = max(0, (int) ($_POST['post_id'] ?? 0));
$db = getDb();

if ($action === 'ping') {
    // The session read above already refreshed the session file's mtime, which
    // is the entire point of this branch.
    echo json_encode(['ok' => true]);
    exit;
}

// Every draft query below is wrapped: if the post_drafts table is missing or
// unhappy, answer with a clear 500 rather than an uncaught exception. The
// editor reads that as "fall back to the browser copy and say so" — crucially
// not as "signed out", which would wrongly demand a password mid-article.
try {

if ($action === 'discard') {
    $db->prepare('DELETE FROM post_drafts WHERE admin_id = ? AND post_id = ?')->execute([$admin['id'], $postId]);
    echo json_encode(['ok' => true]);
    exit;
}

$title = trim($_POST['title'] ?? '');
$body = $_POST['body'] ?? '';

// Quill leaves an empty editor as "<p><br></p>" — treat that as nothing typed,
// so simply opening the editor and closing it never leaves a phantom draft
// waiting to interrupt the next session with a recovery banner.
$bodyIsEmpty = trim(strip_tags($body, '<img><iframe>')) === '';

if ($title === '' && $bodyIsEmpty) {
    $db->prepare('DELETE FROM post_drafts WHERE admin_id = ? AND post_id = ?')->execute([$admin['id'], $postId]);
    echo json_encode(['ok' => true, 'empty' => true]);
    exit;
}

$episodeId = ($_POST['podcast_episode_id'] ?? '') !== '' ? (int) $_POST['podcast_episode_id'] : null;

$stmt = $db->prepare(
    'INSERT INTO post_drafts
        (admin_id, post_id, title, slug, excerpt, body, category, meta_description, status, podcast_episode_id, updated_at)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
     ON DUPLICATE KEY UPDATE
        title = VALUES(title),
        slug = VALUES(slug),
        excerpt = VALUES(excerpt),
        body = VALUES(body),
        category = VALUES(category),
        meta_description = VALUES(meta_description),
        status = VALUES(status),
        podcast_episode_id = VALUES(podcast_episode_id),
        updated_at = NOW()'
);

$stmt->execute([
    $admin['id'],
    $postId,
    mb_substr($title, 0, 255),
    mb_substr(trim($_POST['slug'] ?? ''), 0, 255),
    $_POST['excerpt'] ?? '',
    $body,
    mb_substr(trim($_POST['category'] ?? ''), 0, 100),
    mb_substr(trim($_POST['meta_description'] ?? ''), 0, 300),
    ($_POST['status'] ?? '') === 'published' ? 'published' : 'draft',
    $episodeId,
]);
echo json_encode(['ok' => true, 'label' => date('g:i a')]);

} catch (PDOException $e) {
    error_log('Autosave storage unavailable (post_drafts): ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Autosave storage is unavailable.']);
    exit;
}
