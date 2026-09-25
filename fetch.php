<?php
header('Content-Type: application/json');

$file = __DIR__ . '/data.json';

if (!file_exists($file)) {
    echo json_encode([]);
    exit;
}

$data = json_decode(file_get_contents($file), true);

if (!is_array($data)) {
    echo json_encode([]);
    exit;
}

// Return newest first
echo json_encode(array_reverse($data));
