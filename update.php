<?php
header('Content-Type: application/json');

$file = __DIR__ . '/data.json';

$id    = trim($_POST['id']    ?? '');
$name  = trim($_POST['name']  ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$event = trim($_POST['event'] ?? '');

// Validation
if (!$id || !$name || !$email || !$phone || !$event) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}
if (!preg_match('/^\d{10}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Phone must be 10 digits.']);
    exit;
}

$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($data)) {
    echo json_encode(['success' => false, 'message' => 'Data file error.']);
    exit;
}

$found = false;
foreach ($data as &$record) {
    if ($record['id'] === $id) {
        $record['name']       = htmlspecialchars($name,  ENT_QUOTES, 'UTF-8');
        $record['email']      = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $record['phone']      = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
        $record['event']      = htmlspecialchars($event, ENT_QUOTES, 'UTF-8');
        $record['updated_at'] = date('Y-m-d H:i:s');
        $found = true;
        break;
    }
}
unset($record);

if (!$found) {
    echo json_encode(['success' => false, 'message' => 'Record not found.']);
    exit;
}

if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) !== false) {
    echo json_encode(['success' => true, 'message' => 'Registration updated.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Could not write to file.']);
}
