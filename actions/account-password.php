<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/account/index.php');
}

$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';

$stmt = getDb()->prepare('SELECT password_hash FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
    flashSet('error', 'Current password is incorrect.');
    redirectTo('/account/index.php');
}

if (strlen($newPassword) < 8) {
    flashSet('error', 'New password must be at least 8 characters.');
    redirectTo('/account/index.php');
}

$updateStmt = getDb()->prepare('UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?');
$updateStmt->execute([password_hash($newPassword, PASSWORD_DEFAULT), $_SESSION['user_id']]);

flashSet('success', 'Password updated.');
redirectTo('/account/index.php');
