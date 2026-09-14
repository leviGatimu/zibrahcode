<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/podcast/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
getDb()->prepare('DELETE FROM podcast_episodes WHERE id = ?')->execute([$id]);
flashSet('success', 'Episode deleted.');
redirectTo('/admin/podcast/index.php');
