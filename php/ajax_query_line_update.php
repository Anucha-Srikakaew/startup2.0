<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$id = $_POST['id'];
$val = $_POST['val'];

$sql = "UPDATE `startup_line` SET `TYPE`='$val' WHERE `ID` = '$id'";

if (mysqli_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Query startup complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to connect to MySQL: " . $con->error;
}

echo json_encode($response);
