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
    'margin_top' => 5,
    'margin_bottom' => 5,
    'margin_left' => 5,
    'margin_right' => 5
]);

// styling 
$mpdf->WriteHTML('
<style>

html, body {
    margin: 0 !important;
    padding: 0 !important;
}

body > div:first-child {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

@page {
    margin: 0mm 5mm 5mm 5mm;
}

body {
    font-family: Arial, sans-serif;
    font-size: 9px;
    color: #000;
    margin: 0;
    padding: 0;
}

div.text-center {
    margin: 2px 0;
    line-height: 1.2;
}

table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
    margin: 0;
}

th {
    background-color: #000;
    color: #fff;
    font-size: 9px;
    padding: 3px;
    text-align: center;
}

td {
    font-size: 8.5px;
    padding: 2px;
    vertical-align: top;
    text-align: left;
    line-height: 1.2;
}

td:nth-child(1),
td:nth-child(6) {
    text-align: center;
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
