<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$column = $_POST['column'];
$id = $_POST['id'];
$judgment = $_POST['judgment'];
$value = $_POST['value'];
$timeId = $_POST['timeId'];

$sql = "UPDATE `startup_item` 
        SET `$column`='$value',`JUDGEMENT`='$judgment',`LastUpdate`=NOW() 
        WHERE `ID`='$id';";
$sql .= "UPDATE `startup_time` SET `DATETIME1`=NOW() WHERE `ID`='$id';";

if (mysqli_multi_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Query startup complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to connect to MySQL: " . $con->error;
}

echo json_encode($response);
