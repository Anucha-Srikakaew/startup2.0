<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");


$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$ID = $_POST['ID'];
$WHERE = " WHERE `ID` = '$ID'";
$sql = 'UPDATE `target_shift` SET';
$i = 0;

foreach ($_POST as $key => $value) {
    if ($key != 'ID') {
        if ($i != 0) {
            $sql .= "`$key`='$value'";
        } else {
            $sql .= "`$key`='$value'";
        }
    }
    $i++;
}

$sql = $sql . $WHERE;

if (mysqli_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Query startup complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to connect to MySQL: " . $con->error;
}

echo json_encode($response);
