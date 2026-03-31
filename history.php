<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}
?>

<!-- <?php require 'config/db.php'; ?> --> 
<?php require "includes/header.php"; ?>

<!-- Navbar -->
<div class="d-flex flex-wrap justify-content-between align-items-center px-3 py-2 bg-secondary gap-2">
    <p class="text-light m-0 fw-semibold">
        <i class="bi bi-building me-1"></i> <?= htmlspecialchars($court_name); ?>
    </p>
    <a href="logout.php" class="btn btn-danger btn-sm">
        <i class="bi bi-power"></i> Logout
    </a>
</div>

<!-- Page Header -->
<div class="text-center px-3 mt-4 mb-3">
    <h5 class="fw-bold mb-1"><?= htmlspecialchars($court_name); ?></h5>
    <p class="text-muted mb-1">KOHIMA : NAGALAND</p>
    <h6 class="fw-bold">View Cause List</h6>
    <hr class="mx-auto" style="max-width: 300px;">
</div>

<!-- Form -->
<div class="container px-3 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-5">

            <div class="card shadow-sm border-0 rounded-3 p-4">
                <form action="view.php" method="GET">

                    <div class="mb-4">
                        <label class="form-label fw-bold">SELECT DATE :</label>
                        <input type="date" name="cause_date" class="form-control form-control-lg" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-info btn-lg">
                            <i class="bi bi-binoculars me-2"></i> View Cause List
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>