<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$sql = "SELECT DISTINCT `SPEC` FROM `item` ORDER BY `SPEC` DESC";
$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($row);
