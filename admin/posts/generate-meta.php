<?php
require_once __DIR__ . '/../includes/admin-auth-check.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrfVerify()) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid request.']);
    exit;
}

$title = trim($_POST['title'] ?? '');
$body = trim($_POST['body'] ?? '');

if ($title === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Add a title first.']);
    exit;
}

$apiKey = getSetting('google_api_key');
if (!$apiKey) {
    http_response_code(400);
    echo json_encode(['error' => 'Add a Google API key in Settings first.']);
    exit;
}

$context = mb_substr(strip_tags($body), 0, 2000);
$prompt = 'Write a concise SEO meta description (maximum 155 characters, one plain sentence, no quotation marks, no hashtags) '
    . 'for a blog post titled "' . $title . '". The post is about: ' . $context;

$payload = json_encode([
    'contents' => [
        ['parts' => [['text' => $prompt]]],
    ],
]);

$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent?key=' . urlencode($apiKey);

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_TIMEOUT => 15,
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($response === false) {
    error_log('Gemini API request failed: ' . $curlError);
    http_response_code(502);
    echo json_encode(['error' => 'Could not reach the AI service — please try again.']);
    exit;
}

$data = json_decode($response, true);

if ($httpCode !== 200) {
    $message = $data['error']['message'] ?? 'The AI service returned an error.';
    error_log('Gemini API error (' . $httpCode . '): ' . $response);
    http_response_code(502);
    echo json_encode(['error' => $message]);
    exit;
}

$text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
if (!$text) {
    error_log('Gemini API returned no usable text: ' . $response);
    http_response_code(502);
    echo json_encode(['error' => 'The AI service did not return a description.']);
    exit;
}

$description = trim($text);
$description = trim($description, "\"'“”\n ");
$description = mb_substr($description, 0, 300);

echo json_encode(['description' => $description]);
