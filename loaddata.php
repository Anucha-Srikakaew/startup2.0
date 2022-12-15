<?php
require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");

if (isset($_POST['DATA'])) {
    // print_r($_POST['DATA']);
    $PROCESS = $_POST['PROCESS'];
    $DATE = $_POST['DATE'];
    $DATE_SHIFT = $_POST['DATE_SHIFT'];
    $MODEL = $_POST['MODEL'];
    $SHIFT = $_POST['SHIFT'];
    $LINE = $_POST['LINE'];
    $TYPE = $_POST['TYPE'];
    $PERIOD = $_POST['PERIOD'];
    $data = array();

    $now = date("H");
    if (isset($_POST['SHIFT']) && $_POST['SHIFT'] != '') {
        $SHIFT = $_POST['SHIFT'];
    } else {
        if ($now >= 8 && $now < 20) {
            $SHIFT = 'DAY';
        } else {
            $SHIFT = 'NIGHT';
        }
    }

    // diff time
    function DateDiff($strDate1, $strDate2)
    {
        return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
    }

    // check time
    if (DateDiff($DATE_SHIFT, date("Y-m-d")) > 3) {
        $tbl_item = 'startup_item_trace';
        $tbl_time = 'startup_time_trace';
    } else {
        $tbl_item = 'startup_item';
        $tbl_time = 'startup_time';
    }

    function getStartAndEndDate($week, $year)
    {
        $week_start = new DateTime();
        $week_start->setISODate($year, $week);
        $return[0] = $week_start->format('Y-m-d');
        $time = strtotime($return[0], time());
        $time += 6 * 24 * 3600;
        $return[1] = date('Y-m-d', $time);
        return $return;
    }
    if ($PERIOD == "WEEK") {
        $date_arr = explode("-", $DATE);
        $START_DATE = getStartAndEndDate(str_replace('W', '', $date_arr[1]), $date_arr[0])[0];
        $END_DATE = getStartAndEndDate(str_replace('W', '', $date_arr[1]), $date_arr[0])[1];
        $query_shift_date = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
        $query_shift_date1 = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";

        if (str_replace("W", "", $date_arr[1]) == date('W')) {
            $tbl_item = 'startup_item';
            $tbl_time = 'startup_time';
        } else {
            $tbl_item = 'startup_item_trace';
            $tbl_time = 'startup_time_trace';
        }
    } else {
        $query_shift_date = "AND SHIFT_DATE LIKE '$DATE_SHIFT%' AND SHIFT = '$SHIFT'";
        $query_shift_date1 = "AND SHIFT_DATE LIKE '$DATE_SHIFT%'";
    }

    // select name COUNT TOTAL
    $strSQL = "SELECT COUNT(*) AS TOTAL 
    FROM `$tbl_item` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' 
    AND MODEL LIKE '%$MODEL%' $query_shift_date
    AND LastUpdate =(SELECT DISTINCT LastUpdate FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND TYPE LIKE '$TYPE' AND MODEL LIKE '%$MODEL%' $query_shift_date ORDER BY SHIFT_DATE DESC LIMIT 1)";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $TOTAL = $objResult['TOTAL'];
    $data[] = $TOTAL;

    // select name COUNT REMARK
    $strSQL = "SELECT COUNT(REMARK) AS REMARK 
    FROM `$tbl_item` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' 
    AND REMARK <> '' AND MODEL LIKE '%$MODEL%' $query_shift_date
    AND LastUpdate =(SELECT DISTINCT LastUpdate FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND TYPE LIKE '$TYPE' AND MODEL LIKE '%$MODEL%' $query_shift_date ORDER BY SHIFT_DATE DESC LIMIT 1)";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $REMARK = $objResult['REMARK'];
    $data[] = $REMARK;

    // select name COUNT PASS
    $strSQL = "SELECT COUNT(JUDGEMENT) AS PASS 
    FROM `$tbl_item` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE'
    AND JUDGEMENT = 'PASS' AND MODEL LIKE '%$MODEL%' $query_shift_date
    AND LastUpdate =(SELECT DISTINCT LastUpdate FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND TYPE LIKE '$TYPE' AND MODEL LIKE '%$MODEL%' $query_shift_date ORDER BY SHIFT_DATE DESC LIMIT 1)";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $PASS = $objResult['PASS'];
    $data[] = $PASS;

    // select name COUNT FAIL
    $strSQL = "SELECT COUNT(JUDGEMENT) AS FAIL 
    FROM `$tbl_item` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' 
    AND JUDGEMENT = 'FAIL' AND MODEL LIKE '%$MODEL%' $query_shift_date
    AND LastUpdate =(SELECT DISTINCT LastUpdate FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND TYPE LIKE '$TYPE' AND MODEL LIKE '%$MODEL%' $query_shift_date ORDER BY SHIFT_DATE DESC LIMIT 1)";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $FAIL = $objResult['FAIL'];
    $data[] = $FAIL;


    // select name DATETIME
    $strSQL = "SELECT * FROM `$tbl_time` WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE'  AND TYPE LIKE '$TYPE' AND MODEL LIKE '%$MODEL%' $query_shift_date ORDER BY ID DESC";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $DATETIME1 = $objResult['DATETIME1'];
    $DATETIME2 = $objResult['DATETIME2'];
    $DATETIME3 = $objResult['DATETIME3'];
    $CONFIRM_TECH = $objResult['CONFIRM1'];
    $CONFIRM_MFE = $objResult['CONFIRM2'];
    $CONFIRM_PROD = $objResult['CONFIRM3'];

    $data[] = $DATETIME1;
    $data[] = $DATETIME2;
    $data[] = $DATETIME3;
    $data[] = $CONFIRM_TECH;
    $data[] = $CONFIRM_MFE;
    $data[] = $CONFIRM_PROD;

    // select name MFE
    $strSQL = "SELECT NAME FROM `member` WHERE MEMBER_ID = '$data[8]'";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $data[] = $objResult['NAME'];

    // select name LEAD
    $strSQL = "SELECT NAME FROM `member` WHERE MEMBER_ID = '$data[9]'";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $data[] = $objResult['NAME'];
    // $data[] = $NAME;

    // select MINUTE
    $strSQL = "SELECT *,
    TIMESTAMPDIFF(MINUTE, STARTTIME, DATETIME1) AS TAKT1,
    TIMESTAMPDIFF(MINUTE, DATETIME1, DATETIME2) AS TAKT2,
    TIMESTAMPDIFF(MINUTE, DATETIME2, DATETIME3) AS TAKT3  FROM `$tbl_time` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND TYPE = '$TYPE' AND MODEL LIKE '%$MODEL%' $query_shift_date  ORDER BY ID DESC";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $data[] = $objResult['TAKT1'];
    $data[] = $objResult['TAKT2'];
    $data[] = $objResult['TAKT3'];

    // select TARGET
    $strSQL = "SELECT * FROM `target_shift` WHERE LINE LIKE '$LINE'";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $data[] =  $objResult['TARGET1'];
    $data[] = $objResult['TARGET2'];
    $data[] = $objResult['TARGET3'];

    // select name TECH
    $strSQL = "SELECT NAME FROM `member` WHERE MEMBER_ID = '$data[7]'";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $data[] = $objResult['NAME'];

    echo json_encode($data);
}
