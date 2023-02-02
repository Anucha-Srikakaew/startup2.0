<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$FACTORY = $_POST['FACTORY'];
$TYPE = $_POST['TYPE'];

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
        WHERE `FACTORY` LIKE '%$FACTORY%' AND `TYPE` LIKE '%$TYPE%'";

$query = mysqli_query($con, $sql);
$row = mysqli_fetch_all($query, MYSQLI_ASSOC);
echo json_encode($row);
