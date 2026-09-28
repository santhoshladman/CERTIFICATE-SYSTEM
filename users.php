<?php
// ============================================================
// /api/users.php
// GET    /api/users.php               -> list all users
// POST   /api/users.php               -> create a user (JSON body: username, password, name, role)
// POST   /api/users.php?action=sync   -> replace ALL users with the given list (JSON body: {users:[...]})
// PUT    /api/users.php?username=x    -> update a user (JSON body)
// DELETE /api/users.php?username=x    -> delete a user
// ============================================================
require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];

function toClient($row) {
    return [
        'username' => $row['username'],
        'password' => $row['password'], // included so the app's built-in login check keeps working
        'name'     => $row['name'],
        'role'     => $row['role'],
    ];
}

switch ($method) {

    case 'GET':
        $stmt = $pdo->query('SELECT * FROM users ORDER BY id ASC');
        echo json_encode(array_map('toClient', $stmt->fetchAll()));
        break;

    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'sync') {
            $b = getRequestBody();
            $list = $b['users'] ?? [];
            $pdo->beginTransaction();
            try {
                $pdo->exec('DELETE FROM users');
                $stmt = $pdo->prepare('INSERT INTO users (username, password, name, role) VALUES (?,?,?,?)');
                foreach ($list as $u) {
                    $stmt->execute([$u['username'] ?? '', $u['password'] ?? '', $u['name'] ?? '', $u['role'] ?? 'staff']);
                }
                $pdo->commit();
                echo json_encode(['success' => true, 'count' => count($list)]);
            } catch (Exception $e) {
                $pdo->rollBack();
                http_response_code(500);
                echo json_encode(['error' => 'Sync failed: ' . $e->getMessage()]);
            }
            break;
        }
        $b = getRequestBody();
        if (empty($b['username']) || empty($b['password'])) {
            http_response_code(400); echo json_encode(['error' => 'username and password are required']); break;
        }
        $check = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $check->execute([$b['username']]);
        if ($check->fetch()) { http_response_code(409); echo json_encode(['error' => 'Username already exists']); break; }

        $stmt = $pdo->prepare('INSERT INTO users (username, password, name, role) VALUES (?,?,?,?)');
        $stmt->execute([$b['username'], $b['password'], $b['name'] ?? '', $b['role'] ?? 'staff']);
        echo json_encode(['success' => true]);
        break;

    case 'PUT':
        if (!isset($_GET['username'])) { http_response_code(400); echo json_encode(['error' => 'Missing username']); break; }
        $b = getRequestBody();
        if (!empty($b['password'])) {
            $stmt = $pdo->prepare('UPDATE users SET name=?, role=?, password=? WHERE username=?');
            $stmt->execute([$b['name'] ?? '', $b['role'] ?? 'staff', $b['password'], $_GET['username']]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET name=?, role=? WHERE username=?');
            $stmt->execute([$b['name'] ?? '', $b['role'] ?? 'staff', $_GET['username']]);
        }
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        if (!isset($_GET['username'])) { http_response_code(400); echo json_encode(['error' => 'Missing username']); break; }
        $stmt = $pdo->prepare('DELETE FROM users WHERE username = ?');
        $stmt->execute([$_GET['username']]);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}
