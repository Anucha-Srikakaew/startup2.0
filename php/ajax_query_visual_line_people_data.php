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

$WHERE = "AND `COUNTRY` = '$COUNTRY' 
AND `FACTORY` = '$FACTORY' 
AND `BIZ` = '$BIZ' 
AND `LINE` = '$LINE' 
AND `PERIOD` = '$PERIOD' 
AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";

$sql = "SELECT 
tblMain.`ID`,  
tblMain.`COUNTRY`,  
tblMain.`FACTORY`,  
tblMain.`BIZ`,  
tblMain.`LINE`,  
TRIM(tblMain.TYPE) AS `TYPE`,
TRIM(tblMain.MODEL) AS `MODEL`,  
tblMain.`REMARK`,  
tblMain.`SHIFT_DATE`,  
tblMain.`SHIFT`,  
tblMain.`PERIOD`,  
tblMain.`STATUS`,  
tblMain.`STARTTIME`,  
tblMain.`CONFIRM1`,  
tblMain.`DATETIME1`,  
tblMain.`CONFIRM2`,  
tblMain.`DATETIME2`,  
tblMain.`CONFIRM3`,
tblMain.`DATETIME3`,
tblMain.`TAKT`,
tblMain.`RESULT`,
TBL1.NAME_CONFIRM1,
TBL2.NAME_CONFIRM2,
TBL3.NAME_CONFIRM3,
TIMESTAMPDIFF(MINUTE, STARTTIME, DATETIME1) AS TAKT1,
TIMESTAMPDIFF(MINUTE, DATETIME1, DATETIME2) AS TAKT2,
TIMESTAMPDIFF(MINUTE, DATETIME2, DATETIME3) AS TAKT3
FROM (SELECT * FROM `$tbl_time` WHERE `COUNTRY` = '$COUNTRY' $WHERE) AS tblMain
    LEFT JOIN ( 
        SELECT `NAME` AS NAME_CONFIRM1, `MEMBER_ID` FROM `member` ) AS TBL1 
        ON TBL1.`MEMBER_ID` = tblMain.`CONFIRM1` 
    LEFT JOIN ( 
        SELECT `NAME` AS NAME_CONFIRM2, `MEMBER_ID` FROM `member` ) AS TBL2 
        ON TBL2.`MEMBER_ID` = tblMain.`CONFIRM2` 
    LEFT JOIN ( 
        SELECT `NAME` AS NAME_CONFIRM3, `MEMBER_ID` FROM `member` ) AS TBL3 
        ON TBL3.`MEMBER_ID` = tblMain.`CONFIRM3`
WHERE `COUNTRY` = '$COUNTRY' $WHERE";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

echo json_encode($row);
