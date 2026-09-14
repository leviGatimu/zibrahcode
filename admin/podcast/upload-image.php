<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

if (empty($_FILES['image'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No image provided.']);
    exit;
}

$path = handleImageUpload($_FILES['image'], 'podcast/inline/' . date('Y/m'), 'inline');

if (!$path) {
    http_response_code(422);
    echo json_encode(['error' => 'Upload failed — please use a JPG, PNG, or WEBP under 5MB.']);
    exit;
}

echo json_encode(['url' => '/' . $path]);
