<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$redirectTarget = safeRedirectPath($_POST['redirect'] ?? null, '/blog.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo($redirectTarget);
}

$user = currentUser();
if (!$user) {
    redirectTo('/login.php?redirect=' . urlencode($redirectTarget));
}

$type = $_POST['type'] ?? '';
$id = (int) ($_POST['id'] ?? 0);
$body = trim($_POST['body'] ?? '');

if (!in_array($type, ['post', 'episode'], true) || $id <= 0 || $body === '') {
    flashSet('error', 'Comment cannot be empty.');
    redirectTo($redirectTarget);
}

$stmt = getDb()->prepare('INSERT INTO comments (commentable_type, commentable_id, user_id, body) VALUES (?, ?, ?, ?)');
$stmt->execute([$type, $id, $user['id'], $body]);

flashSet('success', 'Comment posted.');
redirectTo($redirectTarget);
