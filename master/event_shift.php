<?php

include("connect.php");
// header('Content-Type: application/json; charset=utf-8');

// LINK LINE NAME ALL
$SQL_LINE = "SELECT `LINE` FROM startup_line";
$query_line = mysqli_query($con, $SQL_LINE);
while ($row_line = mysqli_fetch_array($query_line, MYSQLI_ASSOC)) {
    $sql_day = "SELECT LINE FROM target_shift WHERE LINE = '" . $row_line["LINE"] . "'";
    $query_day = mysqli_query($con, $sql_day);
    $row_day = mysqli_fetch_array($query_day, MYSQLI_ASSOC);
    if (empty($row_day)) {
        $sql_insert_day = "INSERT INTO `target_shift` (`LINE`, `TARGET1`, `TARGET2`, `TARGET3`, `START_TIME_SHIFT_DAY`, `START_TIME_SHIFT_NIGHT`, `TARGET_TIME_SHIFT_DAY`, `TARGET_TIME_SHIFT_NIGHT`, `SHIFT_DATE`)  
        VALUE ('" . $row_line["LINE"] . "', '30', '20', '20', '08:31:00', '20:31:00', '20:30:00', '08:30:00', NOW())";
        mysqli_query($con, $sql_insert_day);
    }
}

// SHIFT TABLE SHIFT
// $sql_shift = "UPDATE `target_shift` SET `target_shift`.`SHIFT_DATE`=NOW() WHERE `target_shift`.`TARGET_TIME_SHIFT_NIGHT` <= curtime()";
// mysqli_query($con, $sql_shift);
