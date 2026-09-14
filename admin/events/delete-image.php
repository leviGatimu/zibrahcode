<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/events/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
$eventId = (int) ($_POST['event_id'] ?? 0);
getDb()->prepare('DELETE FROM event_images WHERE id = ?')->execute([$id]);
redirectTo('/admin/events/edit.php?id=' . $eventId);
?>