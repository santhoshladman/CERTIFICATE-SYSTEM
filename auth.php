<?php
// ============================================================
// /api/auth.php
// POST /api/auth.php   Body: { "username": "...", "password": "..." }
// Returns the matched user (without password) or a 401 error.
// ============================================================
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

$b = getRequestBody();
$username = $b['username'] ?? '';
$password = $b['password'] ?? '';

$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user || $user['password'] !== $password) {
    http_response_code(401);
    echo json_encode(['error' => 'Invalid username or password']);
    exit();
}

echo json_encode([
    'success'  => true,
    'username' => $user['username'],
    'name'     => $user['name'],
    'role'     => $user['role'],
]);
