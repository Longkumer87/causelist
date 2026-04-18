<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'config/db.php';
require "includes/header.php";
require 'functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$court_name = $_SESSION['court_name'] ?? '';
$court_id = $_SESSION['court_id'] ?? '';
$title = "causelist - " . $court_name;

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

<nav class="navbar flex-wrap d-flex justify-content-between px-3 shadow-sm no-print" style="background-color:#2f3e46;">
    <span class="navbar-brand fs-6 text-white mb-0">
        <i class="bi bi-building me-1"></i>
        <?= htmlspecialchars($court_name); ?>
    </span>
    <div class="d-flex gap-2">
        <a href="welcome.php" class="btn btn-outline-light btn-sm">
            <i class="bi bi-house"></i> Home
        </a>
        <a href="edit.php?cause_date=<?= htmlspecialchars($date); ?>" class="btn btn-outline-warning btn-sm">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <button onclick="shareWhatsApp('<?= $date ?>', '<?= htmlspecialchars($court_name) ?>')" class="btn btn-outline-success btn-sm">
            <i class="bi bi-whatsapp"></i> WhatsApp
        </button>
        <button onclick="window.print()" class="btn btn-dark btn-sm">
            <i class="bi bi-printer"></i> Print
        </button>
    </div>
    <a href="logout.php" class="btn btn-danger btn-sm px-3">
        <i class="bi bi-power"></i> Logout
    </a>
</nav>

<?php if (empty($rows)): ?>
    <div class="text-center mt-4">
        <h5>No cause list found for this date</h5>
    </div>
<?php else: ?>

    <?php
    $govPath = 'image/gov.png';
    $govData = file_get_contents($govPath);
    $govBase64 = 'data:image/png;base64,' . base64_encode($govData);
    ?>

    <div class="header-container mt-2">
        <div class="flex-fill text-start"></div>
        <div class="flex-fill text-center">
            <img src="<?= $govBase64; ?>" style="max-height:40px;">
        </div>
        <div class="flex-fill"></div>
    </div>

    <div class="text-center mt-1 lh-sm fs-6">
        <div>IN THE COURT OF THE</div>
        <span><?= htmlspecialchars(strtoupper($court_name)); ?></span><br>
        <div>KOHIMA : NAGALAND</div>
    </div>

    <div class="text-center fw-bold mt-1">
        CAUSE LIST FOR : <?= date("d F Y", strtotime($date)); ?>
    </div>

    <div class="container-fluid ps-4 pe-4">
        <div class="table-responsive">
            <table class="table table-bordered border-dark table-sm">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">S.No</th>
                        <th class="text-center">Case No</th>
                        <th class="text-center">Parties</th>
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
    </div>

    <div style="grid-template-columns: 4fr 1fr;" class="container-fluid d-grid">
        <div class="p-2"></div>
        <div class="p-2 text-center"><?= getSignature($court_id); ?></div>
    </div>

<?php endif; ?>

<?php require "includes/footer.php"; ?>