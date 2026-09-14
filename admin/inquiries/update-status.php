<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/inquiries/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
$status = in_array($_POST['status'] ?? '', ['new', 'contacted', 'scheduled', 'closed'], true) ? $_POST['status'] : 'new';

getDb()->prepare('UPDATE appointment_requests SET status = ? WHERE id = ?')->execute([$status, $id]);
redirectTo('/admin/inquiries/index.php');
