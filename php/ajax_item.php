<?php

include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$BIZ = $_POST["BIZ"];
$FACTORY = $_POST["FACTORY"];
$LINE = $_POST["LINE"];
$MODEL = $_POST["MODEL"];
$PERIOD = $_POST["PERIOD"];
$PROCESS = $_POST["PROCESS"];
$SPEC = $_POST["SPEC"];
$TYPE = $_POST["TYPE"];

$sql = "SELECT `ID` ,
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
        WHERE BIZ LIKE '%$BIZ%'
        AND FACTORY LIKE '%$FACTORY%'
        AND LINE LIKE '%$LINE%'
        AND MODEL LIKE '%$MODEL%'
        AND PERIOD LIKE '%$PERIOD%'
        AND PROCESS LIKE '%$PROCESS%'
        AND SPEC LIKE '%$SPEC%'
        AND TYPE LIKE '%$TYPE%'";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);

echo json_encode($row);
