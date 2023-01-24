<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$sql = "SELECT `ID`, 
        `COUNTRY`, 
        `FACTORY`, 
        `MEMBER_ID`, 
        `NAME`, 
        `PASSWORD`, 
        `TYPE`, 
        `SHIFT`, 
        `LINE`, 
        `BIZ`, 
        `LastUpdate` 
        FROM `member` 
        WHERE 1";

$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($row);