<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/inquire.php');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$preferredDate = trim($_POST['preferred_date'] ?? '');
$preferredTime = trim($_POST['preferred_time'] ?? '');
$topic = trim($_POST['topic'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    flashSet('error', 'Please fill in your name and a valid email address.');
    redirectTo('/inquire.php');
}

$stmt = getDb()->prepare(
    'INSERT INTO appointment_requests (name, email, phone, preferred_date, preferred_time, topic, message, ip_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
);
$stmt->execute([
    $name,
    $email,
    $phone !== '' ? $phone : null,
    $preferredDate !== '' ? $preferredDate : null,
    $preferredTime !== '' ? $preferredTime : null,
    $topic !== '' ? $topic : null,
    $message !== '' ? $message : null,
    $_SERVER['REMOTE_ADDR'] ?? null,
]);

flashSet('success', 'Thank you — your inquiry has been received. We will be in touch to confirm a time.');
redirectTo('/inquire.php');
