<?php
/**
 * Shared helper functions used across public pages and admin.
 */

function slugify(string $text): string
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // iconv isn't enabled on every host (confirmed missing on production) — when
    // available it transliterates accented letters (é -> e); when not, accented
    // letters just get dropped by the next regex instead of crashing.
    if (function_exists('iconv')) {
        $transliterated = @iconv('utf-8', 'ASCII//TRANSLIT', $text);
        if ($transliterated !== false) {
            $text = $transliterated;
        }
    }
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return $text !== '' ? $text : 'n-a';
}

function getSetting(string $key, ?string $default = null): ?string
{
    $stmt = getDb()->prepare('SELECT setting_value FROM settings WHERE setting_key = ?');
    $stmt->execute([$key]);
    $value = $stmt->fetchColumn();
    return $value !== false && $value !== null ? $value : $default;
}

function setSetting(string $key, string $value): void
{
    $stmt = getDb()->prepare(
        'INSERT INTO settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW())
         ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()'
    );
    $stmt->execute([$key, $value]);
}

/**
 * Signed one-click unsubscribe link for a subscriber email — no login needed,
 * and the HMAC means nobody can forge a link to unsubscribe someone else.
 */
function unsubscribeUrl(string $email): string
{
    $token = hash_hmac('sha256', strtolower($email), APP_SECRET);
    return rtrim(SITE_URL, '/') . '/actions/unsubscribe.php?email=' . urlencode($email) . '&token=' . $token;
}

function unsubscribeTokenValid(string $email, string $token): bool
{
    $expected = hash_hmac('sha256', strtolower($email), APP_SECRET);
    return hash_equals($expected, $token);
}

/**
 * Appends -2, -3, etc. to $baseSlug until it's unique in $table.slug, so two
 * posts/episodes with the same (or similar) title never collide on save.
 * $excludeId lets an existing row keep its own slug when just re-saving.
 */
function uniqueSlug(string $baseSlug, string $table, ?int $excludeId = null): string
{
    $db = getDb();
    $slug = $baseSlug;
    $suffix = 2;
    while (true) {
        $sql = "SELECT id FROM $table WHERE slug = ?" . ($excludeId ? ' AND id != ?' : '');
        $params = $excludeId ? [$slug, $excludeId] : [$slug];
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        if (!$stmt->fetch()) {
            return $slug;
        }
        $slug = $baseSlug . '-' . $suffix;
        $suffix++;
    }
}

function excerptText(string $html, int $length = 160): string
{
    $text = trim(strip_tags($html));
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '…';
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrfToken()) . '">';
}

