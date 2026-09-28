<?php
require_once __DIR__ . '/config.php';

// This page is just a status/test dashboard — not used by the app itself.
$dbOk = true;
$counts = ['students' => 0, 'reports' => 0, 'users' => 0];
try {
    foreach ($counts as $table => $v) {
        $counts[$table] = (int) $pdo->query("SELECT COUNT(*) FROM $table")->fetchColumn();
    }
} catch (Exception $e) {
    $dbOk = false;
}

header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Certificate System — Backend Status</title>
<style>
  body{ font-family: Arial, sans-serif; max-width:720px; margin:40px auto; padding:0 20px; color:#222; }
  h1{ font-size:22px; }
  .ok{ color:#1a7a3c; font-weight:bold; }
  .fail{ color:#b3261e; font-weight:bold; }
  table{ border-collapse:collapse; width:100%; margin:16px 0; }
  td, th{ border:1px solid #ddd; padding:8px 10px; text-align:left; font-size:14px; }
  th{ background:#f5f5f5; }
  code{ background:#f0f0f0; padding:2px 6px; border-radius:4px; }
  a{ color:#1a5cad; text-decoration:none; }
  a:hover{ text-decoration:underline; }
</style>
</head>
<body>
  <h1>Certificate System — Backend Status</h1>

  <p>Database connection:
    <?php if ($dbOk): ?><span class="ok">Connected ✓</span>
    <?php else: ?><span class="fail">Not connected ✗ — import database.sql in phpMyAdmin first</span>
    <?php endif; ?>
  </p>

  <?php if ($dbOk): ?>
  <table>
    <tr><th>Table</th><th>Rows</th></tr>
    <tr><td>students</td><td><?= $counts['students'] ?></td></tr>
    <tr><td>reports</td><td><?= $counts['reports'] ?></td></tr>
    <tr><td>users</td><td><?= $counts['users'] ?></td></tr>
  </table>
  <?php endif; ?>

  <h2>API Endpoints</h2>
  <table>
    <tr><th>Link</th><th>Method</th><th>What it does</th></tr>
    <tr><td><a href="api/students.php" target="_blank">api/students.php</a></td><td>GET</td><td>List all students</td></tr>
    <tr><td><a href="api/reports.php" target="_blank">api/reports.php</a></td><td>GET</td><td>List all issued certificates</td></tr>
    <tr><td><a href="api/users.php" target="_blank">api/users.php</a></td><td>GET</td><td>List all login accounts</td></tr>
    <tr><td><a href="api/settings.php" target="_blank">api/settings.php</a></td><td>GET</td><td>Get institution settings</td></tr>
    <tr><td>api/auth.php</td><td>POST</td><td>Login (send username + password)</td></tr>
  </table>

  <p style="margin-top:24px; font-size:13px; color:#777;">
    This is just a diagnostics page. Open <a href="index.php">the app itself</a> here:
    <code>http://localhost/cert-backend/</code>
  </p>
</body>
</html>
