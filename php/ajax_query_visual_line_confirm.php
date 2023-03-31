<?php
include('../connect.php');
// include("../connect84.php");
date_default_timezone_set("Asia/Bangkok");

// echo json_encode($_POST);

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

$CONFIRM = $_POST['CONFIRM'];
$END_DATE = $_POST['END_DATE'];
$COUNTRY = $_POST['COUNTRY'];
$FACTORY = $_POST['FACTORY'];
$BIZ = $_POST['BIZ'];
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
    $QUERY_WHERE = "AND `SHIFT_DATE` = '$START_DATE' AND `SHIFT` = '$SHIFT'";
} else {
    $QUERY_WHERE = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
}

$strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER' AND COUNTRY = '$COUNTRY' AND FACTORY = '$FACTORY' AND BIZ = '$BIZ'";
$objQuery = mysqli_query($con, $strSQL);
$objResult = mysqli_fetch_array($objQuery);

// echo json_encode($objResult);

$NAME = $objResult['NAME'];
$MEMBER_TYPE = $objResult['TYPE'];
$MEMBER_ID = $objResult['MEMBER_ID'];

$WHERE = "AND `MODEL` = '$MODEL' AND `PERIOD` = '$PERIOD' AND `TYPE` = '$TYPE' $QUERY_WHERE;";
if (($CONFIRM == 'CONFIRM2') && ($MEMBER_TYPE == 'SUP.T' or $MEMBER_TYPE == 'ENG' or $MEMBER_TYPE == 'ADMIN' or $MEMBER_TYPE == 'PIC')) {

    // $strSQL = "UPDATE `$tbl_time` SET `CONFIRM2` = '$MEMBER_ID',DATETIME2 = '$NOW' WHERE `$tbl_time`.`ID` = $ID;";
    // $objQuery = mysqli_query($con, $strSQL);

    $sql = "UPDATE `$tbl_time` SET `CONFIRM2` = '$MEMBER_ID',`DATETIME2` = NOW()
    WHERE `COUNTRY` = '$COUNTRY'
    AND `FACTORY` = '$FACTORY'
    AND `BIZ` = '$BIZ'
    AND `LINE` = '$LINE' 
    $WHERE";
    mysqli_query($con, $sql);

    $response['response'] = true;
    $response['message'] = "CONFIRM COMPLETE MFE TEAM.";
} else if (($CONFIRM == 'CONFIRM3') && ($MEMBER_TYPE == 'SUP.L' or $MEMBER_TYPE == 'LEAD' or $MEMBER_TYPE == 'ADMIN')) {

    $sql = "UPDATE `$tbl_time` SET `CONFIRM3` = '$MEMBER_ID',`DATETIME3` = NOW()
    WHERE `COUNTRY` = '$COUNTRY'
    AND `FACTORY` = '$FACTORY'
    AND `BIZ` = '$BIZ'
    AND `LINE` = '$LINE' 
    $WHERE";
    mysqli_query($con, $sql);
    
    ////// RECORD STARTUP2.0 $tbl_time //////////////
    // $strSQL = "UPDATE `$tbl_time` SET `CONFIRM3` = '$MEMBER_ID',DATETIME3 = '$NOW' WHERE `$tbl_time`.`ID` = $ID;";
    // $objQuery = mysqli_query($con, $strSQL);

    //////UPDATE GOOD STARTUP TO IPRO/////////////////
    // require_once("connect_ipro.php");
    // $strSQL = "UPDATE `ipro`.`interlock` SET `interlock`.`STUP` = '1' WHERE `interlock`.`LINE` = '$LINE';";
    // $objQuery = mysqli_query($con, $strSQL);

    ////// UPDATE GOOD STARTUP TO 84 MONITOR ///////////
    if ($PERIOD == 'DAY' ) {
        // SELECT * FROM tbl_startup_check ORDER BY `data_id` DESC
        $strSQL = "INSERT INTO `di_cl`.`tbl_startup_check` 
        (`data_id` , `shift_date` , `for_model` ,`line` ,`result` ,`shift` , `rec_date`)
        VALUES 
        (NULL , '$START_DATE', '$BIZ', '$LINE', 'GOOD', 'A', NOW()),
        (NULL , '$START_DATE', '$BIZ', '$LINE', 'GOOD', 'B', NOW())";
         mysqli_query($con84, $strSQL);
    }

    /////// TEXT SHOW ON SCREEN ///////////////////////
    $response['response'] = true;
    $response['message'] = "CONFIRM COMPLETE PRODUCTION.";
} else {
    $response['response'] = false;
    $response['message'] = "NO PERMISSION. Please confirm your information.";
}

echo json_encode($response);
