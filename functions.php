<?php

//Function to get Sd(signatures)
function getSignature($court_id)
{

    if ($court_id == 1) {
        return "Sd/-<br>By Order";
    } elseif ($court_id == 2) {
        return "Sd/-<br>Chief Judicial Magistrate<br>Kohima, Nagaland";
    } elseif ($court_id == 3) {
        return "Sd/-<br>Judicial Magistrate First Class<br>Kohima, Nagaland";
    } else {
        return "Sd/-";
    }
}

//Function for Seal
function getSeal($court_id)
{

    // Only for Principal District & Sessions Judge
    if ($court_id == 1) {

        $sealPath = 'image/seal.png';
        $sealType = pathinfo($sealPath, PATHINFO_EXTENSION);
        $sealData = file_get_contents($sealPath);
        $sealBase64 = 'data:image/' . $sealType . ';base64,' . base64_encode($sealData);

        return "<img src='$sealBase64' style='width:100px; height:auto;'>";
    }

    return ""; // no seal for other courts
}

//Function for googleMeet

function getMeetLink($court_id)
{

    if ($court_id == 1) {
        return "https://meet.google.com/ovc-pzpi-njf";
    } elseif ($court_id == 2) {
        return "https://meet.google.com/yyyy-yyyy-yyy";
    } elseif ($court_id == 3) {
        return "https://meet.google.com/zzzz-zzzz-zzz";
    } else {
        return "";
    }
}
