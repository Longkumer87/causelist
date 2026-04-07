<?php
session_start();

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

// Improve styling (VERY IMPORTANT)
$mpdf->WriteHTML('
<style>

@page {
    margin: 5mm;
}

body {
    font-family: Arial, sans-serif;
    font-size: 9px;
    color: #000;
    margin: 0;
    padding: 0;
}

/* Header */
div.text-center {
    margin: 2px 0;
    line-height: 1.2;
}

/* Table */
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}

/* Header row (dark like your sample) */
th {
    background-color: #000;
    color: #fff;
    font-size: 9px;
    padding: 3px;
    text-align: center;
}

/* Data cells */
td {
    font-size: 8.5px;
    padding: 2px;
    vertical-align: top;
    text-align: left;
    line-height: 1.2;
}

/* S.No + Next Date center */
td:nth-child(1),
td:nth-child(6) {
    text-align: center;
}

/* Prevent row break */
tr {
    page-break-inside: avoid;
}

</style>
', \Mpdf\HTMLParserMode::HEADER_CSS);


// Write HTML
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
echo $file;
exit;
