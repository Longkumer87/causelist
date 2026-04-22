<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';
require_once 'functions.php';

$date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_name = $_GET['court_name'] ?? '';
$court_id = $_SESSION['court_id'] ?? 0;

$formattedDate = date('d-m-Y', strtotime($date));
$meetLink = getMeetLink($court_id);

//kohima District court link here
//$baseUrl = "https://kohimadiscourt.free.nf";
//$filename = "causelist_" . $court_id . "_" . $date . ".pdf";
//$pdfLink = $baseUrl . "/pdf/" . $filename;

//my hosting link here
//$baseUrl = "https://maonglkr.free.nf";
//$filename = "causelist_" . $court_id . "_" . $date . ".pdf";
//$pdfLink = $baseUrl . "/pdf/" . $filename;

//localhostlink 
$baseUrl = "https://unexplorable-ashlee-ineffable.ngrok-free.dev";
$pdfLink = $baseUrl . "/causelist/pdf/causelist_" . $court_id . "_" . $date . ".pdf";

$message = urlencode(
    "🏛️ District Court Kohima\n\n" .
    "⚖️ " . $court_name . "\n" .
    "📄 CAUSE LIST FOR : " . $formattedDate . "\n\n" .
    $pdfLink . "\n\n" .
    "🎥 Google Meet:\n" . $meetLink
);

echo $message;
exit();