<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/contact.php');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flashSet('error', 'Please fill in your name, a valid email, and a message.');
    redirectTo('/contact.php');
}

$db = getDb();

$spamReason = spamGuardCheck('contact', [$name, $subject, $message]);
if ($spamReason === 'rate-limit') {
    flashSet('error', 'Too many messages from this connection. Please wait a few minutes and try again.');
    redirectTo('/contact.php');
}

// Bots re-send the same text from many addresses; a word-for-word repeat of a
// message already received today is never a second person.
if ($spamReason === null) {
    $dupe = $db->prepare('SELECT 1 FROM contact_messages WHERE message = ? AND created_at > (NOW() - INTERVAL 1 DAY) LIMIT 1');
    $dupe->execute([$message]);
    if ($dupe->fetchColumn()) {
        $spamReason = 'duplicate';
    }
}

// Flagged messages are stored as spam rather than dropped: they show under the
// admin's Spam tab until the noon purge, so a person caught by mistake can
// still be rescued. The sender sees the normal thank-you either way — telling
// a bot it was caught only teaches it what to change.
$isSpam = $spamReason !== null;
$stmt = $db->prepare(
    'INSERT INTO contact_messages (name, email, subject, message, ip_address, status, spam_marked_at)
     VALUES (?, ?, ?, ?, ?, ?, IF(? = 1, NOW(), NULL))'
);
$stmt->execute([
    $name,
    $email,
    $subject,
    $message,
    $_SERVER['REMOTE_ADDR'] ?? null,
    $isSpam ? 'spam' : 'new',
    $isSpam ? 1 : 0,
]);
if ($isSpam) {
    error_log(sprintf('spam-guard: contact message #%d flagged (%s) from %s', $db->lastInsertId(), $spamReason, $_SERVER['REMOTE_ADDR'] ?? '?'));
}

flashSet('success', 'Thank you — your message has been received. We will be in touch.');
redirectTo('/contact.php');
