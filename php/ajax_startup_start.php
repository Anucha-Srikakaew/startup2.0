<?php
include('../connect.php');
$con56 = mysqli_connect('43.72.52.56', 'root', '123456*', 'im');
date_default_timezone_set("Asia/Bangkok");

function getStartAndEndDate($year, $week)
{
    $week_start = new DateTime();
    $week_start->setISODate($year, $week);
    $return[0] = $week_start->format('Y-m-d');
    $time = strtotime($return[0], time());
    $time += 6 * 24 * 3600;
    $return[1] = date('Y-m-d', $time);
    return $return;
}

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$PERIOD = $_POST['PERIOD'];
$LINE = $_POST['LINE'];
$TYPE = $_POST['TYPE'];
$MODEL = $_POST['MODEL'];
$COUNTRY = $_POST['COUNTRY'];
$FACTORY = $_POST['FACTORY'];
$BIZ = $_POST['BIZ'];
$STARTUP_EMP_ID = $_POST['STARTUP_EMP_ID'];
$SHIFT_DATE = $_POST['SHIFT_DATE'];
$SHIFT = $_POST['SHIFT'];
$WEEK = $_POST['WEEK'];

if ($PERIOD == 'SHIFT') {
    $QUERY_WHERE = "AND `SHIFT_DATE` = '$SHIFT_DATE' AND `SHIFT` = '$SHIFT'";
} else {
    if ($PERIOD == 'DAY') {
        $START_DATE = $SHIFT_DATE;
        $END_DATE = $SHIFT_DATE;
    } else {
        $date_arr = explode("-", $WEEK);
        $START_DATE = getStartAndEndDate($date_arr[0], str_replace('W', '', $date_arr[1]))[0];
        $END_DATE = getStartAndEndDate($date_arr[0], str_replace('W', '', $date_arr[1]))[1];
    }
    $QUERY_WHERE = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";
}

$sql = "SELECT `ID`, `COUNTRY`, `FACTORY`, `BIZ`, 
`LINE`, `TYPE`, `MODEL`, `REMARK`, `SHIFT_DATE`, 
`SHIFT`, `PERIOD`, `STATUS`, `STARTTIME`, `CONFIRM1`, 
`DATETIME1`, `CONFIRM2`, `DATETIME2`, `CONFIRM3`, 
`DATETIME3`, `TAKT`, `RESULT` 
FROM `startup_time`
WHERE `COUNTRY` = '$COUNTRY'
AND `FACTORY` = '$FACTORY'
AND `BIZ` = '$BIZ'
AND `LINE` = '$LINE'
AND `TYPE` = '$TYPE'
AND `MODEL` = '$MODEL'
$QUERY_WHERE
AND `PERIOD` = '$PERIOD';";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_array($query, MYSQLI_ASSOC);
if (isset($row)) {
    if ($row['STATUS'] != 'RUN') {
        $startup = true;
        $check = '1';
    } else {
        $startup = false;
        $check = '0';
    }
} else {
    $startup = true;
    $check = '1';
}

