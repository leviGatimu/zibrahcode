<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/account/index.php');
}

$name = trim($_POST['name'] ?? '');
if ($name === '') {
    flashSet('error', 'Name cannot be empty.');
    redirectTo('/account/index.php');
}

$user = currentUser();
$avatarPath = $user['avatar_path'] ?? null;
if (!empty($_FILES['avatar']['name'])) {
    $uploadedAvatar = handleImageUpload($_FILES['avatar'], 'users/avatars', (string) $_SESSION['user_id']);
    if ($uploadedAvatar) {
        $avatarPath = $uploadedAvatar;
    } else {
        flashSet('error', 'Profile picture upload failed — please use a JPG, PNG, or WEBP under 5MB.');
        redirectTo('/account/index.php');
    }
}

$stmt = getDb()->prepare('UPDATE users SET name = ?, avatar_path = ?, updated_at = NOW() WHERE id = ?');
$stmt->execute([$name, $avatarPath, $_SESSION['user_id']]);

flashSet('success', 'Profile updated.');
redirectTo('/account/index.php');
