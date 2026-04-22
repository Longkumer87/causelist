<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$title = "view";
$court_id = $_SESSION['court_id'] ?? '';
$court_name = $_SESSION['court_name'] ?? '';

require "includes/header.php";


if (empty($court_id)) {
    die("Session expired. Please login again.");
}
?>


<!-- Navbar -->
<nav class="navbar d-flex justify-content-between px-3 shadow-sm" style="background-color:#2f3e46;">
    <span class="navbar-brand fs-6 text-white">
        <i class="bi bi-building"></i> <?= htmlspecialchars($court_name); ?>
    </span>

    <div class="d-flex gap-2">
        <a href="welcome.php" class="btn btn-outline-light btn-sm">
            <i class="bi bi-house"></i> Home
        </a>
    </div>

    <a href="logout.php" class="btn btn-danger btn-sm">
        <i class="bi bi-power"></i> Logout
    </a>
</nav>

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
                        <input type="date" name="cause_date"
                            value="<?= htmlspecialchars($_GET['cause_date'] ?? '') ?>"
                            class="form-control" required>
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

<?php require "includes/footer.php"; ?>