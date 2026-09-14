<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$redirectTarget = safeRedirectPath($_POST['redirect'] ?? null, '/account/index.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/register.php');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$newsletterOptIn = isset($_POST['newsletter_opt_in']) ? 1 : 0;

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
    flashSet('error', 'Please provide a name, valid email, and a password of at least 8 characters.');
    redirectTo('/register.php?redirect=' . urlencode($redirectTarget));
}

$db = getDb();
$existsStmt = $db->prepare('SELECT id FROM users WHERE email = ?');
$existsStmt->execute([$email]);
if ($existsStmt->fetch()) {
    flashSet('error', 'An account with that email already exists.');
    redirectTo('/register.php?redirect=' . urlencode($redirectTarget));
}

$stmt = $db->prepare('INSERT INTO users (name, email, password_hash, newsletter_opt_in) VALUES (?, ?, ?, ?)');
$stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $newsletterOptIn]);
$userId = (int) $db->lastInsertId();

if ($newsletterOptIn) {
    $subStmt = $db->prepare(
        'INSERT INTO newsletter_subscribers (email, name, user_id, source) VALUES (?, ?, ?, "registration")
         ON DUPLICATE KEY UPDATE status = "subscribed", unsubscribed_at = NULL'
    );
    $subStmt->execute([$email, $name, $userId]);
}

$welcomeHtml = renderNotificationEmail(
    'Welcome',
    'Welcome to Zibrah Code, ' . $name . '.',
    'Your account is ready. Explore the framework, bookmark your favorite articles, and join the conversation in the comments.',
    SITE_URL . '/assets/images/Front page.png',
    'Go to My Account',
    rtrim(SITE_URL, '/') . '/account/index.php'
);
$welcomeHtml = str_replace('{{UNSUBSCRIBE_URL}}', unsubscribeUrl($email), $welcomeHtml);
sendEmail($email, $name, 'Welcome to Zibrah Code', $welcomeHtml);

session_regenerate_id(true);
$_SESSION['user_id'] = $userId;
flashSet('success', 'Welcome to Zibrah Code.');
redirectTo($redirectTarget);
