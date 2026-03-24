<?php

$date = $_GET['cause_date'] ?? '';
$date = htmlspecialchars($date);

$message = "District Court Kohima \n";
$message .= "🟡 PRINCIPAL DISTRICT AND SESSIONS JUDGE \n";
$message .= "✅ CAUSE LIST LINK FOR " . date("d F Y", strtotime($date)) . "\n";
$message .= "➡️ http://192.168.0.127/causelist/view.php?cause_date=" . $date;
?>

<div class="col-12 col-md-4 text-center">
    <a target="_blank"
        href="https://wa.me/?text=<?= urlencode($message); ?>"
        class="btn btn-outline-success w-50">
        <i class="bi bi-whatsapp"></i> Share on WhatsApp
    </a>

</div>