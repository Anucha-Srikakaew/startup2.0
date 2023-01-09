<?php
include('../connect.php');
include("../connect84.php");
date_default_timezone_set("Asia/Bangkok");

////////////IP ADRESS////////////////
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $IP = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from remote address
else {
    $IP = $_SERVER['REMOTE_ADDR'];
}

// diff time
function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
}

function StatusResult($shift_date, $shift, $line, $period)
{
    if ($period == "DAY") {
        $connect = mysqli_connect("43.72.52.51", "inno", "1234", "startup2_0");
        $sql = "SELECT `ID` FROM `startup_time` WHERE `SHIFT_DATE` = '$shift_date' AND `SHIFT` = '$shift' AND `LINE` = '$line' AND `PERIOD` = '$period' AND `CONFIRM3` = ''";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        if (empty($row)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
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

$strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER'";
$objQuery = mysqli_query($con, $strSQL);
$objResult = mysqli_fetch_array($objQuery);

$NAME = $objResult['NAME'];
$MEMBER_TYPE = $objResult['TYPE'];

if ($MEMBER_TYPE == 'SUP.T' or $MEMBER_TYPE == 'ENG' or $MEMBER_TYPE == 'ADMIN' or $MEMBER_TYPE == 'TECH' or $MEMBER_TYPE == 'PIC') {
    /////// HAVE PERMISSION CASE ///////////////
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

    $sql .= "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`, `LastUpdate`, `STATUS`) 
            VALUES (NULL, '$MEMBER', '$NAME', '$IP', 'DISPOSE $LINE $MODEL START DATE : $START_DATE, END DATE : $END_DATE $SHIFT', NOW(), 'SUCCESS');";

    ////// UPDATE GOOD STARTUP TO 84 MONITOR ///////////
    // if (StatusResult($SHIFT_DATE, $SHIFT, $LINE, $PERIOD) == true) {
    //     $strSQL = "INSERT INTO `di_cl`.`tbl_startup_check` 
    //     (`data_id` , `shift_date` , `for_model` ,`line` ,`result` ,`shift` , `rec_date`)
    //     VALUES 
    //     (NULL , '$SHIFT_DATE1', '$BIZ', '$LINE', 'GOOD', '$SHIFT1', '$NOW'),
    //     (NULL , '$SHIFT_DATE2', '$BIZ', '$LINE', 'GOOD', '$SHIFT2', '$NOW')";
    //     $objQuery = mysqli_query($con84, $strSQL);
    // }

    if (mysqli_multi_query($con, $sql)) {
        $response['response'] = true;
        $response['message'] = 'DISPOSE COMPLETE MFE TEAM.';
    } else {
        $response['response'] = false;
        $response['message'] = "Failed to connect to MySQL: " . $con->error;
    }
} else if ($MEMBER_TYPE == 'SUP.L' or $MEMBER_TYPE == 'LEAD') {
    /////// CASE : LEADER OR SUP.L ///////////////

    /////// TEXT SHOW ON SCREEN ///////////////////////
    $response['response'] = false;
    $response['message'] = "NO AUTHORIZE";
} else {
    $TEXT = "<h3 class='text-warning'>NO PERMISSION</h3><p>Please confirm your information.</p>";
    $response['response'] = false;
    $response['message'] = "NO PERMISSION. Please confirm your information.";
}

echo json_encode($response);
