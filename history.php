<?php require 'config/db.php';?>
<?php require "includes/header.php"; ?>

<h4 class="text-center">IN THE COURT OF THE</h4>
<h4 class="text-center">PRINCIPAL DISTRICT & SESSIONS JUDGE</h4>
<h4 class="text-center">KOHIMA : NAGALAND</h4>
<hr>


<div class="container mt-4">
    <h4 class="text-center">View Cause List</h4>


<form action="view.php" method="GET">
    <div class="mb-3">
        <label for="cause_date">Select Date</label>
        <input type="date" name="cause_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">View Cause List</button>
</form>
</div>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>