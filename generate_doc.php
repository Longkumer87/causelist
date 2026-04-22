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

$date = preg_replace('/[^0-9\-]/', '', $_GET['cause_date'] ?? '');
$court_id = $_SESSION['court_id'] ?? '';
$court_name = $_SESSION['court_name'] ?? '';

if (empty($date)) {
    header("Location: history.php");
    exit();
}

// Get data from database
$sql = "SELECT * FROM `causelist_db` WHERE cause_date = ? AND court_id = ? ORDER BY edited_no ASC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "si", $date, $court_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

$formattedDate = date("d F Y", strtotime($date));
$filename = "causelist_" . $court_id . "_" . $date . ".doc";


// Government emblem base64

//for localhost
$govUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/causelist/image/gov.png';
//for online
// $govUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/image/gov.png';


// Force download as .doc
header("Content-Type: application/msword");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
    xmlns:w="urn:schemas-microsoft-com:office:word"
    xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 1cm 1.5cm 1cm 1.5cm;
            mso-page-orientation: portrait;
        }

        body {
            font-family: Tahoma, Arial, sans-serif;
            font-size: 11pt;
            text-align: center;
        }

        img {
            display: block;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background-color: #000;
            color: #fff;
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 9px;
        }

        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
            font-size: 9px;
        }

        td:first-child {
            text-align: center;
        }

        .header-text {
            text-align: center;
            font-size: 9pt;
            line-height: 1.5;
        }

        .signature {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <!-- Emblem -->
    <img src="<?= $govUrl; ?>" style="max-height:30px; width:auto;">

    <!-- Court Header -->
    <div class="header-text">
        <br>
        IN THE COURT OF THE<br>
        <strong><?= htmlspecialchars(strtoupper($court_name)); ?></strong><br>
        KOHIMA : NAGALAND<br><br>
        <strong>CAUSE LIST FOR : <?= $formattedDate; ?></strong>
    </div>

    <br>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th style="width:6%;">S.No</th>
                <th style="width:18%;">Case No</th>
                <th style="width:23%;">Parties</th>
                <th style="width:23%;">Counsel</th>
                <th style="width:15%;">Remark</th>
                <th style="width:15%;">Next Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= nl2br(htmlspecialchars($row['case_no'])); ?></td>
                    <td><?= nl2br(htmlspecialchars($row['parties'])); ?></td>
                    <td><?= nl2br(htmlspecialchars($row['counsel'])); ?></td>
                    <td><?= nl2br(htmlspecialchars($row['remark'])); ?></td>
                    <td>
                        <?= !empty($row['next_date']) && $row['next_date'] !== '0000-00-00'
                            ? date("d-m-Y", strtotime($row['next_date']))
                            : ''; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Signature -->
    <table style="margin-top:20px; border:none;">
        <tr>
            <td style="border:none; width:75%;"></td>
            <td style="border:none; width:25%; text-align:center;">
                <?= getSignature($court_id); ?>
            </td>
        </tr>
    </table>

</body>

</html>