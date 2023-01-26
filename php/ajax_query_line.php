<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$BIZ = $_POST['BIZ'];
$COUNTRY = $_POST['COUNTRY'];
$FACTORY = $_POST['FACTORY'];

$sql = "SELECT `ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `LastUpdate` FROM `startup_line`
WHERE `COUNTRY` ='$COUNTRY' AND `FACTORY`='$FACTORY' AND `BIZ`='$BIZ'";
$query = mysqli_query($con, $sql);
$output = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($output);
