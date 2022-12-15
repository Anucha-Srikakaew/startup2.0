<?php

include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

// diff time
function DateDiff($strDate1, $strDate2)
{
    return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
}

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

function searchForIdCon1($id, $array)
{
    foreach ($array as $key => $val) {
        if ($val['CONFIRM1'] === $id) {
            return $key;
        }
    }
    return null;
}

function searchForIdCon2($id, $array)
{
    foreach ($array as $key => $val) {
        if ($val['CONFIRM2'] === $id) {
            return $key;
        }
    }
    return null;
}

function searchForIdCon3($id, $array)
{
    foreach ($array as $key => $val) {
        if ($val['CONFIRM3'] === $id) {
            return $key;
        }
    }
    return null;
}

function searchForIdStatus($id, $array)
{
    foreach ($array as $key => $val) {
        if ($val['STATUS'] === $id) {
            return $key;
        }
    }
    return null;
}

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$BIZ = $_POST['BIZ'];
$COUNTRY = $_POST['COUNTRY'];
$DAY = $_POST['DAY'];
$FACTORY = $_POST['FACTORY'];
$PERIOD = $_POST['PERIOD'];
$SHIFT = $_POST['SHIFT'];
$SHIFT_DATE = $_POST['SHIFT_DATE'];
$WEEK = $_POST['WEEK'];


// check time get data from table.
if ($PERIOD == 'SHIFT' || $PERIOD == 'DAY') {
    if ($PERIOD == 'DAY') {
        $SHIFT_DATE = date("Y-m-d", strtotime("-1 days", strtotime($DAY)));
    }

    if (DateDiff($SHIFT_DATE, date("Y-m-d")) > 3) {
        $tbl_item = 'startup_item_trace';
        $tbl_time = 'startup_time_trace';
    } else {
        $tbl_item = 'startup_item';
        $tbl_time = 'startup_time';
    }

    $start_date = $SHIFT_DATE;
    $end_date = $SHIFT_DATE;
} else {
    $tbl_item = 'startup_item';
    $tbl_time = 'startup_time';
    $date_arr = explode("-", $WEEK);
    $start_date = getStartAndEndDate($date_arr[0], str_replace('W', '', $date_arr[1]))[0];
    $end_date = getStartAndEndDate($date_arr[0], str_replace('W', '', $date_arr[1]))[1];
}

$output = array();
$i = 0;
$data = array();
$strSQL = "SELECT `LINE`,`TYPE` 
FROM `startup_line` 
WHERE `COUNTRY` = '$COUNTRY' AND `FACTORY` = '$FACTORY' AND `BIZ` = '$BIZ'
ORDER BY `LINE` ASC ";
$objQuery = mysqli_query($con, $strSQL);
while ($objResult = mysqli_fetch_array($objQuery)) {
    $LINE = $objResult["LINE"];
    $TYPE = $objResult["TYPE"];
    $WHERE_STARTUP = "AND `PERIOD` = '$PERIOD' AND `LINE` = '$LINE' AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'";
    $WHERE_STARTUP2 = "`PERIOD` = '$PERIOD' AND `LINE` = '$LINE' AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'";
    $sql = "SELECT `LINE`,`LastUpdate`,`SHIFT_DATE`,`VALUE1`,
            (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'PASS' $WHERE_STARTUP) AS PASS,
            (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'FAIL' $WHERE_STARTUP) AS FAIL,
            (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'BLANK' $WHERE_STARTUP) AS BLANK,
            (SELECT COUNT(`ID`) FROM `$tbl_item` WHERE `JUDGEMENT` LIKE '' $WHERE_STARTUP) AS 'NULL',
            COUNT(`ID`) AS TOTAL
            FROM `$tbl_item`
            WHERE $WHERE_STARTUP2
            GROUP BY `LINE`
            ORDER BY `SHIFT_DATE` DESC";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

    $PASS = intval($row['PASS']);
    $TOTAL = intval($row['TOTAL']);

    if ($TYPE == 'PRODUCTION') {
        $link = '<a href="visual_line.php?LINE=' . $LINE . '&DATE=' . $SHIFT_DATE . '&SHIFT=' . $SHIFT . '&DATE_SHIFT=' . $SHIFT_DATE . '&BIZ=' . $BIZ . '&PERIOD=' . $PERIOD . '" class="text-dark"><h4><b>' . $LINE . '</b></h4></a>';
    } else {
        $link = '<a href="visual_center.php?CENTER=' . $LINE . '&BIZ=' . $BIZ . '&PERIOD=' . $PERIOD . '" class="text-dark"><h4><b>' . $LINE . '</b></h4></a>';
    }

    $sql = "SELECT `CONFIRM1`,`CONFIRM2`,`CONFIRM3`, `STATUS`
            FROM `$tbl_time` 
            WHERE $WHERE_STARTUP2
            ORDER BY ID DESC";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_all($query, MYSQLI_ASSOC);

    if (searchForIdStatus('NO PRODUCTION', $row) === null) {
        if ($TOTAL != 0) {
            if (searchForIdCon1("", $row) === null && $PASS == $TOTAL) {
                $status = '<p><img src="framework/img/Glight.png" width="50"></p>';
                if (searchForIdCon2("", $row) === null) {
                    $status = '<p><img src="framework/img/Glight.png" width="50"></p>';
                    if (searchForIdCon3("", $row) === null) {
                        $status = '<p><img src="framework/img/Glight.png" width="50"></p>';
                        $status .= '<p>GOOD</p>';
                    } else {
                        $status = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                        $status .= '<p>PRODUCTION</p>';
                    }
                } else {
                    $status = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                    $status .= '<p>SUPERVISIOR</p>';
                }
            } else {
                $sql = "SELECT `CONFIRM1`,`CONFIRM2`,`CONFIRM3`, `STATUS`
                FROM `$tbl_time` 
                WHERE $WHERE_STARTUP2
                ORDER BY ID DESC";
                $query = mysqli_query($con, $sql);
                $row = mysqli_fetch_all($query, MYSQLI_ASSOC);

                $status = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                $status .= '<p>TECHNICIAN</p>';
            }
        } else {
            $sql = "SELECT `ID`
                    FROM `item` 
                    WHERE `LINE` = '$LINE' AND `PERIOD` = '$PERIOD'
                    ORDER BY ID DESC";
            $query = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

            if (isset($row)) {
                $PASS = '-';
                $TOTAL = '-';
                $status = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                $status .= '<p>****</p>';
                $TOTAL = '<b class="text-secondary">NO STARTUP</b>';
            } else {
                $PASS = '-';
                $TOTAL = '-';
                $status = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                $status .= '<p>****</p>';
                $TOTAL = '<b class="text-secondary">NO ITEM</b>';
            }
        }
    } else {
        $status = '<p><img src="framework/img/Wlight.png" width="50"></p>';
        $status .= '<p>****</p>';
        $TOTAL = '<b class="text-secondary">NO PRODUCTION</b>';
    }

    if ($i % 2 == 0 && $i > 0) {
        $output[] = array_merge($data[0], $data[1]);

        $data = array();
        $sub = array(
            $link, $PASS, $TOTAL, $status
        );
        $data[] = $sub;
    } else {
        $sub = array(
            $link, $PASS, $TOTAL, $status
        );
        $data[] = $sub;
    }
    $i++;
}

echo json_encode($output);
