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

function searchForId($id, $array, $masterKey)
{
    foreach ($array as $key => $val) {
        if ($val[$masterKey] == $id) {
            return $key;
        }
    }
    return '';
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
$CENTER = $_POST['CENTER'];

// check time get data from table.
if ($PERIOD == 'SHIFT' || $PERIOD == 'DAY') {
    $SHIFT_DATE = date("Y-m-d", strtotime("-1 days", strtotime($DAY)));

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
$strSQL = "SELECT `MODEL`
FROM `model_center` 
WHERE `COUNTRY` = '$COUNTRY' AND `FACTORY` = '$FACTORY' AND `BIZ` = '$BIZ' AND `CENTER` LIKE '%$CENTER%'
ORDER BY `MODEL` ASC ";
$objQuery = mysqli_query($con, $strSQL);
$arrQueryLineName = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);

$WHERE_STARTUP = "`PERIOD` = '$PERIOD' AND `LINE` = '$CENTER' AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'";

$sql = "SELECT `$tbl_item`.`MODEL`,`$tbl_item`.`LastUpdate`,`$tbl_item`.`SHIFT_DATE`,`$tbl_item`.`VALUE1`,Tbl1.`PASS`,Tbl2.`FAIL`,Tbl3.`BLANK`,Tbl4.`NULL`, COUNT(`ID`) AS TOTAL
            FROM `$tbl_item`
                LEFT JOIN (SELECT `MODEL`, COUNT(`ID`) AS `PASS` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'PASS' AND $WHERE_STARTUP GROUP BY `MODEL`) AS Tbl1 ON `$tbl_item`.`MODEL` = Tbl1.`MODEL`
                LEFT JOIN (SELECT `MODEL`, COUNT(`ID`) AS `FAIL` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'FAIL' AND $WHERE_STARTUP GROUP BY `MODEL`) AS Tbl2 ON `$tbl_item`.`MODEL` = Tbl2.`MODEL`
                LEFT JOIN (SELECT `MODEL`, COUNT(`ID`) AS `BLANK` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'BLANK' AND $WHERE_STARTUP GROUP BY `MODEL`) AS Tbl3 ON `$tbl_item`.`MODEL` = Tbl3.`MODEL`
                LEFT JOIN (SELECT `MODEL`, COUNT(`ID`) AS `NULL` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE '' AND $WHERE_STARTUP GROUP BY `MODEL`) AS Tbl4 ON `$tbl_item`.`MODEL` = Tbl4.`MODEL`
            WHERE $WHERE_STARTUP
            GROUP BY `MODEL`
            ORDER BY `SHIFT_DATE` DESC";
$query = mysqli_query($con, $sql);
$rowItem = mysqli_fetch_all($query, MYSQLI_ASSOC);

$sql = "SELECT `MODEL`, `CONFIRM1`,`CONFIRM2`,`CONFIRM3`, `STATUS`
            FROM `$tbl_time` 
            WHERE $WHERE_STARTUP
            ORDER BY ID DESC";
$query = mysqli_query($con, $sql);
$rowTime = mysqli_fetch_all($query, MYSQLI_ASSOC);

$sql = "SELECT DISTINCT `MODEL`
        FROM `item` 
        WHERE `PERIOD` = '$PERIOD' AND `LINE` = '$CENTER'
        ORDER BY ID DESC";
$query = mysqli_query($con, $sql);
$rowItemMaster = mysqli_fetch_all($query, MYSQLI_ASSOC);

foreach ($arrQueryLineName as $objResult) {
    $MODEL = $objResult["MODEL"];
    $keyItem = searchForId($MODEL, $rowItem, 'MODEL');
    $keyTime = searchForId($MODEL, $rowTime, 'MODEL');

    if ($keyTime != '' || is_numeric($keyTime) == 1) {
        $arrDataTime = $rowTime[$keyTime];
    } else {
        $arrDataTime = array('MODEL' => '', 'CONFIRM1' => '', 'CONFIRM2' => '', 'CONFIRM3' => '', 'STATUS' => '');
    }

    if ($keyItem != '' || is_numeric($keyItem) == 1) {
        $PASS = intval($rowItem[$keyItem]['PASS']);
        $TOTAL = intval($rowItem[$keyItem]['TOTAL']);
    } else {
        $PASS = 0;
        $TOTAL = 0;
    }

    $link = '<a href="visual_model.html?MODEL=' . $MODEL . '&COUNTRY=' . $COUNTRY . '&FACTORY=' . $FACTORY . '&BIZ=' . $BIZ . '&LINE=' . $CENTER . '&START_DATE=' . $start_date . '&END_DATE=' . $end_date . '&SHIFT=' . $SHIFT . '&PERIOD=' . $PERIOD . '"><h4><b>' . $MODEL . '</b></h4></a>';

    if ($arrDataTime['STATUS'] != "NO PRODUCTION") {
        if ($TOTAL != 0) {
            if ($arrDataTime['CONFIRM1'] != '' && $PASS == $TOTAL) {
                $status = '<p><img src="framework/img/Glight.png" width="50"></p>';
                if ($arrDataTime['CONFIRM2'] != '') {
                    $status = '<p><img src="framework/img/Glight.png" width="50"></p>';
                    if ($arrDataTime['CONFIRM3'] != '') {
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
                $status = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                $status .= '<p>TECHNICIAN</p>';
            }
        } else {
            if (searchForId($MODEL, $rowItemMaster, 'MODEL') != '' || is_numeric(searchForId($MODEL, $rowItemMaster, 'MODEL')) == 1) {
                $PASS = '--';
                $TOTAL = '--';
                $status = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                $status .= '<p>****</p>';
                $TOTAL = '<h4 class="text-secondary">NO STARTUP</h4>';
            } else {
                $PASS = '--';
                $TOTAL = '--';
                $status = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                $status .= '<p>****</p>';
                $TOTAL = '<h4 class="text-secondary">NO ITEM</h4>';
            }
        }
    } else {
        $status = '<p><img src="framework/img/Wlight.png" width="50"></p>';
        $status .= '<p>****</p>';
        $TOTAL = '<h4 class="text-secondary">NO PRODUCTION</h4>';
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
