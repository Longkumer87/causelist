<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';
require_once 'functions.php';

$date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_name = $_GET['court_name'] ?? '';
$court_id = $_SESSION['court_id'] ?? 0;

$formattedDate = !empty($date) ? date('d-m-Y', strtotime($date)) : '';
$meetLink = getMeetLink($court_id);
$meetForm = getMeetForm($court_id);
$khmDis = getDistrictLink();

$baseUrl = "https://koh.dcnlservices.in/cause";
$pdfLink = $baseUrl . "/pdf/causelist_" . $court_id . "_" . $date . ".pdf?v=" . time();
//$pdfLink = $baseUrl . "/pdf/causelist_" . $court_id . "_" . $date . ".pdf";


// ✅ NO urlencode here
$message =
    "🏛️ *District Court Kohima*\n\n" .
    "⚖️ " . strtoupper($court_name) . "\n" .
    "📄 CAUSE LIST FOR : " . $formattedDate . "\n\n" .
    $pdfLink . "\n\n" .
    "🎥 Hybrid VC Application Form:\n" . $meetForm . "\n\n" .
   
    "🆕🔔 Kohima District Court Quick Links: " . $khmDis . "\n\n" ;


echo $message;
exit();