<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/comments/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
getDb()->prepare('UPDATE comments SET status = "deleted" WHERE id = ?')->execute([$id]);
flashSet('success', 'Comment deleted.');
redirectTo('/admin/comments/index.php');
