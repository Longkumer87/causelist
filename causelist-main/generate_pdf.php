<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';
require_once 'config/db.php';
require_once 'functions.php';

$date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_id = $_SESSION['court_id'] ?? '';
$court_name = $_SESSION['court_name'] ?? '';

$conn = getDB();

if (empty($date)) {
    header("Location: history.php");
    exit();
}

// Get data from database
$sql = "SELECT * FROM `causelist_db` WHERE cause_date = ? AND court_id = ? ORDER BY edited_no ASC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $date, $court_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Government emblem base64
$govPath = __DIR__ . '/image/gov.png';
$govBase64 = '';
if (file_exists($govPath)) {
    $govData = file_get_contents($govPath);
    $govBase64 = 'data:image/png;base64,' . base64_encode($govData);
}

$formattedDate = date("d F Y", strtotime($date));

// Build HTML
$html = '
<table style="width:100%; border:none; margin-bottom:5px;">
    <tr>
        <td style="width:20%; border:none; vertical-align:top;">' . getSeal($court_id) . '</td>
        <td style="width:60%; border:none; text-align:center; vertical-align:middle;">
            <img src="' . $govBase64 . '" style="max-height:50px;"><br><br>
            IN THE COURT OF THE<br>
            <strong>' . htmlspecialchars(strtoupper($court_name)) . '</strong><br>
            KOHIMA : NAGALAND<br><br>
            <strong>CAUSE LIST FOR : ' . $formattedDate . '</strong>
        </td>
        <td style="width:20%; border:none;"></td>
    </tr>
</table>

<table style="width:100%; border-collapse:collapse; table-layout:fixed;">
    <thead>
        <tr>
            <th style="width:6%; background:#000; color:#fff; border:1px solid #000; padding:5px; text-align:center;">S.No</th>
            <th style="width:18%; background:#000; color:#fff; border:1px solid #000; padding:5px; text-align:center;">Case No</th>
            <th style="width:23%; background:#000; color:#fff; border:1px solid #000; padding:5px; text-align:center;">Parties</th>
            <th style="width:23%; background:#000; color:#fff; border:1px solid #000; padding:5px; text-align:center;">Counsel</th>
            <th style="width:15%; background:#000; color:#fff; border:1px solid #000; padding:5px; text-align:center;">Remark</th>
            <th style="width:15%; background:#000; color:#fff; border:1px solid #000; padding:5px; text-align:center;">Next Date</th>
        </tr>
    </thead>
    <tbody>';

$i = 1;
foreach ($rows as $row) {
    $nextDate = !empty($row['next_date']) && $row['next_date'] !== '0000-00-00'
        ? date("d-m-Y", strtotime($row['next_date']))
        : '';

    $html .= '
        <tr>
            <td style="border:1px solid #000; padding:5px; text-align:center;">' . $i++ . '</td>
            <td style="border:1px solid #000; padding:5px;">' . nl2br(htmlspecialchars($row['case_no'])) . '</td>
            <td style="border:1px solid #000; padding:5px;">' . nl2br(htmlspecialchars($row['parties'])) . '</td>
            <td style="border:1px solid #000; padding:5px;">' . nl2br(htmlspecialchars($row['counsel'])) . '</td>
            <td style="border:1px solid #000; padding:5px;">' . nl2br(htmlspecialchars($row['remark'])) . '</td>
            <td style="border:1px solid #000; padding:5px; text-align:center;">' . $nextDate . '</td>
        </tr>';
}

$html .= '
    </tbody>
</table>';

// Fetch note
$sql_note = "SELECT note FROM causelist_note WHERE cause_date=? AND court_id=?";
$stmt_note = mysqli_prepare($conn, $sql_note);
mysqli_stmt_bind_param($stmt_note, "si", $date, $court_id);
mysqli_stmt_execute($stmt_note);
$note_result = mysqli_stmt_get_result($stmt_note);
$note_row = mysqli_fetch_assoc($note_result);
$note = $note_row['note'] ?? '';

if (!empty($note)) {
   $html .= '<br><p><strong>' . nl2br(htmlspecialchars($note)) . '</strong></p>';
}

$html .= '
<br>
<table style="width:100%; border:none;">
    <tr>
        <td style="border:none; width:75%;"></td>
        <td style="border:none; width:25%; text-align:center;">' . getSignature($court_id) . '</td>
    </tr>
</table>';


//'tempDir' => '/home/vol15_5/infinityfree.com/if0_41552198/htdocs/tmp',
// mPDF
$mpdf = new \Mpdf\Mpdf([
    'tempDir' => __DIR__ . '/tmp',
    'format' => 'A4',
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_left' => 10,
    'margin_right' => 10
]);

$mpdf->SetDefaultFontSize(9);
$mpdf->WriteHTML($html);

// Save to pdf folder
$filename = "causelist_" . $court_id . "_" . $date . ".pdf";
$filePath = __DIR__ . "/pdf/" . $filename;

$mpdf->Output($filePath, \Mpdf\Output\Destination::FILE);


// If called directly from browser, trigger download
if (!isset($calledFromSave)) {

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit();
}
