<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$ID = $_POST['ID'];
$sql = "DELETE FROM `member` WHERE `ID` = '$ID'";
$query = mysqli_query($con, $sql);
if (mysqli_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to query to MySQL: " . $con->error;
}
echo json_encode($response);