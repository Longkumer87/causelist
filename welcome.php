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

<div class="d-flex justify-content-between align-items-center p-2 bg-secondary">    
    <p class="text-light m-0">Court: <?= htmlspecialchars($_SESSION['court_name']?? '');?></p>

    <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Logout</a>
</div>

  <h5 class="fw-bold text-center mt-2"><?= htmlspecialchars($court_name); ?></h5>
<h5 class="text-center">KOHIMA : NAGALAND</h5>
<br>

<?php require './formTable.php' ?>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>