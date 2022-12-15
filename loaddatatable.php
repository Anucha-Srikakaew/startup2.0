<?php
require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");
// header('Content-type: application/json');
$array_value = array();
$count = 1;
$CHECK = '';

if (isset($_POST['PROCESS'])) {
    // $PROCESS = $_POST['PROCESS'];
    $DATE = $_POST['DATE'];
    $DATE_SHIFT = $_POST['DATE_SHIFT'];
    $MODEL = $_POST['MODEL'];
    $LINE = $_POST['LINE'];
    $TYPE = $_POST['TYPE'];
    $PERIOD = $_POST['PERIOD'];
    $count = 1;
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

    // $strSQL = "SELECT DISTINCT PROCESS,MODEL,SHIFT,LastUpdate FROM `$tbl_item` 
    // WHERE LINE = '$LINE' AND TYPE = '$TYPE' AND MODEL LIKE '$MODEL'AND SHIFT_DATE 
    // LIKE '$DATE_SHIFT%' GROUP BY PROCESS ORDER BY ID ASC";

    $strSQL = "SELECT DISTINCT PROCESS FROM `$tbl_item` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND TYPE = '$TYPE' AND MODEL LIKE '$MODEL' $query_shift_date1 ORDER BY ID ASC";
    $PROCESS = array();
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        // $LastUpdate = date_create($objResult['LastUpdate']);
        // $LastUpdate = date_format($LastUpdate, "Y-m-d");
        // $PROCESS[] = $objResult['PROCESS'];
        array_push($PROCESS, $objResult['PROCESS']);
        // $MODEL_SQL2 = $objResult['MODEL'];
        // $objResult['SHIFT'];
        // $objResult['LastUpdate'];
    }
    if (isset($PROCESS)) {
        $i = 0;

        foreach ($PROCESS as $PROCESS_NAME) {
            $PROCESS_NAME = $PROCESS_NAME;

            $strSQL = "SELECT `ID`,`VALUE1`,TYPE,`MODEL`,
            (SELECT COUNT(*) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `JUDGEMENT` LIKE 'PASS' AND LINE = '$LINE' AND MODEL LIKE '$MODEL' AND PROCESS = '$PROCESS_NAME' AND TYPE = '$TYPE' $query_shift_date) AS PASS,
            (SELECT COUNT(*) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `JUDGEMENT` LIKE 'FAIL' AND LINE = '$LINE' AND MODEL LIKE '$MODEL' AND PROCESS = '$PROCESS_NAME' AND TYPE = '$TYPE' $query_shift_date) AS FAIL,
            (SELECT COUNT(*) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `JUDGEMENT` LIKE 'BLANK' AND LINE = '$LINE' AND MODEL LIKE '$MODEL' AND PROCESS = '$PROCESS_NAME' AND TYPE = '$TYPE' $query_shift_date) AS BLANK,
            (SELECT COUNT(*) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND `JUDGEMENT` LIKE '' AND LINE = '$LINE' AND MODEL LIKE '$MODEL' AND PROCESS = '$PROCESS_NAME' AND TYPE = '$TYPE' $query_shift_date) AS 'NULL',
            COUNT(*) AS TOTAL 
            FROM `$tbl_item` 
            WHERE `PERIOD` = '$PERIOD' 
            AND PROCESS = '$PROCESS_NAME' 
            AND LINE = '$LINE' 
            AND MODEL LIKE '$MODEL' 
            AND TYPE = '$TYPE' 
            $query_shift_date
            GROUP BY PROCESS = '$PROCESS_NAME'
            ORDER BY LastUpdate DESC";
            // echo '<br>';
            // if($i==0){
            //     echo $strSQL;
            // }

            ////

            $objQuery = mysqli_query($con, $strSQL);
            while ($objResult = mysqli_fetch_array($objQuery)) {
                // print_r($objResult);

                $strSQL2 = "SELECT REMARK FROM $tbl_item WHERE `PERIOD` = '$PERIOD' AND PROCESS = '$PROCESS_NAME' AND TYPE LIKE '$TYPE' AND LINE = '$LINE' $query_shift_date ORDER BY LastUpdate DESC";
                $objQuery2 = mysqli_query($con, $strSQL2);
                $objResult2 = mysqli_fetch_array($objQuery2);

                $PASS = $objResult['PASS'];
                $FAIL = $objResult['FAIL'];
                $BLANK = $objResult['BLANK'];
                $TOTAL = $objResult['TOTAL'];
                $VALUE1 = $objResult['VALUE1'];
                $MODEL_SQL = $objResult['MODEL'];
                $REMARK2 = $objResult2['REMARK'];
                $TYPE_SQL = $objResult['TYPE'];
                $ID = $objResult['ID'];
                $count++;
            }
            if (isset($TYPE_SQL)) {
                $TEXT = '';
                $STATUS = '';
                if ($VALUE1 == 'NO PRODUCTION') {
                    $PROCESS_NAME = 'NO PRODUCTION';
                    $PASS = '-';
                    $FAIL = '-';
                    $BLANK = '-';
                    $TOTAL = '-';
                    $STATUS = '';
                    $TEXT = '-';
                } else if ($PASS == $TOTAL) {
                    $STATUS = 'success';
                    $TEXT = 'PASS';
                    // echo "IN2";
                } else if ($PASS < $TOTAL) {
                    $STATUS = 'warning';
                    $TEXT = 'ON PROGRESS';
                    if ($FAIL > 0) {
                        $STATUS = 'danger';
                        $TEXT = 'FAIL';
                        // $check += 1;
                    }
                }

                if ($TYPE == $TYPE_SQL && !empty($TYPE_SQL)) {
                    if ($MODEL_SQL == $MODEL) {
                        $CHECK = 'DATA';
                        array_push(
                            $array_value,
                            array(
                                'use_STATUS' => $STATUS,
                                'use_PROCESS_NAME' => "<a class='text-dark' href='visual_item.php?LINE=" . $LINE . "&PROCESS=" . $PROCESS_NAME . "&MODEL=" . $MODEL . "&ID_PROCESS=" . $i . "&TYPE=" . $TYPE . "&DATE_SHIFT=" . $DATE_SHIFT . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&PERIOD=" . $PERIOD . "'>" . $PROCESS_NAME . "</a>",
                                'use_TYPE' => 'check',
                                'use_PASS' => $PASS,
                                'use_FAIL' => $FAIL,
                                'use_BLANK' => $BLANK,
                                'use_TOTAL' => $TOTAL,
                                'use_TEXT' => $TEXT,
                            )
                        );
                    }
                }
                $i++;
                // }
            }
            // continue;
        }
    }
}
// }
if (empty($TYPE_SQL)) {
    array_push(
        $array_value,
        array(
            'use_PROCESS_NAME' => 'NO DATA',
            'use_PASS' => '-',
            'use_FAIL' => '-',
            'use_BLANK' => '-',
            'use_TOTAL' => '-',
            'use_VALUE' => '-',
            'use_REMARK' => '-',
            'use_TEXT' => '-',
            'use_STATUS' => 'default',

        )
    );
} else {
}
echo json_encode($array_value);
