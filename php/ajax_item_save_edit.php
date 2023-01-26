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
$sql = 'UPDATE `item` SET';
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
    $response['message'] = 'Complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to query to MySQL: " . $con->error;
}
echo json_encode($response);
