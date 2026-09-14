<?php
/**
 * Reader-session and admin-session auth helpers.
 * Two entirely separate session keys so a reader session can never imply admin access.
 */

function currentUser(): ?array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache ?: null;
    }
    if (empty($_SESSION['user_id'])) {
        $cache = false;
        return null;
    }
    $stmt = getDb()->prepare('SELECT id, name, email, avatar_path, newsletter_opt_in FROM users WHERE id = ? AND status = "active"');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $cache = $user ?: false;
    return $cache ?: null;
}

function requireLogin(): void
{
    if (!currentUser()) {
        $redirect = urlencode($_SERVER['REQUEST_URI'] ?? '/');
        redirectTo('/login.php?redirect=' . $redirect);
    }
}

function currentAdmin(): ?array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache ?: null;
    }
    if (empty($_SESSION['admin_id'])) {
        $cache = false;
        return null;
    }
    $stmt = getDb()->prepare('SELECT id, username, email, display_name, avatar_path FROM admin_users WHERE id = ?');
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();
    $cache = $admin ?: false;
    return $cache ?: null;
}

function requireAdmin(): void
{
    if (!currentAdmin()) {
        redirectTo('/admin/login.php');
    }
}
