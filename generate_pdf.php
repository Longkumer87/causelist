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
    'margin_top' => 10,
    'margin_bottom' => 20,
    'margin_left' => 10,
    'margin_right' => 10
]);

// Improve styling (VERY IMPORTANT)
$mpdf->WriteHTML('
<style>
body { font-size: 12px; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid black; padding: 5px; }
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
?>








<!-- This is backup -->

<!-- <?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}



// Sanitize date input
$date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_name = $_SESSION['court_name'] ?? '';
$court_id = $_SESSION['court_id'] ?? '';

if (empty($date)) {
    header("Location: history.php");
    exit();
}

// $dompdf = new Dompdf();

ob_start();
$_GET['pdf'] = 1;

include 'view.php';
$html = ob_get_clean();

// Save temp HTML
$tempHtml = "pdf/temp_" . time() . ".html";
file_put_contents($tempHtml, $html);

// Final PDF name
$court_id = $_SESSION['court_id'] ?? '';
$filename = "causelist_" . $court_id . "_" . $date . ".pdf";
$pdfFile = "pdf/" . $filename;

// wkhtmltopdf path for ubuntu
$wkhtml = 'wkhtmltopdf';

// For Windows
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $wkhtml = '"C:\\Program Files\\wkhtmltopdf\\bin\\wkhtmltopdf.exe"';
}

// Command
$command = $wkhtml . " $tempHtml $pdfFile";

// Execute
exec($command);

// Delete temp file
unlink($tempHtml);

// Return file path
echo $pdfFile;
exit;

?> -->

//For dompdf

// require 'dompdf/autoload.inc.php';
// use Dompdf\Dompdf;
// $dompdf->loadHtml($html);
// $dompdf->setPaper('A4', 'portrait');
// $dompdf->render();

// // Save PDF safely
// $court_id = $_SESSION['court_id'] ?? '';
// $filename = "causelist_" . $court_id . "_" . $date . ".pdf";
// $file = "pdf/" . $filename;
// file_put_contents($file, $dompdf->output());

// // Return only the filename
// echo $file;
// exit;



// Save as HTML instead of PDF
$court_id = $_SESSION['court_id'] ?? '';
$filename = "causelist_" . $court_id . "_" . $date . ".html";
$file = "pdf/" . $filename;

file_put_contents($file, $html);

// Return file path (your JS will handle full URL)
echo $file;
exit;
