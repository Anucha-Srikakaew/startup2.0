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
$CENTER = $_POST['CENTER'];

$sql = "SELECT `ID`, `COUNTRY`, `FACTORY`, `BIZ`, `CENTER`, `MODEL`, `LastUpdate` FROM `model_center`
WHERE `COUNTRY` ='$COUNTRY' AND `FACTORY`='$FACTORY' AND `BIZ`='$BIZ' AND `CENTER` = '$CENTER'";
$query = mysqli_query($con, $sql);
$output = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($output);
