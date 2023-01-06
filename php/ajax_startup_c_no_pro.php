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
$LINE = $_POST['LINE'];
$PERIOD = $_POST['PERIOD'];
$STARTUP_EMP_ID = $_POST['STARTUP_EMP_ID'];
$SHIFT_DATE = $_POST['SHIFT_DATE'];
$SHIFT = $_POST['SHIFT'];

$sql = 'INSERT INTO `startup_time`(
    `COUNTRY`, 
    `FACTORY`, 
    `BIZ`, 
    `LINE`, 
    `TYPE`, 
    `MODEL`, 
    `REMARK`, 
    `SHIFT_DATE`, 
    `SHIFT`, 
    `PERIOD`, 
    `STATUS`, 
    `STARTTIME`, 
    `CONFIRM1`, 
    `DATETIME1`, 
    `CONFIRM2`, 
    `DATETIME2`, 
    `CONFIRM3`, 
    `DATETIME3`, 
    `TAKT`, 
    `RESULT`
    ) 
    VALUES (
    "' . $COUNTRY . '", 
    "' . $FACTORY . '", 
    "' . $BIZ . '", 
    "' . $LINE . '", 
    "-", 
    "-", 
    "-", 
    "' . $SHIFT_DATE . '",
    "' . $SHIFT . '",
    "' . $PERIOD . '",
    "NO PRODUCTION",
    NOW(),
    "' . $STARTUP_EMP_ID . '",
    NOW(),
    "",
    "",
    "",
    "",
    "",
    "");';

if (mysqli_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Query no production complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to connect to MySQL: " . $con->connect_error;
}
echo json_encode($response);
