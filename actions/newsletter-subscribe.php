<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$referer = $_SERVER['HTTP_REFERER'] ?? '/index.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo($referer);
}

$email = trim($_POST['email'] ?? '');
$name = trim($_POST['name'] ?? '');
$source = trim($_POST['source'] ?? 'unknown');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flashSet('error', 'Please enter a valid email address.');
    redirectTo($referer);
}

$user = currentUser();
$stmt = getDb()->prepare(
    'INSERT INTO newsletter_subscribers (email, name, user_id, source) VALUES (?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE status = "subscribed", unsubscribed_at = NULL'
);
$stmt->execute([$email, $name ?: null, $user['id'] ?? null, $source]);

flashSet('success', 'Thank you for subscribing — you\'re on the list.');
redirectTo($referer);
