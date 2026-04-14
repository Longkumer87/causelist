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
              body {
                margin:0;
                padding:0;
                font-family: Tahoma, Arial, sans-serif;
                font-size: 13px;
                text-align: center;
            }                  

            img {
                display: block;
                margin: 0 auto;
                padding:0;
            }

            .header-container {
                 margin:0;
                 padding:0;
                 line-height:1;
            }

            td:nth-child(3) {
                text-align: left;
               
            }
        
table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
}
    th,
    td {
        border: 1px solid #000;
        padding: 5px;
        }

    th {
    background-color: #000;
    color:white;
    }
@page {
    margin-top: 10px;
    margin-left: 10px;
    margin-right: 10px;
    margin-bottom: 10px;
}
th:nth-child(1) { width: 6%; }
th:nth-child(2) { width: 18%; }
th:nth-child(3) { width: 23%; }
th:nth-child(4) { width: 23%; }
th:nth-child(5) { width: 15%; }
th:nth-child(6) { width: 15%; }

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
