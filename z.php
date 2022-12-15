<?php

include("connectLine.php");
include("connect.php");
header('Content-Type: application/json; charset=utf-8');

// $sql = "SELECT * FROM `startup_line`";
// $query = mysqli_query($con, $sql);
// while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
//     $line = $row["LINE"];
//     $sqlLine = "SELECT * FROM `target_day` WHERE `LINE` = '$line'";
//     $queryLine = mysqli_query($con, $sqlLine);
//     $rowLine = mysqli_fetch_array($queryLine);
//     if (empty($rowLine)) {
//         // print_r($rowLine);
//         $sql_inserrt = "insert into `target_day` (`LINE`) values ('$line')";
//         mysqli_query($con, $sql_inserrt);
//     }
// }

// $sql2 = "SELECT * FROM `target_shift`";
// $query2 = mysqli_query($con, $sql2);
// while ($row2 = mysqli_fetch_array($query2)) {
//     $line = $row2["LINE"];
//     $sql = "SELECT * FROM `startup_line` WHERE LINE = '$line'";
//     $query = mysqli_query($con, $sql);
//     $row = mysqli_fetch_array($query);
//     if (empty($row)) {
//         $sql_del_target = "DELETE FROM `target_shift` WHERE `LINE` = '$line'";
//         mysqli_query($con, $sql_del_target);
//     }
// }

// $sql2 = "SELECT * FROM `target_day`";
// $query2 = mysqli_query($con, $sql2);
// while ($row2 = mysqli_fetch_array($query2)) {
//     $line = $row2["LINE"];
//     $sql = "SELECT * FROM `startup_line` WHERE LINE = '$line'";
//     $query = mysqli_query($con, $sql);
//     $row = mysqli_fetch_array($query);
//     if (empty($row)) {
//         $sql_del_target = "DELETE FROM `target_day` WHERE `LINE` = '$line'";
//         mysqli_query($con, $sql_del_target);
//     }
// }
