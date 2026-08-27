<?php

require_once 'config/db.php';

$conn = getDB();

$pdf = "";
$error = "";

if (isset($_GET['court_id']) && isset($_GET['cause_date'])) {

    $court_id = (int)$_GET['court_id'];

    $date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date']);

    $filename = "causelist_" . $court_id . "_" . $date . ".pdf";

    $filepath = __DIR__ . "/pdf/" . $filename;

    if (file_exists($filepath)) {
        header("Location: pdf/" . $filename . "?v=" . time());
        exit;
    } else {
        $error = "No Cause List available for the selected Court and Date.";
    }
}

//to select Courts 
$sql = "SELECT court_id, court_name FROM court ORDER BY court_name ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error loading courts.");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cause List</title>
    <link rel="icon" type="image/png" href="/favi.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-primary-subtle min-vh-100 d-flex flex-column">
    <div class="container mt-5 mb-4">

        <div class="card shadow">

            <div class="card-header text-center bg-primary text-white">
                <h3>District Courts: Kohima</h3>
                <h5>View Cause List</h5>
            </div>

            <div class="card-body">
              <form method="GET">
                    <div class="mb-3">
                        <label class="form-label">Select Court</label>
                        <select name="court_id" class="form-select" required>
                            <option value="">-- Select Court --</option>
                            <?php while ($court = mysqli_fetch_assoc($result)): ?>
                                <option value="<?= $court['court_id']; ?>"
                                    <?= (isset($_GET['court_id']) && $_GET['court_id'] == $court['court_id']) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($court['court_name']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Date</label>
                        <input type="date" name="cause_date" class="form-control"
                            value="<?= isset($_GET['cause_date']) ? htmlspecialchars($_GET['cause_date']) : date('Y-m-d'); ?>"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">View Cause List</button>

                    <?php if ($error) : ?>
                        <div class="alert alert-danger mt-3">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-secondary text-white mt-auto">
        <div class="container text-center py-2">
            <small>
                Official Web Applications<br>
                Designed & Developed by eCourts Team, Nagaland &copy; 2026 District Court Kohima, Nagaland
            </small>
        </div>
    </footer>

</body>

</html>