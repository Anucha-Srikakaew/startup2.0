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

$WHERE = "AND `COUNTRY` = 'TH' AND `FACTORY` = 'STTC' AND `BIZ` = 'IM' AND `LINE` = 'HEB' AND `SHIFT_DATE` BETWEEN '2022-12-19' AND '2022-12-19'";
$sql = "SELECT 
        tblMain.TYPE,
        tblMain.MODEL,
        tblPASS.PASS,
        tblFAIL.FAIL,
        tblBLANK.BLANK,
        tblTOTAL.TOTAL,
        'STATUS'
        FROM (SELECT DISTINCT `TYPE`, `MODEL` FROM `startup_item` WHERE `COUNTRY` = 'TH' $WHERE) AS tblMain
        LEFT JOIN  (
            SELECT `TYPE`, COUNT(`ID`) AS PASS 
            FROM `startup_item` 
            WHERE `JUDGEMENT` = 'PASS' $WHERE GROUP BY `TYPE`) AS tblPASS
        ON tblMain.`TYPE` = tblPASS.`TYPE`
        LEFT JOIN  (
            SELECT `TYPE`, COUNT(`ID`) AS FAIL 
            FROM `startup_item` 
            WHERE `JUDGEMENT` = 'FAIL' $WHERE GROUP BY `TYPE`) AS tblFAIL
        ON tblMain.`TYPE` = tblFAIL.`TYPE`
        LEFT JOIN  (
            SELECT `TYPE`, COUNT(`ID`) AS BLANK 
            FROM `startup_item` 
            WHERE `JUDGEMENT` = 'BLANK' $WHERE GROUP BY `TYPE`) AS tblBLANK
        ON tblMain.`TYPE` = tblBLANK.`TYPE`
        LEFT JOIN  (
            SELECT `TYPE`, COUNT(`ID`) AS `NULL`
            FROM `startup_item` 
            WHERE `JUDGEMENT` = '' $WHERE GROUP BY `TYPE`) AS tblNULL
        ON tblMain.`TYPE` = tblNULL.`TYPE`
        LEFT JOIN  (
            SELECT `TYPE`, COUNT(`ID`) AS `TOTAL`
            FROM `startup_item` 
            WHERE `JUDGEMENT` LIKE '%%' $WHERE GROUP BY `TYPE`) AS tblTOTAL
        ON tblMain.`TYPE` = tblTOTAL.`TYPE`
        ";
$query = mysqli_query($con, $sql);
$rowObj = mysqli_fetch_all($query, MYSQLI_ASSOC);

// foreach($rowObj as $rowArr){
//     print_r($rowArr);
// }

echo json_encode($rowObj);
