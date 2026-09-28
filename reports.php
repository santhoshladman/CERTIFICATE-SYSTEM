<?php
// ============================================================
// /api/reports.php
// GET    /api/reports.php               -> list all reports (newest first)
// POST   /api/reports.php               -> log a new certificate issue (JSON body)
// POST   /api/reports.php?action=sync   -> replace ALL reports with the given list (JSON body: {reports:[...]})
// DELETE /api/reports.php?id=xxx        -> delete a report entry
// ============================================================
require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];

function toClient($row) {
    return [
        'id'            => $row['id'],
        'type'          => $row['type'],
        'studentId'     => $row['student_id'],
        'studentName'   => $row['student_name'],
        'admissionNo'   => $row['admission_no'],
        'issuedBy'      => $row['issued_by'],
        'issuedByName'  => $row['issued_by_name'],
        'dateOfIssue'   => $row['date_of_issue'],
        'timestamp'     => $row['timestamp'],
    ];
}

switch ($method) {

    case 'GET':
        $stmt = $pdo->query('SELECT * FROM reports ORDER BY timestamp DESC');
        echo json_encode(array_map('toClient', $stmt->fetchAll()));
        break;

    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'sync') {
            $b = getRequestBody();
            $list = $b['reports'] ?? [];
            $pdo->beginTransaction();
            try {
                $pdo->exec('DELETE FROM reports');
                $stmt = $pdo->prepare('INSERT INTO reports
                    (id, type, student_id, student_name, admission_no, issued_by, issued_by_name, date_of_issue, timestamp)
                    VALUES (?,?,?,?,?,?,?,?,?)');
                foreach ($list as $r) {
                    $stmt->execute([
                        $r['id'] ?? uniqid('rep_', true), $r['type'] ?? null, $r['studentId'] ?? null,
                        $r['studentName'] ?? null, $r['admissionNo'] ?? null, $r['issuedBy'] ?? null,
                        $r['issuedByName'] ?? null, $r['dateOfIssue'] ?: null, $r['timestamp'] ?? date('Y-m-d H:i:s'),
                    ]);
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
        $id = $b['id'] ?? uniqid('rep_', true);
        $stmt = $pdo->prepare('INSERT INTO reports
            (id, type, student_id, student_name, admission_no, issued_by, issued_by_name, date_of_issue, timestamp)
            VALUES (?,?,?,?,?,?,?,?,?)');
        $stmt->execute([
            $id, $b['type'] ?? null, $b['studentId'] ?? null, $b['studentName'] ?? null,
            $b['admissionNo'] ?? null, $b['issuedBy'] ?? null, $b['issuedByName'] ?? null,
            $b['dateOfIssue'] ?: null, $b['timestamp'] ?? date('Y-m-d H:i:s'),
        ]);
        echo json_encode(['success' => true, 'id' => $id]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) { http_response_code(400); echo json_encode(['error' => 'Missing id']); break; }
        $stmt = $pdo->prepare('DELETE FROM reports WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}
