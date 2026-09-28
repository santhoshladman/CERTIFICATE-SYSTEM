<?php
// ============================================================
// /api/settings.php
// GET  /api/settings.php   -> get the institution settings (single row)
// POST /api/settings.php   -> update settings (JSON body)
// ============================================================
require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];

function toClient($row) {
    return [
        'collegeName'   => $row['college_name'],
        'address'       => $row['address'],
        'approval'      => $row['approval'],
        'phone'         => $row['phone'],
        'email'         => $row['email'],
        'principalName' => $row['principal_name'],
        'principalTitle'=> $row['principal_title'],
        'logoDataUrl'   => $row['logo_data_url'],
        'backupEmail'   => $row['backup_email'],
    ];
}

switch ($method) {

    case 'GET':
        $stmt = $pdo->query('SELECT * FROM settings WHERE id = 1');
        $row = $stmt->fetch();
        echo json_encode($row ? toClient($row) : new stdClass());
        break;

    case 'POST':
        $b = getRequestBody();
        $stmt = $pdo->prepare('UPDATE settings SET
            college_name=?, address=?, approval=?, phone=?, email=?,
            principal_name=?, principal_title=?, logo_data_url=?, backup_email=?
            WHERE id = 1');
        $stmt->execute([
            $b['collegeName'] ?? null, $b['address'] ?? null, $b['approval'] ?? null,
            $b['phone'] ?? null, $b['email'] ?? null, $b['principalName'] ?? null,
            $b['principalTitle'] ?? null, $b['logoDataUrl'] ?? null, $b['backupEmail'] ?? null,
        ]);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}
