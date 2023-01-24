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

$BIZ = $_POST['BIZ'];
$CENTER = $_POST['CENTER'];
$COUNTRY = $_POST['COUNTRY'];
$FACTORY = $_POST['FACTORY'];
$LINE = $_POST['LINE'];
$MODEL = $_POST['MODEL'];
$PROCESS = $_POST['PROCESS'];
$TYPE = $_POST['TYPE'];
$PERIOD = $_POST['PERIOD'];
$SHIFT = $_POST['SHIFT'];
$START_DATE = $_POST['START_DATE'];
$END_DATE = $_POST['END_DATE'];

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
    $QUERYPERIOD = "AND `SHIFT_DATE` = '$START_DATE' AND `SHIFT` = '$SHIFT'";
} else {
    $QUERYPERIOD = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
}

$sql = "SELECT `ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, 
                `DRAWING`, `MODEL`, `PROCESS`, 
                `JIG_NAME`, `PICTURE`, `ITEM`, 
                `SPEC_DES`, `MIN`, `MAX`, `SPEC`, 
                `VALUE1`, `VALUE2`, `JUDGEMENT`, 
                `REMARK`, `SHIFT_DATE`, `SHIFT`, 
                `PERIOD`, `RESULT`, `LastUpdate` 
        FROM `$tbl_item` 
        WHERE `COUNTRY` = '$COUNTRY' 
        AND `FACTORY` = '$FACTORY'
        AND `BIZ` = '$BIZ'
        AND `LINE` = '$LINE'
        AND `MODEL` = '$MODEL'
        AND `TYPE` = '$TYPE'
        AND `PERIOD` = '$PERIOD'
        $QUERYPERIOD";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

$output = array();
foreach ($row as $data) {
    $processName = $data['PROCESS'];
    if (!isset($output[$processName])) {
        $output[$processName] = array($data);
    } else {
        array_push($output[$processName], $data);
    }
}

echo json_encode($output);
