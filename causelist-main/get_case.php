<?php
session_start(); 
require_once 'config/db.php';

$conn = getDB();

$case_no = trim($_GET['case_no'] ?? '');
$case_no = preg_replace('/\s+/', ' ', $case_no);
$court_id = $_SESSION['court_id'] ?? 0;

if ($case_no === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT parties, counsel 
        FROM causelist_db 
        WHERE 
        REPLACE(LOWER(case_no), ' ', '') = REPLACE(LOWER(?), ' ', '')
        AND court_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed']);
    exit;
}

mysqli_stmt_bind_param($stmt, "si", $case_no, $court_id);

if (mysqli_stmt_execute($stmt)) {
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row ?: []);
} else {
    echo json_encode(['error' => 'Query failed']);
}

mysqli_stmt_close($stmt); 
?>