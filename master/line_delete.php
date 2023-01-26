<?php

include("connect.php");
// include("connectLine.php");

$id = $_POST['id'];

$sql_data = "SELECT * FROM `startup_line` WHERE ID = '$id'";
$query_data = mysqli_query($con, $sql_data);
$row_data = mysqli_fetch_array($query_data, MYSQLI_ASSOC);
$line = $row_data["LINE"];

$sql = "DELETE FROM `startup_line` WHERE ID = '$id'";

if (mysqli_query($con, $sql)) {
    // $sql_deline = "DELETE FROM `checkin_production_line` WHERE `line_name` = '$line'";
    // mysqli_query($conLine, $sql_deline);

    $sql_del_target = "DELETE FROM `target_shift` WHERE `LINE` = '$line'";
    mysqli_query($con, $sql_del_target);

    // $sql_del_target_day = "DELETE FROM `target_day` WHERE `LINE` = '$line'";
    // mysqli_query($con, $sql_del_target_day);
    echo 'success';
} else {
    echo 'problem';
}
