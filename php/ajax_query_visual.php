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
$i = 1;
$data = array();
$strSQL = "SELECT `LINE`,`TYPE`
FROM `startup_line` 
WHERE `COUNTRY` = '$COUNTRY' AND `FACTORY` = '$FACTORY' AND `BIZ` = '$BIZ'
ORDER BY `LINE` ASC ";
$objQuery = mysqli_query($con, $strSQL);
$arrQueryLineName = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);

$WHERE_STARTUP = "`PERIOD` = '$PERIOD' AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'";

$sql = "SELECT `$tbl_item`.`LINE`,`$tbl_item`.`LastUpdate`,`$tbl_item`.`SHIFT_DATE`,`$tbl_item`.`VALUE1`,Tbl1.`PASS`,Tbl2.`FAIL`,Tbl3.`BLANK`,Tbl4.`NULL`, COUNT(`ID`) AS TOTAL
            FROM `$tbl_item`
                LEFT JOIN (SELECT `LINE`, COUNT(`ID`) AS `PASS` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'PASS' AND $WHERE_STARTUP GROUP BY `LINE`) AS Tbl1 ON `$tbl_item`.`LINE` = Tbl1.`LINE`
                LEFT JOIN (SELECT `LINE`, COUNT(`ID`) AS `FAIL` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'FAIL' AND $WHERE_STARTUP GROUP BY `LINE`) AS Tbl2 ON `$tbl_item`.`LINE` = Tbl2.`LINE`
                LEFT JOIN (SELECT `LINE`, COUNT(`ID`) AS `BLANK` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE 'BLANK' AND $WHERE_STARTUP GROUP BY `LINE`) AS Tbl3 ON `$tbl_item`.`LINE` = Tbl3.`LINE`
                LEFT JOIN (SELECT `LINE`, COUNT(`ID`) AS `NULL` FROM `$tbl_item` WHERE `JUDGEMENT` LIKE '' AND $WHERE_STARTUP GROUP BY `LINE`) AS Tbl4 ON `$tbl_item`.`LINE` = Tbl4.`LINE`
            WHERE $WHERE_STARTUP
            GROUP BY `LINE`
            ORDER BY `SHIFT_DATE` DESC";
$query = mysqli_query($con, $sql);
$rowItem = mysqli_fetch_all($query, MYSQLI_ASSOC);

$sql = "SELECT `LINE`, `CONFIRM1`,`CONFIRM2`,`CONFIRM3`, `STATUS`
            FROM `$tbl_time` 
            WHERE $WHERE_STARTUP
            -- GROUP BY `LINE`
            ORDER BY `CONFIRM3` ASC";
$query = mysqli_query($con, $sql);
$rowTime = mysqli_fetch_all($query, MYSQLI_ASSOC);

$sql = "SELECT DISTINCT `LINE`
        FROM `item`
        WHERE `PERIOD` = '$PERIOD'
        ORDER BY ID DESC";
$query = mysqli_query($con, $sql);
$rowItemMaster = mysqli_fetch_all($query, MYSQLI_ASSOC);

$data = array();
foreach ($arrQueryLineName as $key => $objResult) {
    $LINE = $objResult["LINE"];
    $TYPE = $objResult["TYPE"];
    $keyItem = searchForId($LINE, $rowItem, 'LINE');
    $keyTime = searchForId($LINE, $rowTime, 'LINE');

    if ($keyTime != '' || is_numeric($keyTime) == 1) {
        $arrDataTime = $rowTime[$keyTime];
    } else {
        $arrDataTime = array('LINE' => '', 'CONFIRM1' => '', 'CONFIRM2' => '', 'CONFIRM3' => '', 'STATUS' => '');
    }

    if ($keyItem != '' || is_numeric($keyItem) == 1) {
        $PASS = intval($rowItem[$keyItem]['PASS']);
        $TOTAL = intval($rowItem[$keyItem]['TOTAL']);
    } else {
        $PASS = 0;
        $TOTAL = 0;
    }

    if ($TYPE == 'PRODUCTION') {
        $link = '<a href="visual_line.html?COUNTRY=' . $COUNTRY . '&FACTORY=' . $FACTORY . '&BIZ=' . $BIZ . '&LINE=' . $LINE . '&START_DATE=' . $start_date . '&END_DATE=' . $end_date . '&SHIFT=' . $SHIFT . '&PERIOD=' . $PERIOD . '"><h4><b>' . $LINE . '</b></h4></a>';
    } else {
        $link = '<a href="visual2.html?CENTER=' . $LINE . '&BIZ=' . $BIZ . '&PERIOD=' . $PERIOD . '"><h4><b>' . $LINE . '</b></h4></a>';
    }

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
                        $status .= '<p>PROD.</p>';
                    }
                } else {
                    $status = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                    $status .= '<p>SUP.</p>';
                }
            } else {
                $status = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                $status .= '<p>TECH.</p>';
            }
        } else {
            if (searchForId($LINE, $rowItemMaster, 'LINE') != '' || is_numeric(searchForId($LINE, $rowItemMaster, 'LINE')) == 1) {
                $PASS = '--';
                $TOTAL = '--';
                $status = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                $status .= '<p>****</p>';
                $TOTAL = '<h5 class="text-secondary"><b>NO STARTUP</b></h5>';
            } else {
                $PASS = '--';
                $TOTAL = '--';
                $status = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                $status .= '<p>****</p>';
                $TOTAL = '<h5 class="text-secondary"><b>NO ITEM</b></h5>';
            }
        }
    } else {
        $status = '<p><img src="framework/img/Wlight.png" width="50"></p>';
        $status .= '<p>****</p>';
        $TOTAL = '<h5 class="text-secondary"><b>NO PRODUCTION</b></h5>';
    }

    if ($i % 2 == 0) {
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

    if (count($data) == 2) {
        $output[] = array_merge($data[0], $data[1]);
        $data = array();
    } else if (count($arrQueryLineName) == $i) {
        $output[] = array_merge($data[0], array(
            '', '', '', ''
        ));
    }
    $i++;
}

echo json_encode($output);
