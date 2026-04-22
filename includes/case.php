<?php

// include_once '../config/db.config';
require_once "./config/db.php";

$sql = "SELECT * FROM case_type;";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$case_types = mysqli_stmt_get_result($stmt);
if (!$stmt) {
    error_log("Query failed: " . mysqli_error($conn));
    die("Something went wrong. Please try again later.");
}