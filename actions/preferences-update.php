<?php
require_once __DIR__ . '/../includes/bootstrap.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/account/preferences.php');
}

$user = currentUser();
$optIn = isset($_POST['newsletter_opt_in']) ? 1 : 0;

$db = getDb();
$db->prepare('UPDATE users SET newsletter_opt_in = ?, updated_at = NOW() WHERE id = ?')->execute([$optIn, $user['id']]);

if ($optIn) {
    $stmt = $db->prepare(
        'INSERT INTO newsletter_subscribers (email, name, user_id, source) VALUES (?, ?, ?, "account_preferences")
         ON DUPLICATE KEY UPDATE status = "subscribed", unsubscribed_at = NULL'
    );
    $stmt->execute([$user['email'], $user['name'], $user['id']]);
} else {
    $stmt = $db->prepare('UPDATE newsletter_subscribers SET status = "unsubscribed", unsubscribed_at = NOW() WHERE email = ?');
    $stmt->execute([$user['email']]);
}

flashSet('success', 'Preferences saved.');
redirectTo('/account/preferences.php');
