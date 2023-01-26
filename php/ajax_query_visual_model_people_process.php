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
$MODEL = $MAIN['MODEL'];
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

$sql = "SELECT 
`$tbl_time`.`ID`,  
`$tbl_time`.`COUNTRY`,  
`$tbl_time`.`FACTORY`,  
`$tbl_time`.`BIZ`,  
`$tbl_time`.`LINE`,  
`$tbl_time`.`TYPE`,  
`$tbl_time`.`MODEL`,  
`$tbl_time`.`REMARK`,  
`$tbl_time`.`SHIFT_DATE`,  
`$tbl_time`.`SHIFT`,  
`$tbl_time`.`PERIOD`,  
`$tbl_time`.`STATUS`,  
`$tbl_time`.`STARTTIME`,  
`$tbl_time`.`CONFIRM1`,  
`$tbl_time`.`DATETIME1`,  
`$tbl_time`.`CONFIRM2`,  
`$tbl_time`.`DATETIME2`,  
`$tbl_time`.`CONFIRM3`,  
`$tbl_time`.`DATETIME3`,  
`$tbl_time`.`TAKT`,  
`$tbl_time`.`RESULT`,
TBL1.NAME_CONFIRM1,
TBL2.NAME_CONFIRM2,
TBL3.NAME_CONFIRM3,
TIMESTAMPDIFF(MINUTE, STARTTIME, DATETIME1) AS TAKT1,
TIMESTAMPDIFF(MINUTE, DATETIME1, DATETIME2) AS TAKT2,
TIMESTAMPDIFF(MINUTE, DATETIME2, DATETIME3) AS TAKT3
FROM `$tbl_time` 
    LEFT JOIN ( 
        SELECT `NAME` AS NAME_CONFIRM1, `MEMBER_ID` FROM `member` ) AS TBL1 
        ON TBL1.`MEMBER_ID` = `$tbl_time`.`CONFIRM1` 
    LEFT JOIN ( 
        SELECT `NAME` AS NAME_CONFIRM2, `MEMBER_ID` FROM `member` ) AS TBL2 
        ON TBL2.`MEMBER_ID` = `$tbl_time`.`CONFIRM2` 
    LEFT JOIN ( 
        SELECT `NAME` AS NAME_CONFIRM3, `MEMBER_ID` FROM `member` ) AS TBL3 
        ON TBL3.`MEMBER_ID` = `$tbl_time`.`CONFIRM3`
WHERE `COUNTRY` = '$COUNTRY'
AND `FACTORY` = '$FACTORY'
AND `BIZ` = '$BIZ'
AND `LINE` = '$LINE'
AND `TYPE` = '$TYPE'
AND `MODEL` = '$MODEL'
AND `PERIOD` = '$PERIOD'
AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'
GROUP BY `ID`";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

echo json_encode($row);
