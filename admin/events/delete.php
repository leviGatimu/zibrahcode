<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/events/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
getDb()->prepare('DELETE FROM events WHERE id = ?')->execute([$id]);
flashSet('success', 'Event deleted.');
redirectTo('/admin/events/index.php');
?>