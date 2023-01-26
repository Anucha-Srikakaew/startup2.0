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
$MODEL = $_POST['MODEL'];

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

$WHERE = "AND `COUNTRY` = '$COUNTRY' AND `FACTORY` = '$FACTORY' AND `BIZ` = '$BIZ' AND `LINE` = '$LINE' AND `MODEL` = '$MODEL' AND `PERIOD` = '$PERIOD' AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
$sql = "SELECT 
        tblMain.TYPE,
        tblMain.MODEL,
        tblPASS.PASS,
        tblFAIL.FAIL,
        tblBLANK.BLANK,
        tblTOTAL.TOTAL,
        'STATUS'
        FROM (SELECT DISTINCT `TYPE`, `MODEL` FROM `$tbl_item` WHERE `COUNTRY` = '$COUNTRY' $WHERE) AS tblMain
        LEFT JOIN  (
            SELECT `TYPE`,`MODEL`, COUNT(`ID`) AS PASS 
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = 'PASS' $WHERE GROUP BY `TYPE`,`MODEL`) AS tblPASS
        ON tblMain.`TYPE` = `tblPASS`.`TYPE` AND tblMain.`MODEL` = `tblPASS`.`MODEL`
        LEFT JOIN  (
            SELECT `TYPE`, `MODEL`, COUNT(`ID`) AS FAIL 
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = 'FAIL' $WHERE GROUP BY `TYPE`,`MODEL`) AS tblFAIL
        ON tblMain.`TYPE` = `tblFAIL`.`TYPE` AND tblMain.`MODEL` = `tblFAIL`.`MODEL`
        LEFT JOIN  (
            SELECT `TYPE`, `MODEL`, COUNT(`ID`) AS BLANK
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = 'BLANK' $WHERE GROUP BY `TYPE`,`MODEL`) AS tblBLANK
        ON tblMain.`TYPE` = `tblBLANK`.`TYPE` AND tblMain.`MODEL` = `tblBLANK`.`MODEL`
        LEFT JOIN  (
            SELECT `TYPE`, `MODEL`, COUNT(`ID`) AS `NULL`
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` = '' $WHERE GROUP BY `TYPE`,`MODEL`) AS tblNULL
        ON tblMain.`TYPE` = `tblNULL`.`TYPE` AND tblMain.`MODEL` = `tblNULL`.`MODEL`
        LEFT JOIN  (
            SELECT `TYPE`, `MODEL`, COUNT(`ID`) AS `TOTAL`
            FROM `$tbl_item` 
            WHERE `JUDGEMENT` LIKE '%%' $WHERE GROUP BY `TYPE`,`MODEL`) AS tblTOTAL
        ON tblMain.`TYPE` = `tblTOTAL`.`TYPE` AND tblMain.`MODEL` = `tblTOTAL`.`MODEL`
        ";
$query = mysqli_query($con, $sql);
$rowObj = mysqli_fetch_all($query, MYSQLI_ASSOC);

echo json_encode($rowObj);
