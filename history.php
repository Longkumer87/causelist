<?php require 'config/db.php'; ?>
<?php require "includes/header.php"; ?>


<h4 class="text-center mt-4">PRINCIPAL DISTRICT & SESSIONS JUDGE</h4>
<h4 class="text-center">KOHIMA : NAGALAND</h4>
<hr>


<div class="container mt-4">
    <h4 class="text-center mb-4">View Cause List</h4>

    <form action="view.php" method="GET">

        <div class="row mb-3 justify-content-center align-items-center">

            <div class="col-12 col-md-4 text-center">
                <label class="form-label fw-bold">SELECT DATE :</label>
            </div>

            <div class="col-12 col-md-4">
                <input type="date" name="cause_date" class="form-control" required>
            </div>

        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-4">
                <button type="submit" class="btn btn-info w-100">
                    View Cause List
                </button>
            </div>
        </div>

    </form>
</div>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>