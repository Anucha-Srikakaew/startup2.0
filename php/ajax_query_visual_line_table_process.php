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

$MAIN = $_POST['MAIN'];
$TYPE = $_POST['TYPE'];
$MODEL = $_POST['MODEL'];

$BIZ = $MAIN['BIZ'];
$CENTER = $MAIN['CENTER'];
$COUNTRY = $MAIN['COUNTRY'];
$FACTORY = $MAIN['FACTORY'];
$LINE = $MAIN['LINE'];
$PERIOD = $MAIN['PERIOD'];
$SHIFT = $MAIN['SHIFT'];
$START_DATE = $MAIN['START_DATE'];
$END_DATE = $MAIN['END_DATE'];

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

$WHERE = "AND `COUNTRY` = '$COUNTRY' AND `FACTORY` = '$FACTORY' AND `BIZ` = '$BIZ' AND `LINE` = '$LINE' AND `TYPE` = '$TYPE' AND `MODEL` = '$MODEL' AND `PERIOD` = '$PERIOD' AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
$sql = "SELECT 
        `tblMain`.`PROCESS`,
        `tblMain`.`MODEL`,
        `tblPASS`.`PASS`,
        `tblFAIL`.`FAIL`,
        `tblBLANK`.`BLANK`,
        `tblTOTAL`.`TOTAL`,
        'STATUS'
        FROM (SELECT DISTINCT `PROCESS`, `MODEL` FROM `$tbl_item` WHERE `COUNTRY` = 'TH' $WHERE) AS `tblMain`
        LEFT JOIN  (
            SELECT `PROCESS`, COUNT(`ID`) AS PASS
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = 'PASS' $WHERE GROUP BY `PROCESS`) AS `tblPASS`
        ON `tblMain`.`PROCESS` = `tblPASS`.`PROCESS`
        LEFT JOIN  (
            SELECT `PROCESS`, COUNT(`ID`) AS `FAIL`
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = 'FAIL' $WHERE GROUP BY `PROCESS`) AS `tblFAIL`
        ON `tblMain`.`PROCESS` = `tblFAIL`.`PROCESS`
        LEFT JOIN  (
            SELECT `PROCESS`, COUNT(`ID`) AS `BLANK`
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = 'BLANK' $WHERE GROUP BY `PROCESS`) AS `tblBLANK`
        ON `tblMain`.`PROCESS` = `tblBLANK`.`PROCESS`
        LEFT JOIN  (
            SELECT `PROCESS`, COUNT(`ID`) AS `NULL`
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = '' $WHERE GROUP BY `PROCESS`) AS `tblNULL`
        ON `tblMain`.`PROCESS` = `tblNULL`.`PROCESS`
        LEFT JOIN  (
            SELECT `PROCESS`, COUNT(`ID`) AS `TOTAL`
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` LIKE '%%' $WHERE GROUP BY `PROCESS`) AS `tblTOTAL`
        ON `tblMain`.`PROCESS` = `tblTOTAL`.`PROCESS`
        ";
$query = mysqli_query($con, $sql);
$rowObj = mysqli_fetch_all($query, MYSQLI_ASSOC);

echo json_encode($rowObj);
