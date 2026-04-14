<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';

$date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_id = $_SESSION['court_id'] ?? '';

if (empty($date)) {
    header("Location: history.php");
    exit();
}

// Capture HTML
ob_start();
$_GET['pdf'] = 1;
include 'view.php';
$html = ob_get_clean();

// Create mPDF
$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
    'margin_top' => 0,
    'margin_bottom' => 5,
    'margin_left' => 5,
    'margin_right' => 5
]);
$mpdf->SetDisplayMode('fullpage');
$mpdf->SetDefaultFontSize(8);

// ✅ Embed CSS directly here
$stylesheet = "
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}
@page :first {
    margin-top: 0;
}
@page {
    margin-top: 40px;
    margin-left: 10px;
    margin-right: 10px;
    margin-bottom: 10px;
}
th:nth-child(1) { width: 6%; }
th:nth-child(2) { width: 17%; }
th:nth-child(3) { width: 23%; }
th:nth-child(4) { width: 27%; }
th:nth-child(5) { width: 14%; }
th:nth-child(6) { width: 14%; }
th, td {
    border: 1px solid #000;
    padding: 4px;
    word-wrap: break-word;
}
";
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

// ✅ Then write the captured HTML
$mpdf->WriteHTML($html);

// Save file
$court_id = $_SESSION['court_id'] ?? '';
$filename = "causelist_" . $court_id . "_" . $date . ".pdf";
$file = "pdf/" . $filename;

// Make sure folder exists
if (!file_exists('pdf')) {
    mkdir('pdf', 0777, true);
}

$mpdf->Output($file, \Mpdf\Output\Destination::FILE);

// Return path
if (!isset($calledFromSave)) {
    echo $file;
    exit;
}
