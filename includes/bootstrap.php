<?php
/**
 * Required at the top of every public and admin page.
 */

// Never leak stack traces/file paths to visitors, regardless of what the
// host's php.ini defaults to — errors are still captured via error_log().
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// config.php must load before the session block below — it defines SESSION_LIFETIME.
require_once __DIR__ . '/../config.php';

// --- Session durability -----------------------------------------------------
// The post editor is a client-side app: an author can type for hours without
// the browser issuing a single request. Under the host's default 24-minute GC
// window the session was already gone by the time they pressed Save, and the
// redirect to the login page threw the whole POST body away with it.
//
// Two changes keep a login alive for a full working day:
//   1. A private save path. On shared hosting every account writes sessions
//      into one shared directory, and any other account's GC sweep deletes our
//      files using *their* (short) gc_maxlifetime. Owning the directory means
//      only our settings apply to our files.
//   2. SESSION_LIFETIME plus a sliding cookie, re-issued on every request, so
//      an active author's clock never runs out.
// The editor also heartbeats (see admin/posts/autosave.php), which keeps the
// session file's mtime fresh so GC never considers it idle in the first place.
if (session_status() === PHP_SESSION_NONE) {
    $cookieSecure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    // Prefer a directory above the web root; fall back to one inside the app if
    // the parent isn't writable (locked down with its own .htaccess either way).
    $sessionDir = null;
    foreach ([dirname(__DIR__, 2) . '/zibrah-storage/sessions', __DIR__ . '/../storage/sessions'] as $candidate) {
        if (!is_dir($candidate)) {
            @mkdir($candidate, 0700, true);
        }
        if (!is_dir($candidate) || !is_writable($candidate)) {
            continue;
        }
        // Session files have no .php extension, so if this directory ever lands
        // inside the web root it must not be servable — a readable sess_* file
        // is a stolen login.
        $guard = $candidate . '/.htaccess';
        if (!file_exists($guard)) {
            @file_put_contents(
                $guard,
                "Require all denied\n<IfModule !mod_authz_core.c>\n    Order allow,deny\n    Deny from all\n</IfModule>\n"
            );
        }
        $sessionDir = $candidate;
        break;
    }
    if ($sessionDir !== null) {
        session_save_path($sessionDir);
        ini_set('session.gc_probability', '1');
        ini_set('session.gc_divisor', '200');
    }

    ini_set('session.gc_maxlifetime', (string) SESSION_LIFETIME);
    ini_set('session.use_strict_mode', '1');

    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => $cookieSecure,
    ]);
    session_start();

    // Sliding expiry: every request pushes the cookie's deadline back, so the
    // clock only runs out after a genuinely idle SESSION_LIFETIME.
    if (session_status() === PHP_SESSION_ACTIVE && isset($_COOKIE[session_name()]) && !headers_sent()) {
        setcookie(session_name(), session_id(), [
            'expires' => time() + SESSION_LIFETIME,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => $cookieSecure,
        ]);
    }
}

if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header("Content-Security-Policy: default-src 'self'; "
        . "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com https://cdn.jsdelivr.net https://www.googletagmanager.com https://*.google-analytics.com; "
        . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; "
        . "font-src 'self' https://fonts.gstatic.com data:; "
        . "img-src 'self' data: https: blob:; "
        . "connect-src 'self' https://*.google-analytics.com https://*.googletagmanager.com; "
        . "frame-ancestors 'self'; object-src 'none'; base-uri 'self';");
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/mailer.php';

// Establish the DB connection now so schema auto-provisioning runs on every request.
getDb();

// Ensure every visitor (logged in or not) has a stable identity for likes —
// must happen before any HTML output.
guestToken();
