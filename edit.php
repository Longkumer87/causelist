<?php $title="edit";
require_once 'config/db.php';
require_once 'includes/header.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$court_id = $_SESSION['court_id'] ?? '';

$date = $_GET['cause_date'] ?? '';

if (empty($date)) {
    header("Location: history.php");
    exit();
}

$sql = "SELECT * FROM causelist_db WHERE cause_date = ? AND court_id = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    error_log("Query failed: " . mysqli_error($conn));
    die("Something went wrong. Please try again later.");
}
mysqli_stmt_bind_param($stmt, "si", $date, $court_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<nav class="navbar d-flex justify-content-between px-3 shadow-sm" style="background-color:#2f3e46;">

    <!-- Court Name -->
    <span class="navbar-brand fw-bold text-white mb-0">
        <i class="bi bi-building me-1"></i>
        <?= htmlspecialchars($_SESSION['court_name'] ?? ''); ?>
    </span>

    <!-- Middle Buttons -->
    <div class="d-flex gap-2">
        
        <a href="welcome.php" class="btn btn-outline-light btn-sm">
            <i class="bi bi-house"></i> Home
        </a>

        <a href="history.php" class="btn btn-info btn-sm">
            <i class="bi bi-binoculars"></i> View
        </a>

    </div>

    <!-- Logout -->
    <a href="logout.php" class="btn btn-light btn-sm px-3">
        <i class="bi bi-power"></i> Logout
    </a>

</nav>

<div class="container-fluid mt-3">

    <p class="text-center">Edit Cause List : <?= htmlspecialchars($_SESSION['court_name'] ?? '') ?></p>
    <p class="text-center">
        <?= date("d F Y", strtotime($date)); ?>
    </p>

    <form action="save.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="hidden" name="cause_date" value="<?= htmlspecialchars($date); ?>">

            <div class="table-responsive">
        <table class="table table-bordered" id="causeTable">
            <thead class="table-dark">
                <tr>
                    <th>S.No</th>
                    <th>Case No</th>
                    <th>Parties</th>
                    <th>Counsel</th>
                    <th>Remark</th>
                    <th>Next Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <input type="hidden" name="id[]" value="<?= htmlspecialchars($row['id']); ?>">
                        <input type="hidden" name="delete[]" value="0">
                        <td><?= $i++; ?></td>
                        <td>
                            <input type="text" name="case_no[]" class="form-control" value="<?= htmlspecialchars($row['case_no']); ?>">
                        </td>
                        <td>
                            <textarea name="parties[]" class="form-control" style="min-width: 180px;"><?= htmlspecialchars($row['parties']); ?></textarea>
                        </td>
                        <td>
                            <textarea name="consel[]" class="form-control" style="min-width: 180px;"><?= htmlspecialchars($row['counsel']); ?></textarea>
                        </td>
                        <td>
                            <textarea name="remark[]" class="form-control" style="min-width: 180px;"><?= htmlspecialchars($row['remark']); ?></textarea>
                        </td>
                        <td>
                            <input type="date" name="next_date[]" class="form-control" value="<?= htmlspecialchars($row['next_date']); ?>">
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">
                                    <i class="bi bi-file-plus"></i> Add
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="markDelete(this)">
                                    <i class="bi bi-trash3"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>

<div class="text-end mt-3">
    <button type="submit" class="btn btn-success px-4">
        <i class="bi bi-bookmark-check"></i> Submit
    </button>
</div>
</form>

</div>

<?php require 'includes/script.php'; ?>
<?php require "includes/footer.php"; ?>