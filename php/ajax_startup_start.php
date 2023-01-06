<?php
include('../connect.php');
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
    } else {
        $startup = false;
    }
} else {
    $startup = true;
}

if ($startup == true) {
    $sql = "SELECT 
            `ID`, 
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
            `PIC`, 
            `PERIOD`, 
            `LastUpdate` 
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
    $response['response'] = true;
    $response['message'] = 'Startup haved data.';
}

$response['data'] = array(
    'START_DATE' => $START_DATE, 
    'END_DATE' => $END_DATE,
    'SHIFT' => $SHIFT,
);

echo json_encode($response);
