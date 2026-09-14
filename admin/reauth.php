<?php
/**
 * Sign back in without leaving the page.
 *
 * When a session dies underneath an open editor, sending the author to
 * /admin/login.php means abandoning everything in the browser's memory. This
 * lets them re-authenticate in place and carry straight on, and hands back a
 * fresh CSRF token so the page they're standing on keeps working.
 *
 * No CSRF token is required to call this — by definition the session that held
 * the token is gone. A same-origin check stands in for it, which is the right
 * trade here: the only thing an off-site page could achieve is logging someone
 * in, and it would need valid admin credentials to do even that.
 */
require_once __DIR__ . '/../includes/bootstrap.php';

header('Content-Type: application/json');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

// Compare hosts rather than full origins. The site sits behind HTTPS
// termination, where REQUEST_SCHEME reports "http" while the browser's Origin
// header says "https" — comparing whole origins would reject a legitimate
// sign-in at precisely the moment the author needs it to work.
$fetchSite = $_SERVER['HTTP_SEC_FETCH_SITE'] ?? '';
$originHost = !empty($_SERVER['HTTP_ORIGIN'])
    ? strtolower((string) parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST))
    : '';
$expectedHost = strtolower(preg_replace('/:\d+$/', '', $_SERVER['HTTP_HOST'] ?? ''));

$sameOrigin = ($fetchSite === '' || $fetchSite === 'same-origin')
    && ($originHost === '' || ($expectedHost !== '' && hash_equals($expectedHost, $originHost)));

if (!$sameOrigin) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

$identifier = 'admin:' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
if (isLoginLocked($identifier)) {
    http_response_code(429);
    echo json_encode(['error' => 'Too many failed attempts. Wait a few minutes and try again.']);
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = getDb()->prepare('SELECT id, password_hash FROM admin_users WHERE username = ? OR email = ?');
$stmt->execute([$username, $username]);
$admin = $stmt->fetch();

if (!$admin || !password_verify($password, $admin['password_hash'])) {
    recordLoginFailure($identifier);
    http_response_code(401);
    echo json_encode(['error' => 'Incorrect username or password.']);
    exit;
}

clearLoginFailures($identifier);
session_regenerate_id(true);
$_SESSION['admin_id'] = $admin['id'];
getDb()->prepare('UPDATE admin_users SET last_login_at = NOW() WHERE id = ?')->execute([$admin['id']]);

echo json_encode(['ok' => true, 'csrf_token' => csrfToken()]);
