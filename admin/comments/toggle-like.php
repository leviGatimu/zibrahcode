<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/comments/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
getDb()->prepare('UPDATE comments SET is_liked_by_admin = NOT is_liked_by_admin WHERE id = ?')->execute([$id]);
redirectTo('/admin/comments/index.php');
