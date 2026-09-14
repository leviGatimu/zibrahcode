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

$stmt = getDb()->prepare(
    'INSERT INTO contact_messages (name, email, subject, message, ip_address) VALUES (?, ?, ?, ?, ?)'
);
$stmt->execute([$name, $email, $subject, $message, $_SERVER['REMOTE_ADDR'] ?? null]);

flashSet('success', 'Thank you — your message has been received. We will be in touch.');
redirectTo('/contact.php');
