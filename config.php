<?php
/**
 * Configuration for Zibrah Code Website
 */

// Site Constants
define('SITE_NAME', 'ZIBRAH CODE™');
define('SITE_TAGLINE', 'The Geometry of Truth and Wisdom Model');
define('SITE_URL', 'https://zibrahcode.com');
define('AUTHOR_NAME', 'Ibrahim Ngugi');

// SEO Meta
define('META_DESCRIPTION', 'The Zibrah Code presents a spatial framework where truth and perception exist as independent dimensions.');

// Amazon Purchase Link
define('AMAZON_URL', 'https://www.amazon.com/Zibrah-Code-Geometry-Truth-Wisdom-ebook/dp/B0GY1MZJNR/'); // User to confirm/update with actual link

// Social Media
define('YOUTUBE_URL', 'https://www.youtube.com/@zibrahcode');
define('X_URL', 'https://x.com/zlbrahcode');

// Assets versioning to bust cache
define('ASSETS_VERSION', '1.0.36');

// How long a login stays valid, in seconds. Deliberately long: authors work in
// the post editor for hours at a stretch without the browser making a single
// request, and the host's 24-minute default was expiring them mid-article.
// See includes/bootstrap.php for how this is enforced despite shared hosting.
define('SESSION_LIFETIME', 12 * 60 * 60);

// Used to sign one-click unsubscribe links (HMAC key — do not share).
define('APP_SECRET', '80b76a90643b74dc24116f225bb4d0d1281e96c0eb4e55f394e66735002190a');

// MySQL Configuration — auto-detects local XAMPP dev vs the live cPanel host by
// looking at the request's Host header, so this same file works unmodified in
// both places (no manual toggling before upload, no risk of shipping the wrong
// credentials).
$httpHost = $_SERVER['HTTP_HOST'] ?? '';
$isLocalDev = str_starts_with($httpHost, '127.0.0.1') || str_starts_with($httpHost, 'localhost');

if ($isLocalDev) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'zibrah_db');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'ybeqkcet_ibrahim');
    define('DB_PASS', '20101910lev!');
    define('DB_NAME', 'ybeqkcet_zibrahcode');
}

// SMTP Configuration — used to notify newsletter subscribers about new posts/episodes.
// Leave SMTP_HOST blank to disable sending.
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_SECURE', 'tls'); // 'tls' or 'ssl'
define('SMTP_USERNAME', 'zibrahcode@gmail.com');
define('SMTP_PASSWORD', 'vnmecajsufewhurq');
define('SMTP_FROM_EMAIL', 'zibrahcode@gmail.com');
define('SMTP_FROM_NAME', 'Zibrah Code');
