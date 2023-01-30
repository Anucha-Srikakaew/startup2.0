<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$keyPost = array_keys($_POST);

$col = '';
$val = '';
foreach ($keyPost as $key => $keyStr) {
    if ($key == 0) {
        $col .= "`$keyStr`";
        $val .= "'$_POST[$keyStr]'";
    } else {
        $col .= ",`$keyStr`";
        $val .= ",'$_POST[$keyStr]'";
    }
}

$sql = "INSERT INTO `item`($col) VALUES ($val)";

if (mysqli_query($con, $sql)) {
    $sql = 'SELECT MAX(ID) AS MAXID FROM `item`';
    $MAXID = mysqli_fetch_array(mysqli_query($con, $sql))['MAXID'];

    if ($_POST['PICTURE'] == '1') {
        // while (mysqli_next_result($con));
        mysqli_query($con, "UPDATE `item` SET `PICTURE`=CONCAT(`ID`, '.jpg') WHERE `ID` = '$MAXID'");
    }

    $response['data'] = array(
        "ID" => $MAXID
    );

    $response['response'] = true;
    $response['message'] = 'Complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to query to MySQL: " . $con->error;
}
echo json_encode($response);
