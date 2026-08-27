<?php require_once 'config/db.php'; ?>
<?php 
$title='causelist';
require_once "includes/header.php"; 
?>

<div class="d-flex flex-column min-vh-100">

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 d-flex justify-content-end align-items-center pe-5"
         style="background: url('image/court.png') no-repeat center center / cover;">

        <?php require_once "includes/login.php"; ?>

    </div>

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center py-2 small">
       All rights reserved &copy; 2026 Designed and Developed by the eCourts Team, District Court Nagaland
    </footer>

</div>

<?php require_once "includes/footer.php"; ?>