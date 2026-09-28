<?php
// ============================================================
// Database connection config — used by every file in /api
// Default values match a fresh XAMPP install (root, no password).
// Change $db_pass here if your MySQL root user has a password.
// ============================================================

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Browsers send an OPTIONS request before PUT/DELETE/POST from JS — just say OK.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$db_host = 'localhost';
$db_name = 'cert_system';
$db_user = 'root';
$db_pass = 'c$e';     // your MySQL/phpMyAdmin password — already set, no editing needed
$db_charset = 'utf8mb4';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed. Did you import database.sql? Details: ' . $e->getMessage()]);
    exit();
}

// Helper: read the JSON body of a POST/PUT request as an associative array
function getRequestBody() {
    $data = json_decode(file_get_contents('php://input'), true);
    return is_array($data) ? $data : [];
}
