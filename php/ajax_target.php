<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");
$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$BIZ = $_POST['BIZ'];
$COUNTRY = $_POST['COUNTRY'];
$FACTORY = $_POST['FACTORY'];
$LINE = $_POST['LINE'];
$sql = 'SELECT `ID`, 
`COUNTRY`, 
`FACTORY`, 
`BIZ`, 
`LINE`, 
`TARGET1`, 
`TARGET2`, 
`TARGET3`, 
`START_TIME_SHIFT_DAY`, 
`START_TIME_SHIFT_NIGHT`, 
`TARGET_TIME_SHIFT_DAY`, 
`TARGET_TIME_SHIFT_NIGHT`, 
`SHIFT_DATE` 
FROM `target_shift` 
WHERE `COUNTRY` ="' . $COUNTRY . '" AND `FACTORY`="' . $FACTORY . '" AND `BIZ`="' . $BIZ . '" AND `LINE`="' . $LINE . '"';
$query = mysqli_query($con, $sql);
$output = mysqli_fetch_array($query, MYSQLI_ASSOC);
echo json_encode($output);
