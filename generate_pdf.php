<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// Sanitize date input
$date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_name = $_SESSION['court_name'] ?? '';
$court_id = $_SESSION['court_id'] ?? '';

if (empty($date)) {
    header("Location: history.php");
    exit();
}

$dompdf = new Dompdf();

ob_start();
$_GET['pdf'] = 1;

include 'view.php';
$html = ob_get_clean();

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Save PDF safely
$court_id = $_SESSION['court_id'] ?? '';
$filename = "causelist_" . $date . ".pdf";
$file = "pdf/" . $filename;
file_put_contents($file, $dompdf->output());

// Return only the filename
echo $file;
exit;
?>