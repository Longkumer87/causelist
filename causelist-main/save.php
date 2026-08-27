<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'config/db.php';

$conn = getDB();

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
    exit();
}

$court_id = $_SESSION['court_id'] ?? '';
if (empty($court_id)) {
    echo "<script>alert('Session expired. Please login again.'); window.location='index.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cause_date = $_POST["cause_date"] ?? '';
    if (empty($cause_date)) {
        echo "<script>alert('Error: cause date is required'); window.history.back();</script>";
        exit();
    }

    // Prevent backdate
    $today = date('Y-m-d');
    if ($cause_date < $today) {
        echo "<script>alert('Backdate not allowed'); window.history.back();</script>";
        exit();
    }

    // Detect EDIT mode
    $is_edit = isset($_POST['edit_mode']);

    if ($is_edit && $cause_date < $today) {
        echo "<script>alert('Editing past cause list is not allowed.'); window.history.back();</script>";
        exit();
    }

    // Check duplicate on same date
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

    // Get form data

    $case_no   = $_POST["case_no"] ?? [];
    $parties   = $_POST["parties"] ?? [];
    $counsel   = $_POST["counsel"] ?? [];
    $remark    = $_POST["remark"] ?? [];
    $next_date = $_POST["next_date"] ?? [];

    $count = count($case_no);

    if ($count === 0) {
        echo "<script>alert('No case entries to save. Please add at least one row.'); window.history.back();</script>";
        exit();
    }

    for ($i = 0; $i < $count; $i++) {

        $id = $_POST['id'][$i] ?? '';
        $delete = $_POST['delete'][$i] ?? 0;
        $edited_no = $i + 1;

        // Handle deletion FIRST, before any other check
        if ($delete == 1) {
            if (!empty($id)) {
                $sql = "DELETE FROM causelist_db WHERE id=? AND court_id=?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ii", $id, $court_id);
                mysqli_stmt_execute($stmt);
            }
            continue; // skip everything else for this row
        }

        if (empty($case_no[$i])) {
            continue;
        }

        $case  = $case_no[$i];
        $party = $parties[$i];
        $coun  = $counsel[$i];
        $rem   = $remark[$i];
        $next  = !empty($next_date[$i]) ? $next_date[$i] : null;

        //$case_clean = preg_replace('/\s+/', '', strtolower($case));

        // DUPLICATE CHECK
        //     $sql_check = "SELECT id FROM causelist_db 
        // WHERE REPLACE(LOWER(case_no), ' ', '') = ? 
        // AND court_id = ? 
        // AND cause_date = ?";

        //     $stmt_check = mysqli_prepare($conn, $sql_check);
        //     mysqli_stmt_bind_param($stmt_check, "sis", $case_clean, $court_id, $cause_date);
        //     mysqli_stmt_execute($stmt_check);
        //     $result_check = mysqli_stmt_get_result($stmt_check);

        //     if (mysqli_num_rows($result_check) > 0 && empty($id)) {
        //         echo "<script>alert('Duplicate case number already exists for this date!'); window.history.back();</script>";
        //         exit();
        //     }

        // UPDATE
        if (!empty($id)) {
            $sql = "UPDATE causelist_db 
        SET case_no=?, parties=?, counsel=?, remark=?, next_date=?, edited_no=?
        WHERE id=? AND court_id=?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param(
                $stmt,
                "sssssiii",
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
            // INSERT
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
            echo "<script>alert('Database Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
            exit();
        }
    }

    // Save note
    $note = trim($_POST['note'] ?? '');
    if (!empty($note)) {
        $sql_note = "INSERT INTO causelist_note (cause_date, court_id, note) 
                 VALUES (?, ?, ?) 
                 ON DUPLICATE KEY UPDATE note = VALUES(note)";
        $stmt_note = mysqli_prepare($conn, $sql_note);
        mysqli_stmt_bind_param($stmt_note, "sis", $cause_date, $court_id, $note);
        mysqli_stmt_execute($stmt_note);
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
