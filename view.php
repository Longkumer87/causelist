<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}
$court = $_SESSION['court_name'];

?>

<?php require 'config/db.php'; ?>
<?php

$date = $_GET['cause_date'] ?? '';
if (empty($date)) {
    header("Location: history.php");
    exit;
}

$sql = "SELECT * FROM `causelist_db` WHERE cause_date='$date' AND court_name='$court_name'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php require "includes/header.php"; ?>

<?php if (empty($rows)): ?>

    <div class="text-center mt-4">
        <h5>No cause list listed</h5>
    </div>

<?php else: ?>

    <div class="container-fluid mt-3">

        <div class="text-center mt-3">
            <img src="image/gov.jpg" alt="Govt Logo" style="max-height: 90px;">
        </div>

        <!-- Header -->
        <div class="text-center mb-3">
            <h6>IN THE COURT OF THE</h6>
            <h5 class="fw-bold">PRINCIPAL DISTRICT & SESSIONS JUDGE</h5>
            <h6>KOHIMA : NAGALAND</h6>
        </div>

        <!-- Date -->
        <h6 class="text-center mb-3">
            CAUSE LIST FOR :
            <?= date("d F Y", strtotime($date)); ?>
        </h6>

        <!-- Buttons -->
        <!-- edit -->
        <div class="row mb-3 g-3 no-print text-center text-md-start">
            <div class="col-12 col-md-4">
                <a href="edit.php?cause_date=<?= $date; ?>" class="btn btn-outline-info w-50">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
            <!-- WhatsApp -->
            <?php require './whatsapp.php'; ?>
            <!-- Print -->
            <div class="col-12 col-md-4 text-md-end">
                <button onclick="window.print()" class="btn btn-outline-dark w-50">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-secondary">
                    <tr>
                        <th class="text-center">S.No</th>
                        <th class="text-center">Case No</th>
                        <th class="text-center col-4">Parties</th>
                        <th class="text-center">Counsel</th>
                        <th class="text-center">Remark</th>
                        <th class="text-center">Next Date</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= htmlspecialchars($row['case_no']); ?></td>
                            <td class="text-break"><?= htmlspecialchars($row['parties']); ?></td>
                            <td><?= htmlspecialchars($row['counsel']); ?></td>
                            <td><?= htmlspecialchars($row['remark']); ?></td>
                            <td>
                                <?= !empty($row['next_date']) && $row['next_date'] !== '0000-00-00'
                                    ? date("d-m-Y", strtotime($row['next_date']))
                                    : ''; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

<?php endif; ?>

<?php require "includes/script.php"; ?>
<?php require "includes/footer.php"; ?>