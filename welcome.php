<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$court_name = $_SESSION['court_name'] ?? '';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<?php require_once "includes/header.php"; ?>
<?php require_once './formTable.php'; ?>
<?php require_once "includes/script.php"; ?>
<?php require_once "includes/footer.php"; ?>