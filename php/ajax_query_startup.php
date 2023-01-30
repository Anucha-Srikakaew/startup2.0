<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$BIZ = $_POST['BIZ'];
$COUNTRY = $_POST['COUNTRY'];
$END_DATE = $_POST['END_DATE'];
$FACTORY = $_POST['FACTORY'];
$LINE = $_POST['LINE'];
$MODEL = $_POST['MODEL'];
$PERIOD = $_POST['PERIOD'];
$SHIFT = $_POST['SHIFT'];
$START_DATE = $_POST['START_DATE'];
$TYPE = $_POST['TYPE'];


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
    $where_period = "AND `SHIFT_DATE` = '$SHIFT_DATE' AND `SHIFT` = '$SHIFT'";
} else {
    $where_period = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
}

if (isset($_POST['TIME'])) {
    $sql = "SELECT 
        `ID` 
        FROM `startup_time` 
        WHERE `BIZ` = '$BIZ'
        AND `COUNTRY` = '$COUNTRY'
        AND `FACTORY` = '$FACTORY'
        AND `LINE` = '$LINE'
        AND `MODEL` = '$MODEL'
        AND `PERIOD` = '$PERIOD'
        AND `TYPE` = '$TYPE'
        $where_period";
} else {
    $sql = "SELECT 
        `ID`, 
        `NUM_ORDER`,
        `COUNTRY`, 
        `FACTORY`, 
        `BIZ`, 
        `LINE`, 
        `TYPE`, 
        `DRAWING`, 
        `MODEL`, 
        `PROCESS`, 
        `JIG_NAME`, 
        `PICTURE`, 
        `ITEM`,
        `SPEC_DES`,
        `MIN`,
        `MAX`,
        `SPEC`,
        `VALUE1`,
        `VALUE2`,
        `JUDGEMENT`,
        `REMARK`, 
        `SHIFT_DATE`, 
        `SHIFT`, 
        `PERIOD`, 
        `RESULT`, 
        `LastUpdate` 
        FROM `startup_item` 
        WHERE `BIZ` = '$BIZ'
        AND `COUNTRY` = '$COUNTRY'
        AND `FACTORY` = '$FACTORY'
        AND `LINE` = '$LINE'
        AND `MODEL` = '$MODEL'
        AND `PERIOD` = '$PERIOD'
        AND `TYPE` = '$TYPE'
        $where_period
        ORDER BY `NUM_ORDER` ASC";
}
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($row);
