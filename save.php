<?php
require 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid request.");
}

$court_id = $_SESSION['court_id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cause_date = $_POST["cause_date"] ?? '';
    if (empty($cause_date)) {
        die("Error: cause date is required");
    }

    // 1️⃣ Prevent backdate
    $today = date('Y-m-d');
    if ($cause_date < $today) {
        echo "<script>alert('Backdate not allowed'); window.history.back();</script>";
        exit();
    }

    // 2️⃣ Prevent duplicate new cause list
    $sql = "SELECT id FROM causelist_db WHERE cause_date=? AND court_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $cause_date, $court_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows > 0) {
        echo "<script>alert('Cause list already exists for this date. Please use EDIT page.'); window.history.back();</script>";
        exit();
    }

    // 3️⃣ Get rows from form
    $case_no   = $_POST["case_no"];
    $parties   = $_POST["parties"];
    $counsel   = $_POST["counsel"];
    $remark    = $_POST["remark"];
    $next_date = $_POST["next_date"];

    $count = count($case_no);

    for ($i = 0; $i < $count; $i++) {

        // 3a️⃣ Skip empty rows
        if (empty($case_no[$i])) {
            continue;
        }

        $case  = $case_no[$i];
        $party = $parties[$i];
        $coun  = $counsel[$i];
        $rem   = $remark[$i];
        $next  = !empty($next_date[$i]) ? $next_date[$i] : null;

        // 3b️⃣ Insert new row
        $sql = "INSERT INTO causelist_db (cause_date, case_no, parties, counsel, remark, next_date, court_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            error_log("Query failed: " . mysqli_error($conn));
            die("Something went wrong. Please try again later.");
        }
        mysqli_stmt_bind_param($stmt, "ssssssi", $cause_date, $case, $party, $coun, $rem, $next, $court_id);
        mysqli_stmt_execute($stmt);
    }

    // 4️⃣ Redirect to view
    header("Location: view.php?cause_date=" . urlencode($cause_date));
    exit();
}
