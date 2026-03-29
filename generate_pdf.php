<?php
session_start();

require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$date = $_GET['cause_date'] ?? '';
$court_name = $_SESSION['court_name'] ?? '';

$dompdf = new Dompdf();

// ✅ START buffer
ob_start();

// Tell view it's PDF mode
$_GET['pdf'] = 1;
$_GET['court_name'] = $court_name;

// Load HTML
include 'view.php';

// ✅ GET clean HTML
$html = ob_get_clean();

// Load into Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Save PDF
$file = "pdf/causelist_" . $date . ".pdf";
file_put_contents($file, $dompdf->output());

// ✅ RETURN ONLY file path
echo $file;
exit;
?>