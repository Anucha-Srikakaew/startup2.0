<?php

$ID = $_POST['ID'];
$VALUE = $_POST['VALUE'];
$VALUE_TYPE = $_POST['VALUE_TYPE'];
$JUDGEMENT = $_POST['JUDGEMENT'];
$VALUE_TYPE = str_replace("[]", "", $VALUE_TYPE);

require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . "\STARTUP2.0\connect.php");
date_default_timezone_set("Asia/Bangkok");

$GLOBAL_NOW = date("Y-m-d H:i:s");

echo $strSQL = "UPDATE `startup_item` SET $VALUE_TYPE = '$VALUE',JUDGEMENT = '$JUDGEMENT' WHERE ID = '$ID'";
$objQuery = mysqli_query($con, $strSQL);

$sql_select = "SELECT * FROM `startup_item` WHERE `ID` = '$ID'";
$query_select = mysqli_query($con, $sql_select);
$row_select = mysqli_fetch_array($query_select);

echo $sql_update = "UPDATE `startup_time` SET `DATETIME1` = NOW() 
WHERE BIZ = '" . $row_select['BIZ'] . "' 
AND LINE = '" . $row_select['LINE'] . "' 
AND PERIOD = '" . $row_select['PERIOD'] . "' 
AND TYPE = '" . $row_select['TYPE'] . "'
AND MODEL = '" . $row_select['MODEL'] . "'
AND SHIFT_DATE = '" . $row_select['SHIFT_DATE'] . "'
AND SHIFT = '" . $row_select['SHIFT'] . "'";
$query_update = mysqli_query($con, $sql_update);
