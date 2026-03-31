<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid request.");
}

$court_name = $_SESSION['court_name'] ?? '';

require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cause_date = $_POST["cause_date"] ?? '';
    if (empty($cause_date)) {
        die("Error: cause date is required");
    }

    $case_no   = $_POST["case_no"];
    $parties   = $_POST["parties"];
    $counsel   = $_POST["counsel"];
    $remark    = $_POST["remark"];
    $next_date = $_POST["next_date"];

    $count = count($case_no);

    for ($i = 0; $i < $count; $i++) {

        $delete = $_POST['delete'][$i] ?? 0;
        if ($delete == 1 && !empty($_POST['id'][$i])) {

            $id = $_POST['id'][$i];

            $sql = "DELETE FROM causelist_db WHERE id=? AND court_name=?";
            $stmt = mysqli_prepare($conn, $sql);

            if (!$stmt) {
                error_log("Query failed: " . mysqli_error($conn));
                die("Something went wrong. Please try again later.");
            }

            mysqli_stmt_bind_param($stmt, "is", $id, $court_name);
            mysqli_stmt_execute($stmt);

            continue;
        }

        if (empty($case_no[$i])) {
            continue;
        }

        $case  = $case_no[$i];
        $party = $parties[$i];
        $coun  = $counsel[$i];
        $rem   = $remark[$i];
        $next  = !empty($next_date[$i]) ? $next_date[$i] : null;

        if (isset($_POST['id'][$i]) && !empty($_POST['id'][$i])) {
            $id = $_POST['id'][$i];

            $sql = "UPDATE causelist_db SET 
                        case_no=?,
                        parties=?,
                        counsel=?,
                        remark=?,
                        next_date=?
                    WHERE id=? AND court_name=?";

            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                error_log("Query failed: " . mysqli_error($conn));
                die("Something went wrong. Please try again later.");
            }

            mysqli_stmt_bind_param($stmt, "sssssds", $case, $party, $coun, $rem, $next, $id, $court_name);
            mysqli_stmt_execute($stmt);
        } else {

            $sql = "INSERT INTO causelist_db (cause_date, case_no, parties, counsel, remark, next_date, court_name)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            if (!$stmt) {
                error_log("Query failed: " . mysqli_error($conn));
                die("Something went wrong. Please try again later.");
            }
            mysqli_stmt_bind_param($stmt, "sssssss", $cause_date, $case, $party, $coun, $rem, $next, $court_name);
            mysqli_stmt_execute($stmt);
        }
    }

    header("Location: view.php?cause_date=" . urlencode($cause_date));
    exit();

    // header("Location: view.php?cause_date=$cause_date");
    // exit();
}
