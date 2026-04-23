<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "causelist";

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
    error_log("DB connection failed: " . mysqli_connect_error());
    die("Something went wrong. Please try again later.");
}

mysqli_set_charset($conn, "utf8mb4");
?>
