<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$FACTORY = $_POST['FACTORY'];
$BIZ = $_POST['BIZ'];
$LINE = $_POST['LINE'];
$MODEL = $_POST['MODEL'];

$sql = "INSERT INTO `model_center`(`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `CENTER`, `MODEL`, `LastUpdate`) 
VALUES (NULL,'TH','$FACTORY','$BIZ','$LINE','$MODEL',NOW())";
if (mysqli_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Query startup complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to connect to MySQL: " . $con->error;
}

echo json_encode($response);
