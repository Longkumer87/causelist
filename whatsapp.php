<?php

$date = $_GET['cause_date'] ?? '';
$date = htmlspecialchars($date);

$message = "District Court Kohima \n";
$message .= "🟡 " . strtoupper($court_name) . " \n";
$message .= "✅ CAUSE LIST LINK FOR " . date("d F Y", strtotime($date)) . "\n";
$message .= "➡️ http://192.168.0.127/causelist/view.php?cause_date=2026-03-24";
// $message .= "➡️ http://192.168.0.127/causelist/view.php?cause_date=" . $date;
?>

<div class="col-12 col-md-4 text-center">
    <a target="_blank"
        href="https://api.whatsapp.com/send?text=<?= urlencode($message); ?>"
        class="btn btn-outline-success w-50">
        <i class="bi bi-whatsapp"></i> Share on WhatsApp
    </a>

</div>