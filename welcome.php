<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$court_name = $_SESSION['court_name'] ?? '';
$court_id = $_SESSION['court_id'] ?? 0;

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<?php $title = 'welcome';
require_once "includes/header.php"; ?>
<?php require_once "includes/case.php"; ?>
<?php require_once __DIR__ . '/formTable.php'; ?>
<?php require_once "includes/footer.php"; ?>