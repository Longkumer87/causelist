<?php require 'config/db.php';?>
<?php require "includes/header.php"; ?>

<?php 
    
    $sql = "SELECT * FROM causelist";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

?>

<h4 class="text-center">PRINCIPAL DISTRICT & SESSIONS JUDGE</h4>
<h4 class="text-center">KOHIMA : NAGALAND</h4>
<br>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>