$sql = '';
if ($startup == true && $check == '1') {
    if ($TYPE == 'Torque') {
        $sql = "DELETE FROM `startup_time`
        WHERE `COUNTRY` = '$COUNTRY'
        AND `FACTORY` = '$FACTORY'
        AND `BIZ` = '$BIZ'
        AND `LINE` = '$LINE'
        AND `TYPE` = '$TYPE'
        AND `MODEL` = '$MODEL'
        AND `SHIFT_DATE` = '$SHIFT_DATE'
        AND `SHIFT` = '$SHIFT'
        AND `PERIOD` = '$PERIOD'
        AND `STATUS` = 'NO PRODUCTION';";
        $sql_line_center = "SELECT * FROM `startup_line` WHERE `LINE` = '$LINE'";
        $query_line_center = mysqli_query($con, $sql_line_center);
        $row_line_center = mysqli_fetch_array($query_line_center);
        if ($row_line_center["TYPE"] == 'CENTER') {
            $CENTER = ' CENTER';
        } else {
            $CENTER = '';
        }

        $DATE_TORQUE = date("Y-m-d", strtotime("+1 days", strtotime($START_DATE)));

        $PERIOD_DATA = 'DAY';
        $sql_select_process = "SELECT * FROM `tbl_torque_process_register` WHERE `LINENAME` LIKE '%$LINE%$CENTER%($MODEL)%'";
        $query_select_process = mysqli_query($con56, $sql_select_process);
        while ($row_select_process = mysqli_fetch_array($query_select_process, MYSQLI_ASSOC)) {
            $id_code = $row_select_process["IDCODE"];
            $sql_torque = "SELECT `id`, `IDCODE`, `RECDATE`, 
            `LINENAME`, `PROCESSID`, `GROUPS`, `MCNO`, 
            `T_MAX`, `T_MIN`, `SPEC_MAX`, `SPEC_MIN`, 
            `TORQUE_VALUE`, `PICCONDITION`, `JUDGEMENT` 
            FROM `tbl_torque_result` WHERE `ID` = (
                            SELECT MAX(`ID`) FROM `tbl_torque_result` 
                            WHERE `IDCODE` = '$id_code' AND `id` IN (SELECT `id` FROM `tbl_torque_result` WHERE `RECDATE` BETWEEN '$START_DATE 08:00:00' AND '$DATE_TORQUE 11:00:00')
                            )";
            $query_torque = mysqli_query($con56, $sql_torque);
            $row_torque = mysqli_fetch_array($query_torque);
            if (empty($row_torque)) {
                $RESULT_TORQUE = "";
            } else {
                $RESULT_TORQUE = $row_torque["TORQUE_VALUE"];
            }

            $SPEC_MIN = $row_select_process["SPECMIN"];
            $SPEC_MAX = $row_select_process["SPECMAX"];
            $PROCESSID = $row_select_process["PROCESSID"];
            $ITEM_TORQUE = "ตรวจวัดค่า Torque ใน Process ต้องอยู่ในค่าตาม Spec";
            $ITEM_DES = "ค่า Torque ต้องอยู่ระหว่าง $SPEC_MIN ถึง $SPEC_MAX";

            if ($row_torque['JUDGEMENT'] == 'OK') {
                $JUDGEMENT = "PASS";
            } else if ($row_torque['JUDGEMENT'] == 'NG') {
                $JUDGEMENT = "FAIL";
            } else {
                $JUDGEMENT = "BLANK";
            }

            $sql .= "INSERT INTO `startup_item`
            (`ID`, `COUNTRY`, `FACTORY`, `BIZ`,  `LINE`, `TYPE`, `DRAWING`, `MODEL`, `PROCESS`, `JIG_NAME`, `PICTURE`, `ITEM`, `SPEC_DES`, `MIN`, `MAX`, `SPEC`, `VALUE1`, `VALUE2`, `JUDGEMENT`, `REMARK`, `SHIFT_DATE`,`SHIFT`,`PERIOD`, `RESULT`, `LastUpdate`) 
            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$TYPE', '', '$MODEL', '$PROCESSID', '', '', '$ITEM_TORQUE', '$ITEM_DES', '$SPEC_MIN', '$SPEC_MAX', 'SHOW', '$RESULT_TORQUE', '', '$JUDGEMENT', '', '$START_DATE', '$SHIFT', '$PERIOD_DATA', '',NOW());";
        }
    } else {
        $sql = "SELECT  `ID`, `NUM_ORDER`, `COUNTRY`,  `FACTORY`,  `BIZ`,  `LINE`,  `TYPE`,  
        `DRAWING`,  `MODEL`,  `PROCESS`,  `JIG_NAME`,  `PICTURE`,  `ITEM`,  
        `SPEC_DES`,  `MIN`,  `MAX`,  `SPEC`,  `PIC`,  `PERIOD`,  `LastUpdate` 
            FROM `item` 
            WHERE `COUNTRY` = '$COUNTRY'
                AND `FACTORY` = '$FACTORY'
                AND `BIZ` = '$BIZ'
                AND `LINE` = '$LINE'
                AND `TYPE` = '$TYPE'
                AND `MODEL` = '$MODEL'";
        $query = mysqli_query($con, $sql);
        $row = mysqli_fetch_all($query, MYSQLI_ASSOC);

        $sql = "DELETE FROM `startup_time`
        WHERE `COUNTRY` = '$COUNTRY'
        AND `FACTORY` = '$FACTORY'
        AND `BIZ` = '$BIZ'
        AND `LINE` = '$LINE'
        AND `TYPE` = '$TYPE'
        AND `MODEL` = '$MODEL'
        AND `SHIFT_DATE` = '$SHIFT_DATE'
        AND `SHIFT` = '$SHIFT'
        AND `PERIOD` = '$PERIOD'
        AND `STATUS` = 'NO PRODUCTION';";
        foreach ($row as $data) {
            $NUM_ORDER = $data['NUM_ORDER'];
            $COUNTRY = $data['COUNTRY'];
            $FACTORY = $data['FACTORY'];
            $BIZ = $data['BIZ'];
            $LINE = $data['LINE'];
            $TYPE = $data['TYPE'];
            $DRAWING = $data['DRAWING'];
            $MODEL = $data['MODEL'];
            $PROCESS = $data['PROCESS'];
            $JIG_NAME = $data['JIG_NAME'];
            $PICTURE = $data['PICTURE'];
            $ITEM = $data['ITEM'];
            $SPEC_DES = $data['SPEC_DES'];
            $MIN = $data['MIN'];
            $MAX = $data['MAX'];
            $SPEC = $data['SPEC'];
            $PERIOD = $data['PERIOD'];

            $sql .= "INSERT INTO `startup_item`
                (
                `NUM_ORDER`,
                `COUNTRY`, 
                `FACTORY`, 
                `BIZ`, 
                `LINE`, 
                `TYPE`, 
                `DRAWING`, 
                `MODEL`, 
                `PROCESS`, 
                `JIG_NAME`, 
                `PICTURE`, 
                `ITEM`, 
                `SPEC_DES`, 
                `MIN`, 
                `MAX`, 
                `SPEC`, 
                `VALUE1`, 
                `VALUE2`, 
                `JUDGEMENT`, 
                `REMARK`, 
                `SHIFT_DATE`, 
                `SHIFT`, 
                `PERIOD`, 
                `RESULT`, 
                `LastUpdate`
                ) 
                VALUES (
                '$NUM_ORDER',
                '$COUNTRY', 
                '$FACTORY', 
                '$BIZ', 
                '$LINE', 
                '$TYPE', 
                '$DRAWING', 
                '$MODEL', 
                '$PROCESS', 
                '$JIG_NAME', 
                '$PICTURE', 
                '$ITEM', 
                '$SPEC_DES', 
                '$MIN', 
                '$MAX', 
                '$SPEC', 
                '', 
                '', 
                'BLANK', 
                '', 
                '$SHIFT_DATE', 
                '$SHIFT', 
                '$PERIOD', 
                '', 
                NOW()
                );";
        }
    }

    $sql .= "INSERT INTO `startup_time`(
                        `COUNTRY`,
                        `FACTORY`,
                        `BIZ`,
                        `LINE`,
                        `TYPE`,
                        `MODEL`,
                        `REMARK`,
                        `SHIFT_DATE`,
                        `SHIFT`,
                        `PERIOD`,
                        `STATUS`,
                        `STARTTIME`,
                        `CONFIRM1`,
                        `DATETIME1`,
                        `CONFIRM2`,
                        `DATETIME2`,
                        `CONFIRM3`,
                        `DATETIME3`,
                        `TAKT`,
                        `RESULT`
                        ) 
            VALUES (
                    '$COUNTRY',
                    '$FACTORY',
                    '$BIZ',
                    '$LINE',
                    '$TYPE',
                    '$MODEL',
                    '',
                    '$SHIFT_DATE',
                    '$SHIFT',
                    '$PERIOD',
                    'RUN',
                    NOW(),
                    '$STARTUP_EMP_ID',
                    NOW(),
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                    );";

    // echo $sql;
    if (mysqli_multi_query($con, $sql)) {
        $response['response'] = true;
        $response['message'] = 'Query startup complete.';
    } else {
        $response['response'] = false;
        $response['message'] = "Failed to connect to MySQL: " . $con->error;
    }
} else {
    if ($TYPE == 'Torque') {
        $sql_line_center = "SELECT * FROM `startup_line` WHERE `LINE` = '$LINE'";
        $query_line_center = mysqli_query($con, $sql_line_center);
        $row_line_center = mysqli_fetch_array($query_line_center);
        if ($row_line_center["TYPE"] == 'CENTER') {
            $CENTER = ' CENTER';
        } else {
            $CENTER = '';
        }

        $PERIOD_DATA = 'DAY';
        $DATE_TORQUE = date("Y-m-d", strtotime("+1 days", strtotime($START_DATE)));
        $sql_select_process = "SELECT * FROM `tbl_torque_process_register` WHERE `LINENAME` LIKE '%$LINE%$CENTER%($MODEL)%'";
        $query_select_process = mysqli_query($con56, $sql_select_process);
        while ($row_select_process = mysqli_fetch_array($query_select_process, MYSQLI_ASSOC)) {
            $id_code = $row_select_process["IDCODE"];
            $sql_torque = "SELECT `id`, `IDCODE`, `RECDATE`, 
            `LINENAME`, `PROCESSID`, `GROUPS`, `MCNO`, 
            `T_MAX`, `T_MIN`, `SPEC_MAX`, `SPEC_MIN`, 
            `TORQUE_VALUE`, `PICCONDITION`, `JUDGEMENT` 
            FROM `tbl_torque_result` WHERE `ID` = (
                            SELECT MAX(`ID`) FROM `tbl_torque_result` 
                            WHERE `IDCODE` = '$id_code' AND `id` IN (SELECT `id` FROM `tbl_torque_result` WHERE `RECDATE` BETWEEN '$START_DATE 08:00:00' AND '$DATE_TORQUE 11:00:00')
                            )";
            $query_torque = mysqli_query($con56, $sql_torque);
            $row_torque = mysqli_fetch_array($query_torque);
            if (empty($row_torque)) {
                $RESULT_TORQUE = "";
            } else {
                $RESULT_TORQUE = $row_torque["TORQUE_VALUE"];
            }

            $SPEC_MIN = $row_select_process["SPECMIN"];
            $SPEC_MAX = $row_select_process["SPECMAX"];
            $PROCESSID = $row_select_process["PROCESSID"];
            $ITEM_TORQUE = "ตรวจวัดค่า Torque ใน Process ต้องอยู่ในค่าตาม Spec";
            $ITEM_DES = "ค่า Torque ต้องอยู่ระหว่าง $SPEC_MIN ถึง $SPEC_MAX";

            if ($row_torque['JUDGEMENT'] == 'OK') {
                $JUDGEMENT = "PASS";
            } else if ($row_torque['JUDGEMENT'] == 'NG') {
                $JUDGEMENT = "FAIL";
            } else {
                $JUDGEMENT = "BLANK";
            }

            $strSQL = "SELECT * FROM `startup_item` 
                        WHERE `COUNTRY`= '$COUNTRY'
                                AND `FACTORY` = '$FACTORY'
                                AND `BIZ` = '$BIZ'
                                AND `PERIOD` = '$PERIOD'
                                AND `LINE` = '$LINE'
                                AND `MODEL` = '$MODEL'
                                AND `TYPE` = '$TYPE'
                                AND`PROCESS` = '$PROCESSID'
                                AND`SHIFT_DATE` = '$START_DATE'
                                AND `SHIFT` = '$SHIFT';";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);

            if (isset($objResult)) {
                $sql .= "UPDATE `startup_item` SET `VALUE1`='$RESULT_TORQUE',`JUDGEMENT`='$JUDGEMENT'
                                WHERE  `COUNTRY`= '$COUNTRY'
                                AND `FACTORY` = '$FACTORY'
                                AND `BIZ` = '$BIZ'
                                AND `PERIOD` = '$PERIOD'
                                AND `LINE` = '$LINE'
                                AND `MODEL` = '$MODEL'
                                AND `TYPE` = '$TYPE'
                                AND`PROCESS` = '$PROCESSID'
                                AND`SHIFT_DATE` = '$START_DATE'
                                AND `SHIFT` = '$SHIFT';";
            } else {
                $sql .= "INSERT INTO `startup_item`
            (`ID`, `COUNTRY`, `FACTORY`, `BIZ`,  `LINE`, `TYPE`, `DRAWING`, `MODEL`, `PROCESS`, `JIG_NAME`, `PICTURE`, `ITEM`, `SPEC_DES`, `MIN`, `MAX`, `SPEC`, `VALUE1`, `VALUE2`, `JUDGEMENT`, `REMARK`, `SHIFT_DATE`,`SHIFT`,`PERIOD`, `RESULT`, `LastUpdate`) 
            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$TYPE', '', '$MODEL', '$PROCESSID', '', '', '$ITEM_TORQUE', '$ITEM_DES', '$SPEC_MIN', '$SPEC_MAX', 'SHOW', '$RESULT_TORQUE', '', '$JUDGEMENT', '', '$START_DATE', '$SHIFT', '$PERIOD_DATA', '',NOW());";
            }
        }

        if (mysqli_multi_query($con, $sql)) {
            $response['response'] = true;
            $response['message'] = 'Query startup complete.';
        } else {
            $response['response'] = false;
            $response['message'] = "Failed to connect to MySQL: " . $con->error;
        }
    } else {
        $response['response'] = true;
        $response['message'] = 'Startup haved data.';
    }
}

$response['data'] = array(
    'START_DATE' => $START_DATE,
    'END_DATE' => $END_DATE,
    'SHIFT' => $SHIFT,
);

echo json_encode($response);
