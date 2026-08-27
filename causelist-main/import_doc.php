<?php

require 'vendor/autoload.php';

require 'config/db.php';

$conn = getDB();

session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\Table;

function dateAlreadyExists($conn, string $mysqlDate, int $courtId): bool
{
    $sql = "SELECT COUNT(*) AS total FROM causelist_db
            WHERE cause_date = ? AND court_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $mysqlDate, $courtId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return ((int)$row['total']) > 0;
}

if (isset($_POST['confirm_import'])) {

    $selectedDate = $_POST['import_date'];


    $d = DateTime::createFromFormat('d-m-Y', $selectedDate);
    if (!$d) {
        die("Invalid date format: " . htmlspecialchars($selectedDate));
    }
    $mysqlDate = $d->format('Y-m-d');

    $courtId = (int)$_SESSION['court_id'];

    if (empty($_SESSION['cases'][$selectedDate])) {
        die("No data found for this date. Please upload the document again.");
    }

    if (dateAlreadyExists($conn, $mysqlDate, $courtId)) {
        echo "<h2>Already Imported</h2>";
        echo "Cause list for " . htmlspecialchars($selectedDate) . " already exists. Nothing was inserted.";
        echo "<br><a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>Back</a>";
        exit();
    }

    $inserted = 0;
    $skipped = 0;
    $edited_no = 1;

    foreach ($_SESSION['cases'][$selectedDate] as $case) {

    
        $caseNo  = trim($case['case_no'] ?? '');
        $counsel = trim($case['counsel'] ?? '');
        $remark  = trim($case['remark'] ?? '');
        $parties = '';

        if ($caseNo === '') {
            $skipped++;
            continue;
        }

     $sql = "INSERT INTO causelist_db
        (cause_date, case_no, parties, counsel, remark, next_date, court_id, edited_no)
        VALUES (?, ?, ?, ?, ?, NULL, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
    $stmt,
    "sssssii",
    $mysqlDate,
    $caseNo,
    $parties,
    $counsel,
    $remark,
    $courtId,
    $edited_no
);

        if (mysqli_stmt_execute($stmt)) {
            $inserted++;
            $edited_no++;
        } else {
            $skipped++;
        }
    }

    unset($_SESSION['cases'][$selectedDate]);

    // Automatically generate PDF
    $calledFromSave = true;
    $_GET['cause_date'] = $mysqlDate;

    ob_start();
    include __DIR__ . '/generate_pdf.php';
    ob_end_clean();

   
    header("Location: view.php?cause_date=" . urlencode($mysqlDate));
    exit();
}

if (isset($_POST['import_date'])) {

    echo "<h2>Confirmation Page</h2>";

    echo "<p>Date: " . htmlspecialchars($_POST['import_date']) . "</p>";

    echo "<form method='post'>
    <input type='hidden' name='confirm_import' value='1'>
    <input type='hidden' name='import_date' value='" . htmlspecialchars($_POST['import_date']) . "'>
    <button type='submit'>Confirm Import</button>
</form>";

    echo "<br>";

    echo "<a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>Cancel</a>";

    exit();
}

?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="docx_file" accept=".docx" required>
    <button type="submit">Upload DOCX</button>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['docx_file'])) {

    if ($_FILES['docx_file']['error'] !== UPLOAD_ERR_OK) {
        die("File upload failed. Please try again.");
    }

    $phpWord = IOFactory::load($_FILES['docx_file']['tmp_name']);

    $dates = [];
    $cases = [];
    $currentDate = '';
    $documentDate = '';

    foreach ($phpWord->getSections() as $section) {

        foreach ($section->getElements() as $element) {

            if (method_exists($element, 'getText')) {

                $text = trim($element->getText());

                if (preg_match('/Date\s*:\s*(\d{2}-\d{2}-\d{4})/i', $text, $match)) {
                    $documentDate = $match[1];
                }
            }

            if ($element instanceof Table) {

                foreach ($element->getRows() as $row) {

                    $cells = [];

                    foreach ($row->getCells() as $cell) {

                        $text = '';

                        foreach ($cell->getElements() as $cellElement) {

                            if (method_exists($cellElement, 'getText')) {
                                //$text .= $cellElement->getText();
                               $text .= str_replace('&amp;', '&', $cellElement->getText());
                            }
                        }

                        $cells[] = trim($text);
                    }

                    if (count($cells) < 4) {
                        continue;
                    }

                    $date = $documentDate;


                    if (!empty($date) && strtoupper(trim($cells[1] ?? '')) !== 'GR AND CIVIL CASES') {

                        $cases[$date][] = [
                            'case_no' => $cells[1] ?? '',
                            'remark'  => $cells[2] ?? '',
                            'counsel' => $cells[3] ?? ''
                        ];

                        if (!isset($dates[$date])) {
                            $dates[$date] = 0;
                        }

                        $dates[$date]++;
                    }
                }
            }
        }
    }

    $_SESSION['cases'] = $cases;

    if (empty($documentDate)) {
        die("Could not find the date in the Word document.");
    }


    echo "<h3>Dates Found</h3>";

    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
<th>Date</th>
<th>Cases Found</th>
<th>Action</th>
</tr>";

    foreach ($dates as $date => $count) {

        $d = DateTime::createFromFormat('d-m-Y', $date);

        if ($d) {
            $mysqlDate = $d->format('Y-m-d');
        } else {
            $mysqlDate = '';
        }

        echo "<tr><td>" . htmlspecialchars($date) . "</td><td>$count</td><td>";

        if (!$mysqlDate) {
            echo "Could not read this date";
        } elseif (dateAlreadyExists($conn, $mysqlDate, (int)$_SESSION['court_id'])) {
            echo "ALREADY EXISTS";
        } else {
            echo "<form method='post' style='display:inline'>
                    <input type='hidden' name='import_date' value='" . htmlspecialchars($date) . "'>
                    <button type='submit'>Import</button>
                  </form>";
        }

        echo "</td></tr>";
    }

    echo "</table>";
}
?>