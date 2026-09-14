<?php
require_once __DIR__ . '/../includes/bootstrap.php';
header('Content-Type: application/json');

$type = $_POST['type'] ?? '';
$id = (int) ($_POST['id'] ?? 0);
if (!in_array($type, ['post', 'episode', 'comment'], true) || $id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

if (!csrfVerify()) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

$user = currentUser();
$db = getDb();

if ($user) {
    $existsStmt = $db->prepare('SELECT id FROM likes WHERE user_id = ? AND likeable_type = ? AND likeable_id = ?');
    $existsStmt->execute([$user['id'], $type, $id]);
} else {
    $token = guestToken();
    $existsStmt = $db->prepare('SELECT id FROM likes WHERE guest_token = ? AND likeable_type = ? AND likeable_id = ?');
    $existsStmt->execute([$token, $type, $id]);
}
$existing = $existsStmt->fetch();

if ($existing) {
    $db->prepare('DELETE FROM likes WHERE id = ?')->execute([$existing['id']]);
    $liked = false;
} elseif ($user) {
    $db->prepare('INSERT INTO likes (user_id, likeable_type, likeable_id) VALUES (?, ?, ?)')->execute([$user['id'], $type, $id]);
    $liked = true;
} else {
    $db->prepare('INSERT INTO likes (guest_token, likeable_type, likeable_id) VALUES (?, ?, ?)')->execute([$token, $type, $id]);
    $liked = true;
}

$countStmt = $db->prepare('SELECT COUNT(*) FROM likes WHERE likeable_type = ? AND likeable_id = ?');
$countStmt->execute([$type, $id]);
$count = (int) $countStmt->fetchColumn();

echo json_encode(['liked' => $liked, 'count' => $count]);
