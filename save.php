<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}

$court = $_SESSION['court_name'];

?>

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

        //empty next date
        if (empty($next_date[$i])) {
            $next = "NULL";
        } else {
            $next = "'" . $next_date[$i] . "'";
        }

        //edit or update cases
        if (isset($_POST['id'][$i]) && !empty($_POST['id'][$i])) {
            $id = $_POST['id'][$i];

            $sql = "UPDATE causelist_db SET 
                    case_no='$case',
                    parties='$party',
                    counsel='$coun',
                    remark='$rem',
                    next_date=$next
                WHERE id=$id 
                AND court_name=$court_name";
        } else {
            //handling Insert New Cases
            $sql = "INSERT INTO causelist_db (cause_date, case_no, parties, counsel, remark, next_date, court_name)
                VALUES ('$cause_date','$case','$party','$coun','$rem','$next','$court_name')";
        }

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Insert Failed : " . mysqli_error($conn);
        }
    }

    header("Location: view.php?cause_date=$cause_date");
    exit();
}
