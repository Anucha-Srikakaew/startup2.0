<?php

include("connect.php");
// include("connectLine.php");

$line = $_POST['line'];
$LastUpdate = $_POST['LastUpdate'];
$biz = $_POST['biz'];
$type = $_POST['type'];

$sql = "insert into `startup_line` (`BIZ`, `LINE` ,`TYPE` ,`LastUpdate`) values ('$biz', '$line' ,'$type', '$LastUpdate')";
if (mysqli_query($con, $sql)) {

    // $sql_inserrt = "insert into `checkin_production_line` (`line_name`) values ('$line')";
    // mysqli_query($conLine, $sql_inserrt);

    $sql_inserrt2 = "insert into `target_shift` (`LINE`,`TARGET1`,`TARGET2`,`TARGET3`,`START_TIME_SHIFT_DAY`,`START_TIME_SHIFT_NIGHT`,`TARGET_TIME_SHIFT_DAY`,`TARGET_TIME_SHIFT_NIGHT`,`SHIFT_DATE`) values ('$line', '30','20','20','08:31:00','00:30:00','20:30:00','08:30:00',NOW())";
    mysqli_query($con, $sql_inserrt2);
    
    echo 'success';
} else {
    echo 'problem';
}
