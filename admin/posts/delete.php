<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/posts/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
getDb()->prepare('DELETE FROM posts WHERE id = ?')->execute([$id]);
flashSet('success', 'Post deleted.');
redirectTo('/admin/posts/index.php');
