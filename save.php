<?php require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cause_date = $_POST["cause_date"] ?? '';
    if (empty($cause_date)) {
        die("Error:cause date is required");
    }
    $case_no = $_POST["case_no"];
    $parties = $_POST["parties"];
    $counsel = $_POST["counsel"];
    $remark = $_POST["remark"];
    $next_date = $_POST["next_date"];

    $count = count($case_no);

    for ($i = 0; $i < $count; $i++) {

        if (empty($case_no[$i])) {
            continue;
        }

        $case = htmlspecialchars($case_no[$i]);
        $party = htmlspecialchars($parties[$i]);
        $coun = htmlspecialchars($counsel[$i]);
        $rem = htmlspecialchars($remark[$i]);
        $next = $next_date[$i];

        $sql = "INSERT INTO causelist (cause_date, case_no, parties, counsel, remark, next_date)
                VALUES ('$cause_date','$case','$party','$coun','$rem','$next')";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Insert Failed : " . mysqli_error($conn);
        }
    }

    header("Location: view.php?cause_date=$cause_date");
    exit();
}