function csrfVerify(): bool
{
    $token = $_POST['csrf_token'] ?? '';
    return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Guards against open-redirect: only ever redirect somewhere on this same
 * site. Rejects protocol-relative ("//host/...") and absolute ("https://...")
 * targets, which is how an attacker could otherwise send a user off-site
 * right after they log in via a crafted ?redirect= link.
 */
function safeRedirectPath(?string $path, string $default = '/'): string
{
    if (!$path || $path[0] !== '/' || (isset($path[1]) && $path[1] === '/') || str_contains($path, '://')) {
        return $default;
    }
    return $path;
}

/**
 * Lightweight brute-force guard: blocks further attempts for $lockoutSeconds
 * once $maxAttempts failures happen within $windowSeconds for the same
 * identifier (e.g. "admin:ip" or "user:email"). Call recordLoginFailure()
 * only on a failed attempt; successful logins should not call it.
 */
function isLoginLocked(string $identifier, int $maxAttempts = 5, int $windowSeconds = 300): bool
{
    $stmt = getDb()->prepare('SELECT COUNT(*) FROM login_attempts WHERE identifier = ? AND attempted_at > (NOW() - INTERVAL ? SECOND)');
    $stmt->execute([$identifier, $windowSeconds]);
    return (int) $stmt->fetchColumn() >= $maxAttempts;
}

function recordLoginFailure(string $identifier): void
{
    getDb()->prepare('INSERT INTO login_attempts (identifier, attempted_at) VALUES (?, NOW())')->execute([$identifier]);
}

function clearLoginFailures(string $identifier): void
{
    getDb()->prepare('DELETE FROM login_attempts WHERE identifier = ?')->execute([$identifier]);
}

/**
 * Stable long-lived identity for anonymous visitors (used so likes work
 * without an account). Must be called before any HTML output — bootstrap.php
 * calls it unconditionally on every request so the cookie always exists by
 * the time any page reads it, regardless of where in that page it's needed.
 */
function guestToken(): string
{
    if (!empty($_COOKIE['zibrah_guest'])) {
        return $_COOKIE['zibrah_guest'];
    }
    $token = bin2hex(random_bytes(16));
    $secure = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
    setcookie('zibrah_guest', $token, [
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    $_COOKIE['zibrah_guest'] = $token;
    return $token;
}

function flashSet(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function flashGet(): array
{
    $flashes = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flashes;
}

function redirectTo(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Renders the play/watch badge overlay for a post's linked podcast episode
 * (see includes/episode-player-modal.php for the modal it opens). Returns ''
 * if there's no linked episode or its media file is missing.
 */
function episodeBadgeHtml(?array $episode, string $fallbackCover): string
{
    if (!$episode) {
        return '';
    }
    $mediaType = $episode['media_type'] === 'video' ? 'video' : 'audio';
    $src = $mediaType === 'video' ? ($episode['video_file_path'] ?? null) : ($episode['audio_file_path'] ?? null);
    if (!$src) {
        return '';
    }
    $cover = $episode['cover_image_path'] ?: $fallbackCover;

    return '<button type="button" onclick="openEpisodePlayer(this)"'
        . ' data-media-type="' . e($mediaType) . '"'
        . ' data-src="/' . e($src) . '"'
        . ' data-title="' . e($episode['title']) . '"'
        . ' data-cover="/' . e($cover) . '"'
        . ' class="absolute left-1/2 -translate-x-1/2 -bottom-6 w-14 h-14 rounded-full bg-brand-gold shadow-xl flex items-center justify-center hover:scale-110 transition-transform z-10">'
        . '<svg class="w-6 h-6 text-brand-black ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>'
        . '</button>';
}

/**
 * Validates an uploaded image via getimagesize() (real content check, not just extension).
 * Returns the relative stored path on success, or null on failure.
 */
function handleImageUpload(array $file, string $subDir, string $baseName, int $maxBytes = 5242880): ?string
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > $maxBytes) {
        return null;
    }
    $info = @getimagesize($file['tmp_name']);
    if ($info === false) {
        return null;
    }
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = $info['mime'];
    if (!isset($allowed[$mime])) {
        return null;
    }
    $ext = $allowed[$mime];
    $filename = slugify($baseName) . '-' . time() . '.' . $ext;
    $destDir = __DIR__ . '/../uploads/' . trim($subDir, '/');
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }
    $destPath = $destDir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return null;
    }
    return 'uploads/' . trim($subDir, '/') . '/' . $filename;
}

/**
 * Validates an uploaded audio file via finfo mime-type check (not just extension).
 * Returns the relative stored path on success, or null on failure.
 */
function handleAudioUpload(array $file, string $subDir, string $baseName, int $maxBytes = 209715200): ?string
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > $maxBytes) {
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if ($mime !== 'audio/mpeg' && $mime !== 'audio/mp3') {
        return null;
    }
    $filename = slugify($baseName) . '-' . time() . '.mp3';
    $destDir = __DIR__ . '/../uploads/' . trim($subDir, '/');
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }
    $destPath = $destDir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return null;
    }
    return 'uploads/' . trim($subDir, '/') . '/' . $filename;
}

/**
 * Validates an uploaded video file via finfo mime-type check (not just extension).
 * Returns the relative stored path on success, or null on failure. Note: the
 * 500MB ceiling here is only meaningful if the server's own upload_max_filesize
 * and post_max_size are also large enough — that's a hosting config concern,
 * not something this function can override.
 */
function handleVideoUpload(array $file, string $subDir, string $baseName, int $maxBytes = 524288000): ?string
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > $maxBytes) {
        return null;
    }
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    if ($mime !== 'video/mp4') {
        return null;
    }
    $filename = slugify($baseName) . '-' . time() . '.mp4';
    $destDir = __DIR__ . '/../uploads/' . trim($subDir, '/');
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }
    $destPath = $destDir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return null;
    }
    return 'uploads/' . trim($subDir, '/') . '/' . $filename;
}
