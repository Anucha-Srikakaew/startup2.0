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
$TYPE = $_POST['TYPE'];

$sql = "INSERT INTO `startup_line`(`COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `LastUpdate`) 
VALUES ('TH','$FACTORY','$BIZ','$LINE','$TYPE',NOW());";

$sql .= "INSERT INTO `target_shift` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TARGET1`, `TARGET2`, `TARGET3`, `START_TIME_SHIFT_DAY`, `START_TIME_SHIFT_NIGHT`, `TARGET_TIME_SHIFT_DAY`, `TARGET_TIME_SHIFT_NIGHT`, `SHIFT_DATE`) 
VALUES (NULL, 'TH', '$FACTORY', '$BIZ', '$LINE', '30', '20', '20', '09:29:00', '20:31:00', '20:30:00', '09:30:00', NOW());";

if (mysqli_multi_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Query startup complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to connect to MySQL: " . $con->error;
}

echo json_encode($response);
