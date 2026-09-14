<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');

$user = currentUser();
if (!$user) {
    echo json_encode(['redirect' => '/login.php?redirect=' . urlencode($_SERVER['HTTP_REFERER'] ?? '/')]);
    exit;
}

if (!csrfVerify()) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

$type = $_POST['type'] ?? '';
$id = (int) ($_POST['id'] ?? 0);
if (!in_array($type, ['post', 'episode'], true) || $id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$db = getDb();
$existsStmt = $db->prepare('SELECT id FROM bookmarks WHERE user_id = ? AND bookmarkable_type = ? AND bookmarkable_id = ?');
$existsStmt->execute([$user['id'], $type, $id]);
$existing = $existsStmt->fetch();

if ($existing) {
    $db->prepare('DELETE FROM bookmarks WHERE id = ?')->execute([$existing['id']]);
    echo json_encode(['bookmarked' => false]);
} else {
    $db->prepare('INSERT INTO bookmarks (user_id, bookmarkable_type, bookmarkable_id) VALUES (?, ?, ?)')->execute([$user['id'], $type, $id]);
    echo json_encode(['bookmarked' => true]);
}
