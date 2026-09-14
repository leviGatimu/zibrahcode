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

// A bot-subscribed address would receive every future post notification, so
// flagged sign-ups are dropped. The visitor sees the normal confirmation.
$spamReason = spamGuardCheck('newsletter', [$name], ['max_per_window' => 5]);
if ($spamReason === 'rate-limit') {
    flashSet('error', 'Too many sign-ups from this connection. Please wait a few minutes and try again.');
    redirectTo($referer);
}
if ($spamReason !== null) {
    error_log(sprintf('spam-guard: newsletter sign-up discarded (%s) from %s', $spamReason, $_SERVER['REMOTE_ADDR'] ?? '?'));
    flashSet('success', "Thank you for subscribing — you're on the list.");
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
