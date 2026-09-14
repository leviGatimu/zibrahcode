<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    redirectTo('/admin/contact/index.php');
}

$id = (int) ($_POST['id'] ?? 0);
$status = in_array($_POST['status'] ?? '', ['new', 'read', 'archived', 'spam'], true) ? $_POST['status'] : 'read';

// Stamp the moment it was flagged so the list can show when it will be purged,
// and clear the stamp on the way back out — otherwise a message rescued from
// spam would keep a misleading "deletes at noon" note.
if ($status === 'spam') {
    getDb()->prepare('UPDATE contact_messages SET status = ?, spam_marked_at = NOW() WHERE id = ?')
        ->execute([$status, $id]);
    flashSet('success', 'Marked as spam — it will be deleted automatically at 12:00 PM.');
} else {
    getDb()->prepare('UPDATE contact_messages SET status = ?, spam_marked_at = NULL WHERE id = ?')
        ->execute([$status, $id]);
}

// Keep the admin on the tab they were reading rather than bouncing them back to
// the top of the full list after every click.
$filter = $_POST['filter'] ?? '';
$query = in_array($filter, ['new', 'read', 'archived', 'spam'], true) ? '?filter=' . $filter : '';
redirectTo('/admin/contact/index.php' . $query);
