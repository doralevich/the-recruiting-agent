<?php
// The Recruiting Agent discovery-call request, emails to david@apolloclaw.ai
// Delivery via Mandrill (Mailchimp transactional).

header('Content-Type: application/json');
header('Cache-Control: no-store');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'method_not_allowed']);
    exit;
}

$raw = file_get_contents('php://input');
if (strlen($raw) > 20000) {
    http_response_code(413);
    echo json_encode(['error' => 'payload_too_large']);
    exit;
}

$body = json_decode($raw, true);
if (!is_array($body)) {
    http_response_code(400);
    echo json_encode(['error' => 'bad_request']);
    exit;
}

$name      = trim((string)($body['name']      ?? ''));
$email     = trim((string)($body['email']     ?? ''));
$company   = trim((string)($body['company']   ?? ''));
$role      = trim((string)($body['role']      ?? ''));
$challenge = trim((string)($body['challenge'] ?? ''));
$honeypot  = trim((string)($body['hp']        ?? ''));

if ($honeypot !== '') {
    echo json_encode(['ok' => true]);
    exit;
}

if ($name === '' || $email === '' || $company === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'missing_fields']);
    exit;
}

$strip = function ($s) {
    return substr(preg_replace('/[\r\n]+/', ' ', $s), 0, 200);
};

$subject = '[recruitingagent.com] Discovery call request: ' . $strip($name) . ' / ' . $strip($company);

$plain = "Discovery call request from recruitingagent.com\n\n"
       . "Name:     " . $name    . "\n"
       . "Email:    " . $email   . "\n"
       . "Company:  " . $company . "\n"
       . "Role:     " . ($role !== '' ? $role : '(not provided)') . "\n\n"
       . "Decision to improve:\n"
       . ($challenge !== '' ? $challenge : '(not provided)') . "\n\n"
       . "Sent " . gmdate('Y-m-d H:i:s') . " UTC from " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";

// Always log first — lead is never lost even if Mandrill has a hiccup
$logLine = gmdate('Y-m-d H:i:s') . " | " . str_replace("\n", ' / ', $plain) . "\n";
@file_put_contents(__DIR__ . '/form-submissions.log', $logLine, FILE_APPEND | LOCK_EX);

// Send via Mandrill
$apiKey = getenv('MANDRILL_API_KEY');

$payload = json_encode([
    'key' => $apiKey,
    'message' => [
        'text'       => $plain,
        'subject'    => $subject,
        'from_email' => 'david@apolloclaw.ai',
        'from_name'  => 'The Recruiting Agent (recruitingagent.com)',
        'to'         => [['email' => 'david@apolloclaw.ai', 'type' => 'to']],
        'headers'    => ['Reply-To' => $email],
    ],
]);

$ch = curl_init('https://mandrillapp.com/api/1.0/messages/send');
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS     => $payload,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

$ok = ($httpCode >= 200 && $httpCode < 300);

if (!$ok) {
    http_response_code(502);
    echo json_encode(['error' => 'mail_failed', 'logged' => true]);
    exit;
}

// Mandrill returns an array; check status
$result = json_decode($response, true);
$status = $result[0]['status'] ?? '';
if ($status === 'rejected' || $status === 'invalid') {
    http_response_code(502);
    echo json_encode(['error' => 'mail_rejected', 'logged' => true, 'status' => $status]);
    exit;
}

echo json_encode(['ok' => true]);
