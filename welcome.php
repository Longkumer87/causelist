<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header("Location:index.php");
    exit();
}
$court_name = $_SESSION['court_name'] ?? '';

?>

<?php require 'config/db.php';?>
<?php require "includes/header.php"; ?>

<?php require './formTable.php' ?>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>