<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'config/db.php';

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid request.");
}

$court_id = $_SESSION['court_id'] ?? '';
if (empty($court_id)) {
    die("Session expired. Please login again.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cause_date = $_POST["cause_date"] ?? '';
    if (empty($cause_date)) {
        die("Error: cause date is required");
    }

    //  Prevent backdate
    $today = date('Y-m-d');
    if ($cause_date < $today) {
        echo "<script>alert('Backdate not allowed'); window.history.back();</script>";
        exit();
    }

    //  Detect EDIT mode
    $is_edit = isset($_POST['edit_mode']);

    $today = date('Y-m-d');

    if ($is_edit && $cause_date < $today) {
        die("Editing past cause list is not allowed.");
    }

    //  Check duplicate ONLY for NEW
    if (!$is_edit) {
        $sql = "SELECT id FROM causelist_db WHERE cause_date=? AND court_id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $cause_date, $court_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            echo "<script>alert('Cause list already exists. Use EDIT page.'); window.history.back();</script>";
            exit();
        }
    }

    //  Get form data
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
        $next  = !empty($next_date[$i]) ? $next_date[$i] : null;

        $id     = $_POST['id'][$i] ?? '';
        $delete = $_POST['delete'][$i] ?? 0;
        $edited_no = $i + 1;

        //  DELETE
        if ($delete == 1 && !empty($id)) {
            $sql = "DELETE FROM causelist_db WHERE id=? AND court_id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $id, $court_id);
            mysqli_stmt_execute($stmt);
            continue;
        }

        //  UPDATE
        if (!empty($id)) {

            $sql = "UPDATE causelist_db 
        SET case_no=?, parties=?, counsel=?, remark=?, next_date=?, edited_no=?
        WHERE id=? AND court_id=?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                "sssssiis",
                $case,
                $party,
                $coun,
                $rem,
                $next,
                $edited_no,
                $id,
                $court_id
            );
        } else {

            //  INSERT
            $sql = "INSERT INTO causelist_db 
        (cause_date, case_no, parties, counsel, remark, next_date, court_id, edited_no)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                "ssssssii",
                $cause_date,
                $case,
                $party,
                $coun,
                $rem,
                $next,
                $court_id,
                $edited_no
            );
        }

        if (!mysqli_stmt_execute($stmt)) {
            die("Database Error: " . mysqli_error($conn));
        }
    }

    // Auto-generate PDF after saving
    $calledFromSave = true;
    $_GET['cause_date'] = $cause_date;

    ob_start();
    include __DIR__ . '/generate_pdf.php';
    ob_end_clean();

    header("Location: view.php?cause_date=" . urlencode($cause_date));
    exit();
}
