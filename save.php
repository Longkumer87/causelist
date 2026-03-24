<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$court_name = $_SESSION['court_name'];

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

        if (empty($case_no[$i])) {
            continue;
        }

        $case  = $case_no[$i];
        $party = $parties[$i];
        $coun  = $counsel[$i];
        $rem   = $remark[$i];
        $next  = !empty($next_date[$i]) ? $next_date[$i] : NULL;

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
            mysqli_stmt_bind_param($stmt, "sssssss", $case, $party, $coun, $rem, $next, $id, $court_name);
            mysqli_stmt_execute($stmt);

        } else {

            $sql = "INSERT INTO causelist_db (cause_date, case_no, parties, counsel, remark, next_date, court_name)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $cause_date, $case, $party, $coun, $rem, $next, $court_name);
            mysqli_stmt_execute($stmt);
        }
    }

    header("Location: view.php?cause_date=$cause_date");
    exit();
}
?>