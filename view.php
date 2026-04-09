<?php $title = "causelist";
require_once 'config/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['pdf'])) {
    $court_name = $_SESSION['court_name'] ?? '';
    $court_id = $_SESSION['court_id'] ?? '';
} else {
    $court_name = $_SESSION['court_name'] ?? '';
    $court_id = $_SESSION['court_id'] ?? '';
}

//title bar code 
$title = "causelist - " . $court_name;
?>

<?php

$date = $_GET['cause_date'] ?? '';
if (empty($date)) {
    header("Location: history.php");
    exit;
}

$sql = "SELECT * FROM `causelist_db` WHERE cause_date = ? AND court_id = ?";
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

<?php if (!isset($_GET['pdf'])): ?>
    <?php require "includes/header.php"; ?>
<?php endif; ?>

<!-- Navbar - hidden when printing -->
<?php if (!isset($_GET['pdf'])): ?>

    <nav class="navbar flex-wrap d-flex justify-content-between px-3 shadow-sm no-print" style="background-color:#2f3e46;">

        <!-- Court Name -->
        <span class="navbar-brand fw-bold text-white mb-0">
            <i class="bi bi-building me-1"></i>
            <?= htmlspecialchars($court_name); ?>
        </span>

        <!-- Middle Buttons -->
        <div class="d-flex gap-2">

            <a href="welcome.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-house"></i> Home
            </a>

            <a href="edit.php?cause_date=<?= htmlspecialchars($date); ?>"
                class="btn btn-outline-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit
            </a>

            <!-- WhatsApp (Green) -->
            <button onclick="shareWhatsApp('<?= $date ?>', '<?= htmlspecialchars($court_name) ?>')"
                class="btn btn-outline-success btn-sm">
                <i class="bi bi-whatsapp"></i> WhatsApp
            </button>

            <!-- Print (Dark) -->
            <button onclick="window.print()"
                class="btn btn-dark btn-sm">
                <i class="bi bi-printer"></i> Print
            </button>

        </div>

        <!-- Logout -->
        <a href="logout.php" class="btn btn-danger btn-sm px-3">
            <i class="bi bi-power"></i> Logout
        </a>

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
                font-family: Tahoma, Arial, sans-serif;
                font-size: 10px;
                text-align: center;
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

            img {
                display: block;
                margin: 0 auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            td:nth-child(3) {
                text-align: left;
               
            }
        </style>
    <?php endif; ?>

    <div class="container">
        <?php
        // Government Emblem (gov.png)
        $govPath = 'image/gov.png';
        $govType = pathinfo($govPath, PATHINFO_EXTENSION);
        $govData = file_get_contents($govPath);
        $govBase64 = 'data:image/' . $govType . ';base64,' . base64_encode($govData);

        // Seal (seal.png)
        $sealPath = 'image/seal.png';
        $sealType = pathinfo($sealPath, PATHINFO_EXTENSION);
        $sealData = file_get_contents($sealPath);
        $sealBase64 = 'data:image/' . $sealType . ';base64,' . base64_encode($sealData);
        ?>

        <div class="header-container">
            <!-- Seal Left + Emblem Center - Very Compact -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin: 0; padding: 0;">

                <!-- Seal on Left (hidden on print) -->
                <div style="flex: 0 0 20%; text-align: left;">
                    <img class="no-print"
                        src="<?php echo $sealBase64; ?>"
                        style="width: 60px; height: auto;">
                </div>

                <!-- Government Emblem in Center -->
                <div style="flex: 1; text-align: center;">
                    <img src="<?php echo $govBase64; ?>"
                        style="max-height: 40px; width: auto; display: block; margin: 0 auto;">
                </div>

                <!-- Right empty space for balance -->
                <div style="flex: 0 0 20%;"></div>

            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="text-center" style="margin-top: 1px; line-height: 1.2; font-size:13px; font-family: 'Segoe UI', Tahoma, sans-serif;">
        <div class="fw-bold">IN THE COURT OF THE</div>
        <span class="fw-bold"><?= strtoupper(htmlspecialchars($court_name)); ?></span><br>
        <div class="fw-bold">KOHIMA : NAGALAND</div>
    </div>

    <!-- Date -->
    <div class="text-center fw-bold mt-1">
        CAUSE LIST FOR :
        <?= date("d F Y", strtotime($date)); ?>
    </div>
    <div class="container-fluid ps-4 pe-4">
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-dark">
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
                        <tr class="fw-bold" style="font-size:13px; font-family: Tahoma, Geneva, Verdana, sans-serif;">
                            <td class="text-center"><?= $i++; ?></td>
                            <td><?= nl2br(htmlspecialchars($row['case_no'])); ?></td>
                            <td class="text-break"><?= nl2br(htmlspecialchars($row['parties'])); ?></td>
                            <td><?= nl2br(htmlspecialchars($row['counsel'])); ?></td>
                            <td><?= nl2br(htmlspecialchars($row['remark'])); ?></td>
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

        <div style="margin-top: 10px; text-align: right; font-size: 13px;">
            <strong>Sd/-</strong><br>
            By Order
        </div>

    </div>

<?php endif; ?>

<?php if (!isset($_GET['pdf'])): ?>
    <?php require "includes/script.php"; ?>
    <?php require "includes/footer.php"; ?>
<?php endif; ?>