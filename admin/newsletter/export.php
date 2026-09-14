<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

$subscribers = getDb()->query('SELECT email, name, status, source, subscribed_at FROM newsletter_subscribers ORDER BY subscribed_at DESC')->fetchAll();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="newsletter-subscribers-' . date('Y-m-d') . '.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, ['Email', 'Name', 'Status', 'Source', 'Subscribed At']);
foreach ($subscribers as $sub) {
    fputcsv($out, [$sub['email'], $sub['name'], $sub['status'], $sub['source'], $sub['subscribed_at']]);
}
fclose($out);
