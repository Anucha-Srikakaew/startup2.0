<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$sql = "SELECT DISTINCT `BIZ` FROM `item` ORDER BY `BIZ` DESC";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($row);
