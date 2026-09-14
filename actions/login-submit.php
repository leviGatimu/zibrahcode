<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$redirectTarget = safeRedirectPath($_POST['redirect'] ?? null, '/account/index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/login.php');
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$loginIdentifier = 'user:' . strtolower($email);

if (isLoginLocked($loginIdentifier)) {
    flashSet('error', 'Too many failed attempts. Please wait a few minutes and try again.');
    redirectTo('/login.php?redirect=' . urlencode($redirectTarget));
}

$stmt = getDb()->prepare('SELECT id, password_hash FROM users WHERE email = ? AND status = "active"');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password_hash'])) {
    recordLoginFailure($loginIdentifier);
    flashSet('error', 'Incorrect email or password.');
    redirectTo('/login.php?redirect=' . urlencode($redirectTarget));
}

clearLoginFailures($loginIdentifier);
session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
redirectTo($redirectTarget);
