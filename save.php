<?php
header('Content-Type: application/json');

$file = __DIR__ . '/data.json';

// Read existing data
$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($data)) $data = [];

// Sanitize inputs
$name  = trim($_POST['name']  ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$event = trim($_POST['event'] ?? '');

// Basic server-side validation
if (!$name || !$email || !$phone || !$event) {
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

// Build new record
$record = [
    'id'    => uniqid('reg_', true),
    'name'  => htmlspecialchars($name,  ENT_QUOTES, 'UTF-8'),
    'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
    'phone' => htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'),
    'event' => htmlspecialchars($event, ENT_QUOTES, 'UTF-8'),
    'created_at' => date('Y-m-d H:i:s'),
];

$data[] = $record;

if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) !== false) {
    echo json_encode(['success' => true, 'message' => 'Registration saved.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Could not write to file. Check permissions.']);
}
