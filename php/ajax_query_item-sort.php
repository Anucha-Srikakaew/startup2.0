<?php

include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$BIZ = $_POST["BIZ"];
$FACTORY = $_POST["FACTORY"];
$LINE = $_POST["LINE"];
$MODEL = $_POST["MODEL"];

$sql = "SET @rank=0;";
mysqli_query($con, $sql);
if ($BIZ != '' && $FACTORY != '' && $LINE != '' && $MODEL != '') {
    $sql = "SELECT @rank:=@rank+1 AS DT_RowId,
        `ID` ,
        `LINE` ,
        `TYPE` ,
        `DRAWING`  ,
        `MODEL` ,
        `PROCESS` ,
        `PICTURE` ,
        `ITEM` ,
        `SPEC_DES` ,
        `MIN` ,
        `MAX` ,
        `SPEC` ,
        `PIC` ,
        `ID`
        FROM `item`
        WHERE `BIZ` LIKE '%$BIZ%'
        AND `FACTORY` LIKE '%$FACTORY%'
        AND `LINE` LIKE '%$LINE%'
        AND `MODEL` LIKE '%$MODEL%'
        ORDER BY `NUM_ORDER` ASC";
} else {
    $sql = "SELECT @rank:=@rank+1 AS DT_RowId ,
        `ID` ,
        `LINE` ,
        `TYPE` ,
        `DRAWING`  ,
        `MODEL` ,
        `PROCESS` ,
        `PICTURE` ,
        `ITEM` ,
        `SPEC_DES` ,
        `MIN` ,
        `MAX` ,
        `SPEC` ,
        `PIC` ,
        `ID`
        FROM `item`
        LIMIT 50
        ORDER BY `NUM_ORDER` ASC";
}

$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
$output['data'] = $row;
echo json_encode($output);
