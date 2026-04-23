<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/db.php';
require_once 'functions.php';
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\SimpleType\Jc;

$date       = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_id   = $_SESSION['court_id'] ?? '';
$court_name = $_SESSION['court_name'] ?? '';

if (empty($date)) {
    header("Location: history.php");
    exit();
}

// Get data from database
$sql  = "SELECT * FROM `causelist_db` WHERE cause_date = ? AND court_id = ? ORDER BY edited_no ASC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $date, $court_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows   = mysqli_fetch_all($result, MYSQLI_ASSOC);

$formattedDate = date("d F Y", strtotime($date));
$filename      = "causelist_" . $court_id . "_" . $date . ".docx";
$imagePath     = __DIR__ . '/image/gov.png';

// ── Build Word Document ──────────────────────────────────────────
$phpWord = new PhpWord();
$phpWord->setDefaultFontName('Tahoma');
$phpWord->setDefaultFontSize(9);

$section = $phpWord->addSection([
    'marginTop'    => 567,
    'marginBottom' => 567,
    'marginLeft'   => 850,
    'marginRight'  => 850,
    'orientation'  => 'portrait',
    'paperSize'    => 'A4',
]);

// ── Emblem Image ─────────────────────────────────────────────────
if (file_exists($imagePath)) {
    $section->addImage($imagePath, [
        'height'        => 40,
        'alignment'     => Jc::CENTER,
        'wrappingStyle' => 'inline',
    ]);
}

// ── Court Header ─────────────────────────────────────────────────
$centerPara = ['alignment' => Jc::CENTER, 'spaceAfter' => 0, 'spaceBefore' => 0];

$section->addTextBreak(1);
$section->addText('IN THE COURT OF THE', ['size' => 9], $centerPara);
$section->addText(strtoupper($court_name), ['bold' => true, 'size' => 10], $centerPara);
$section->addText('KOHIMA : NAGALAND', ['size' => 9], $centerPara);
$section->addTextBreak(1);
$section->addText('CAUSE LIST FOR : ' . $formattedDate, ['bold' => true, 'size' => 10], $centerPara);
$section->addTextBreak(1);

// ── Table Setup ──────────────────────────────────────────────────
$totalWidth = 17100;
$colWidths  = [
    (int)($totalWidth * 0.06),  // S.No
    (int)($totalWidth * 0.18),  // Case No
    (int)($totalWidth * 0.23),  // Parties
    (int)($totalWidth * 0.23),  // Counsel
    (int)($totalWidth * 0.15),  // Remark
    (int)($totalWidth * 0.15),  // Next Date
];

$table = $section->addTable([
    'borderSize'  => 6,
    'borderColor' => '000000',
    'cellMargin'  => 60,
    'width'       => $totalWidth,
    'unit'        => TblWidth::TWIP,
]);

// ── Header Row ───────────────────────────────────────────────────
$headerFont = ['bold' => true, 'color' => 'FFFFFF', 'size' => 9];
$headerCell = ['bgColor' => '000000'];
$centerParagraph = ['alignment' => Jc::CENTER, 'spaceAfter' => 0];
$headers = ['S.No', 'Case No', 'Parties', 'Counsel', 'Remark', 'Next Date'];

$table->addRow();
foreach ($headers as $i => $h) {
    $table->addCell($colWidths[$i], $headerCell)
          ->addText($h, $headerFont, $centerParagraph);
}

// ── Data Rows ────────────────────────────────────────────────────
$serial    = 1;
$dataFont  = ['size' => 9];
$leftPara  = ['alignment' => Jc::LEFT,   'spaceAfter' => 0];
$rightPara = ['alignment' => Jc::CENTER, 'spaceAfter' => 0];
$cellStyle = ['valign' => 'top'];

foreach ($rows as $row) {
    $table->addRow();

    // S.No
    $table->addCell($colWidths[0], $cellStyle)
          ->addText($serial++, $dataFont, $rightPara);

    // Case No
    $c = $table->addCell($colWidths[1], $cellStyle);
    foreach (explode("\n", trim($row['case_no'])) as $line)
        $c->addText(htmlspecialchars(trim($line)), $dataFont, $leftPara);

    // Parties
    $c = $table->addCell($colWidths[2], $cellStyle);
    foreach (explode("\n", trim($row['parties'])) as $line)
        $c->addText(htmlspecialchars(trim($line)), $dataFont, $leftPara);

    // Counsel
    $c = $table->addCell($colWidths[3], $cellStyle);
    foreach (explode("\n", trim($row['counsel'])) as $line)
        $c->addText(htmlspecialchars(trim($line)), $dataFont, $leftPara);

    // Remark
    $c = $table->addCell($colWidths[4], $cellStyle);
    foreach (explode("\n", trim($row['remark'])) as $line)
        $c->addText(htmlspecialchars(trim($line)), $dataFont, $leftPara);

    // Next Date
    $nextDate = (!empty($row['next_date']) && $row['next_date'] !== '0000-00-00')
        ? date("d-m-Y", strtotime($row['next_date'])) : '';
    $table->addCell($colWidths[5], $cellStyle)
          ->addText($nextDate, $dataFont, $rightPara);
}

// ── Signature ────────────────────────────────────────────────────
$section->addTextBreak(2);
$sigTable = $section->addTable([
    'borderSize'  => 0,
    'borderColor' => 'FFFFFF',
    'width'       => $totalWidth,
    'unit'        => TblWidth::TWIP,
]);
$sigTable->addRow();
$sigTable->addCell((int)($totalWidth * 0.75))->addText('');
$sigTable->addCell((int)($totalWidth * 0.25))
         ->addText(
             getSignature($court_id),
             ['size' => 9],
             ['alignment' => Jc::CENTER, 'spaceAfter' => 0]
         );

// ── Download ─────────────────────────────────────────────────────
ob_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

$writer = IOFactory::createWriter($phpWord, 'Word2007');
$writer->save('php://output');
exit;