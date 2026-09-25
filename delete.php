<?php
header('Content-Type: application/json');

$file = __DIR__ . '/data.json';

$id = trim($_POST['id'] ?? '');

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'No ID provided.']);
    exit;
}

$data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($data)) {
    echo json_encode(['success' => false, 'message' => 'Data file error.']);
    exit;
}

$original = count($data);
$data     = array_values(array_filter($data, fn($r) => $r['id'] !== $id));

if (count($data) === $original) {
    echo json_encode(['success' => false, 'message' => 'Record not found.']);
    exit;
}

if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT)) !== false) {
    echo json_encode(['success' => true, 'message' => 'Registration deleted.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Could not write to file.']);
}
