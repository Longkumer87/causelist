<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['pdf'])) {
    $court_name = $_GET['court_name'] ?? '';
} else {
    $court_name = $_SESSION['court_name'] ?? '';
}
?>


<?php require 'config/db.php'; ?>
<?php

$date = $_GET['cause_date'] ?? '';
if (empty($date)) {
    header("Location: history.php");
    exit;
}

$sql = "SELECT * FROM `causelist_db` WHERE cause_date = ? AND court_name = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    die("Query failed: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, "ss", $date, $court_name);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);



?>

<?php if (!isset($_GET['pdf'])): ?>
    <?php require "includes/header.php"; ?>
<?php endif; ?>

<!-- Navbar - hidden when printing -->
<?php if (!isset($_GET['pdf'])): ?>
    <nav class="navbar no-print px-3 mb-3" style="background: #ccff89e0; border-bottom: 2px solid #6bedc4;">
        <span class="navbar-brand fw-bold">Court: <?= htmlspecialchars($court_name); ?></span>

        <div class="d-flex flex-wrap gap-4 justify-content-center">
            <a href="welcome.php" class="btn btn-outline-secondary btn-sm"><i class="bi bi-house"></i> Home</a>
            <a href="edit.php?cause_date=<?= htmlspecialchars($date); ?>" class="btn btn-outline-info btn-sm"><i class="bi bi-pencil"></i> Edit</a>
            <button onclick="shareWhatsApp('<?= $date ?>', '<?= htmlspecialchars($court_name) ?>')"
                class="btn btn-outline-success btn-sm">
                <i class="bi bi-whatsapp"></i> WhatsApp
            </button>
            <button onclick="window.print()" class="btn btn-outline-dark btn-sm"><i class="bi bi-printer"></i> Print</button>
        </div>

        <a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-power"></i> Logout</a>
    </nav>
<?php endif; ?>

<?php if (empty($rows)): ?>

    <div class="text-center mt-4">
        <h5>No cause list found for this date</h5>
    </div>

<?php else: ?>

    <?php if (isset($_GET['pdf'])): ?>
        <style>
            body {
                font-size: 12px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 5px;
            }
        </style>
    <?php endif; ?>

    <?php if (isset($_GET['pdf'])): ?>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
                text-align: center;
            }

            img {
                display: block;
                margin: 0 auto;
            }

            h5,
            h6 {
                margin: 2px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 6px;
                text-align: center;
            }

            td:nth-child(3) {
                text-align: left;
                /* Parties column */
            }
        </style>
    <?php endif; ?>

    <div class="container-fluid mt-3">

        <div class="text-center mt-3">
            <?php
            $path = 'image/gov.jpg';
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>

            <img src="<?php echo $base64; ?>" style="max-height: 60px;">

        </div>

        <!-- Header -->
        <div class="text-center mb-3">
            <h6>IN THE COURT OF THE</h6>
            <h5 class="fw-bold"><?= strtoupper(htmlspecialchars($court_name)); ?></h5>
            <h6>KOHIMA : NAGALAND</h6>
        </div>

        <!-- Date -->
        <h6 class="text-center mb-3">
            CAUSE LIST FOR :
            <?= date("d F Y", strtotime($date)); ?>
        </h6>

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

        <div style="margin-top: 30px; text-align: right;">
            <strong>Sd/-</strong><br>
            By Order
        </div>

    </div>

<?php endif; ?>

<?php if (!isset($_GET['pdf'])): ?>
    <?php require "includes/script.php"; ?>
    <?php require "includes/footer.php"; ?>
<?php endif; ?>