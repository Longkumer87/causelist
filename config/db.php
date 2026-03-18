<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);


$db_host = "localhost";
$db_username = "www_causelist";
$db_password="causelist2026";
$db_name="causelist_db";

$conn = mysqli_connect("$db_host", "$db_username", "$db_password", "$db_name");

if(!$conn){
    die("Database connection failed".mysqli_connect_error());
}

// $sql = "SELECT * FROM `causelist`";

// $result = mysqli_query($conn, $sql);

// if(!$result){
//     echo "Query fail".mysqli_error($conn);
//     mysqli_close($conn);
//     exit;
// }

?>