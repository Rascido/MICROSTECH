<?php
session_start();
require 'koneksi.php';

header('Content-Type: application/json');

// Cek session login
if (!isset($_SESSION['login'])) {
    echo json_encode(['redirect' => 'login.php']);
    exit;
}

// Handle toggle (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $type = $input['type']; // 'lampu' atau 'buzzer'
    $current_val = (int)$input['current_val'];
    $new_val = $current_val == 1 ? 0 : 1;

    // Whitelist kolom untuk keamanan
    if (!in_array($type, ['lampu', 'buzzer'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid type']);
        exit;
    }

    mysqli_query($conn, "UPDATE devices SET $type=$new_val WHERE id=1");
    echo json_encode(['success' => true, $type => $new_val]);
    exit;
}

// Handle GET - ambil status device + username
$result = mysqli_query($conn, "SELECT * FROM devices WHERE id=1");
$device = mysqli_fetch_assoc($result) ?? ['lampu' => 0, 'buzzer' => 0];

echo json_encode([
    'success'  => true,
    'username' => $_SESSION['username'],
    'lampu'    => (int)$device['lampu'],
    'buzzer'   => (int)$device['buzzer'],
]);