<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

// diff time
function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
}

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$END_DATE = $_POST['END_DATE'];
$LINE = $_POST['LINE'];
$MEMBER = $_POST['MEMBER'];
$MODEL = $_POST['MODEL'];
$PERIOD = $_POST['PERIOD'];
$SHIFT = $_POST['SHIFT'];
$START_DATE = $_POST['START_DATE'];
$TYPE = $_POST['TYPE'];

// check time get data from table.
if ($PERIOD == 'SHIFT' || $PERIOD == 'DAY') {
    if (DateDiff($START_DATE, date("Y-m-d")) > 3) {
        $tbl_item = 'startup_item_trace';
        $tbl_time = 'startup_time_trace';
    } else {
        $tbl_item = 'startup_item';
        $tbl_time = 'startup_time';
    }
} else {
    $tbl_item = 'startup_item';
    $tbl_time = 'startup_time';

    $date = new DateTime($START_DATE);
    $week1 = $date->format("W");
    $week2 = date('W');
    if ($week1 == $week2) {
        $tbl_item = 'startup_item';
        $tbl_time = 'startup_time';
    } else {
        $tbl_item = 'startup_item_trace';
        $tbl_time = 'startup_time_trace';
    }
}

if ($PERIOD == 'SHIFT') {
    $QUERY_WHERE = "AND `SHIFT_DATE` = '$SHIFT_DATE' AND `SHIFT` = '$SHIFT'";
} else {
    $QUERY_WHERE = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
}

$sql = "DELETE FROM `$tbl_time` 
        WHERE LINE = '$LINE'
        AND `MODEL` = '$MODEL'
        AND `PERIOD` = '$PERIOD'
        AND `TYPE` = '$TYPE' $QUERY_WHERE;";

$sql .= "DELETE FROM `$tbl_item` 
        WHERE LINE = '$LINE'
        AND `MODEL` = '$MODEL'
        AND `PERIOD` = '$PERIOD'
        AND `TYPE` = '$TYPE' $QUERY_WHERE;";

// echo $sql;
if (mysqli_multi_query($con, $sql)) {
    $response['response'] = true;
    $response['message'] = 'Query startup complete.';
} else {
    $response['response'] = false;
    $response['message'] = "Failed to connect to MySQL: " . $con->error;
}

echo json_encode($response);
