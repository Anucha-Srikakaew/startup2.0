<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$IDArr = $_POST['ID'];

$sql = '';
foreach ($IDArr as $id) {
    $sql .= "DELETE FROM `item` WHERE `ID` = '$id';";
}

if (mysqli_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Delete item complete.';
} else {
    $response['response'] = false;
    $response['message'] = 'Delete item fail.';
}

echo json_encode($response);
