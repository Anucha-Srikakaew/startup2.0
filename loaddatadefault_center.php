<?php
require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");
$array_value = array();
$count = 1;
// $CHECK = '';
$DATE = $_POST['DATE'];
$DATE_SHIFT = $_POST['DATE_SHIFT'];
$CENTER = $_POST['CENTER'];
$TYPE = $_POST['TYPE'];
$MODEL = $_POST['MODEL'];
$PERIOD = $_POST['PERIOD'];

if (isset($_POST['SHIFT']) && $_POST['SHIFT'] != '') {
    $SHIFT = $_POST['SHIFT'];
} else {
    $now = date("H");

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

$strSQL = "SELECT DISTINCT TYPE,MODEL
    FROM `$tbl_item` 
    WHERE `PERIOD` = '$PERIOD' AND MODEL = '$MODEL' AND LINE = '$CENTER' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$DATE_SHIFT%' ORDER BY LastUpdate DESC";
$objQuery = mysqli_query($con, $strSQL);
while ($objResult = mysqli_fetch_array($objQuery)) {
    $TYPE = $objResult['TYPE'];
    $MODEL = $objResult['MODEL'];

    // echo $TYPE;
    $strSQL2 = "SELECT DISTINCT TYPE,
    (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `LINE` = '$CENTER' AND MODEL LIKE '$MODEL' AND TYPE = '$TYPE' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$DATE_SHIFT%' AND JUDGEMENT LIKE 'PASS') AS PASS,
    (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `LINE` = '$CENTER' AND MODEL LIKE '$MODEL' AND TYPE = '$TYPE' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$DATE_SHIFT%' AND JUDGEMENT LIKE 'FAIL') AS FAIL,
    (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `LINE` = '$CENTER' AND MODEL LIKE '$MODEL' AND TYPE = '$TYPE' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$DATE_SHIFT%' AND JUDGEMENT LIKE 'BLANK') AS BLANK,
    (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `LINE` = '$CENTER' AND MODEL LIKE '$MODEL' AND TYPE = '$TYPE' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$DATE_SHIFT%' AND JUDGEMENT LIKE '') AS 'NULL',
    (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `LINE` = '$CENTER' AND MODEL LIKE '$MODEL' AND TYPE = '$TYPE' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$DATE_SHIFT%') AS 'TOTAL',MODEL
    FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `LINE` = '$CENTER' AND SHIFT = '$SHIFT' AND SHIFT_DATE = '$DATE_SHIFT'";
    $objQuery2 = mysqli_query($con, $strSQL2);
    while ($objResult2 = mysqli_fetch_array($objQuery2)) {
        $PASS = $objResult2['PASS'];
        $FAIL = $objResult2['FAIL'];
        $BLANK = $objResult2['BLANK'];
        $TOTAL = $objResult2['TOTAL'];
    }
    $TYPE = $objResult['TYPE'];
    if (isset($PASS) && $PASS != '0' && $PASS == $TOTAL) {
        $TEXT = 'PASS';
        $STATUS = 'success';
    } else if (isset($FAIL) && $FAIL != '0') {
        $TEXT = 'FAIL';
        $STATUS = 'danger';
    } else if (!empty($BLANK) && $BLANK != '0') {
        $TEXT = 'ON PROCESS';
        $STATUS = 'warning';
    } else if ($MODEL == 'NO PRODUCTION') {
        $TEXT = '-';
        $STATUS = '';
    } else {
        $TEXT = 'ON PROCESS';
        $STATUS = 'warning';
    }

    $CHECK = '';
    if ($PASS != null || $FAIL != null || $BLANK != null || $PASS > 0 || $PASS <> 0) {
        $CHECK = 'DATA';
        array_push(
            $array_value,
            array(
                'use_TYPE' => '<a id="' . $TYPE . '" href="#" name="' . $MODEL . '" onclick="click_value(this.id,this.name)"><b>' . $TYPE . '</b></a>',
                'use_model' => $MODEL,
                'use_PASS' => $PASS,
                'use_FAIL' => $FAIL,
                'use_BLANK' => $BLANK,
                'use_TOTAL' => $TOTAL,
                'use_TEXT' => $TEXT,
                'use_STATUS' => $STATUS,
            )
        );
    }
}

if ($CHECK != 'DATA') {
    $strSQL = "SELECT * FROM `$tbl_item` WHERE `MODEL` LIKE '$MODEL' AND `LINE` LIKE '$LINE' AND `LastUpdate` LIKE '%$DATE_SHIFT%' ORDER BY `$tbl_item`.`ID` DESC LIMIT 1";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    if ($objResult['VALUE1'] == "NO PRODUCTION") {
        $TXT = "NO PRODUCTION";
    } else {
        $TXT = "NO DATA";
    }
    array_push(
        $array_value,
        array(
            'use_TYPE' => $TXT,
            'use_model' => "NO PRODUCTION",
            'use_PASS' => '-',
            'use_FAIL' => '-',
            'use_BLANK' => '-',
            'use_TOTAL' => '-',
            'use_TEXT' => '-',
            'use_STATUS' => 'default',
        )
    );
    // break;
}
echo json_encode($array_value);
