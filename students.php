<?php
// ============================================================
// /api/students.php
// GET    /api/students.php               -> list all students
// GET    /api/students.php?id=xxx        -> get one student
// POST   /api/students.php               -> create a student (JSON body)
// POST   /api/students.php?action=sync   -> replace ALL students with the given list (JSON body: {students:[...]})
// PUT    /api/students.php?id=xxx        -> update a student (JSON body)
// DELETE /api/students.php?id=xxx        -> delete a student
// ============================================================
require_once __DIR__ . '/../config.php';

$method = $_SERVER['REQUEST_METHOD'];

// Convert DB row (snake_case) -> frontend-style keys (camelCase), matching CS_FINAL_frontend.html
function toClient($row) {
    return [
        'id'                => $row['id'],
        'slNo'              => $row['sl_no'],
        'admissionNo'       => $row['admission_no'],
        'umisId'            => $row['umis_id'],
        'regNo'             => $row['reg_no'],
        'name'              => $row['name'],
        'fatherName'        => $row['father_name'],
        'nationality'       => $row['nationality'],
        'religion'          => $row['religion'],
        'communityCaste'    => $row['community_caste'],
        'sex'               => $row['sex'],
        'dob'               => $row['dob'],
        'dateOfAdmission'   => $row['date_of_admission'],
        'medium'            => $row['medium'],
        'classAtLeaving'    => $row['class_at_leaving'],
        'promotion'         => $row['promotion_status'],
        'dateOfLeaving'     => $row['date_of_leaving'],
        'reason'            => $row['reason_for_leaving'],
        'dateOfApplication' => $row['date_of_tc_application'],
        'conduct'           => $row['conduct_character'],
        'dateOfIssue'       => $row['date_of_issue'],
        'currentYear'       => $row['current_year'],
        'branch'            => $row['branch'],
        'acadFrom'          => $row['academic_year_from'],
        'acadTo'            => $row['academic_year_to'],
        'admissionYear'     => $row['admission_year'],
    ];
}

switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $row = $stmt->fetch();
            if (!$row) { http_response_code(404); echo json_encode(['error' => 'Student not found']); break; }
            echo json_encode(toClient($row));
        } else {
            $stmt = $pdo->query('SELECT * FROM students ORDER BY created_at DESC');
            echo json_encode(array_map('toClient', $stmt->fetchAll()));
        }
        break;

    case 'POST':
        if (isset($_GET['action']) && $_GET['action'] === 'sync') {
            $b = getRequestBody();
            $list = $b['students'] ?? [];
            $pdo->beginTransaction();
            try {
                $pdo->exec('DELETE FROM students');
                $stmt = $pdo->prepare('INSERT INTO students
                    (id, sl_no, admission_no, umis_id, reg_no, name, father_name, nationality, religion,
                     community_caste, sex, dob, date_of_admission, medium, class_at_leaving, promotion_status,
                     date_of_leaving, reason_for_leaving, date_of_tc_application, conduct_character, date_of_issue,
                     current_year, branch, academic_year_from, academic_year_to, admission_year)
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                foreach ($list as $s) {
                    $stmt->execute([
                        $s['id'] ?? uniqid('stu_', true), $s['slNo'] ?? null, $s['admissionNo'] ?? null,
                        $s['umisId'] ?? null, $s['regNo'] ?? null, $s['name'] ?? null, $s['fatherName'] ?? null,
                        $s['nationality'] ?? null, $s['religion'] ?? null, $s['communityCaste'] ?? null,
                        $s['sex'] ?? null, $s['dob'] ?: null, $s['dateOfAdmission'] ?: null, $s['medium'] ?? null,
                        $s['classAtLeaving'] ?? null, $s['promotion'] ?? null, $s['dateOfLeaving'] ?: null,
                        $s['reason'] ?? null, $s['dateOfApplication'] ?: null, $s['conduct'] ?? null,
                        $s['dateOfIssue'] ?: null, $s['currentYear'] ?? null, $s['branch'] ?? null,
                        $s['acadFrom'] ?? null, $s['acadTo'] ?? null, $s['admissionYear'] ?? null,
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
        $id = $b['id'] ?? uniqid('stu_', true);
        $stmt = $pdo->prepare('INSERT INTO students
            (id, sl_no, admission_no, umis_id, reg_no, name, father_name, nationality, religion,
             community_caste, sex, dob, date_of_admission, medium, class_at_leaving, promotion_status,
             date_of_leaving, reason_for_leaving, date_of_tc_application, conduct_character, date_of_issue,
             current_year, branch, academic_year_from, academic_year_to, admission_year)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $stmt->execute([
            $id, $b['slNo'] ?? null, $b['admissionNo'] ?? null, $b['umisId'] ?? null, $b['regNo'] ?? null,
            $b['name'] ?? null, $b['fatherName'] ?? null, $b['nationality'] ?? null, $b['religion'] ?? null,
            $b['communityCaste'] ?? null, $b['sex'] ?? null, $b['dob'] ?: null, $b['dateOfAdmission'] ?: null,
            $b['medium'] ?? null, $b['classAtLeaving'] ?? null, $b['promotion'] ?? null,
            $b['dateOfLeaving'] ?: null, $b['reason'] ?? null, $b['dateOfApplication'] ?: null,
            $b['conduct'] ?? null, $b['dateOfIssue'] ?: null, $b['currentYear'] ?? null, $b['branch'] ?? null,
            $b['acadFrom'] ?? null, $b['acadTo'] ?? null, $b['admissionYear'] ?? null,
        ]);
        echo json_encode(['success' => true, 'id' => $id]);
        break;

    case 'PUT':
        if (!isset($_GET['id'])) { http_response_code(400); echo json_encode(['error' => 'Missing id']); break; }
        $b = getRequestBody();
        $stmt = $pdo->prepare('UPDATE students SET
            sl_no=?, admission_no=?, umis_id=?, reg_no=?, name=?, father_name=?, nationality=?, religion=?,
            community_caste=?, sex=?, dob=?, date_of_admission=?, medium=?, class_at_leaving=?, promotion_status=?,
            date_of_leaving=?, reason_for_leaving=?, date_of_tc_application=?, conduct_character=?, date_of_issue=?,
            current_year=?, branch=?, academic_year_from=?, academic_year_to=?, admission_year=?
            WHERE id=?');
        $stmt->execute([
            $b['slNo'] ?? null, $b['admissionNo'] ?? null, $b['umisId'] ?? null, $b['regNo'] ?? null,
            $b['name'] ?? null, $b['fatherName'] ?? null, $b['nationality'] ?? null, $b['religion'] ?? null,
            $b['communityCaste'] ?? null, $b['sex'] ?? null, $b['dob'] ?: null, $b['dateOfAdmission'] ?: null,
            $b['medium'] ?? null, $b['classAtLeaving'] ?? null, $b['promotion'] ?? null,
            $b['dateOfLeaving'] ?: null, $b['reason'] ?? null, $b['dateOfApplication'] ?: null,
            $b['conduct'] ?? null, $b['dateOfIssue'] ?: null, $b['currentYear'] ?? null, $b['branch'] ?? null,
            $b['acadFrom'] ?? null, $b['acadTo'] ?? null, $b['admissionYear'] ?? null,
            $_GET['id'],
        ]);
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) { http_response_code(400); echo json_encode(['error' => 'Missing id']); break; }
        $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}
