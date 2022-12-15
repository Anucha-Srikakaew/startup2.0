<?php

include("connect.php");

// $sql = "UPDATE `target_day` SET 
// `TARGET1` = '" . $_POST["target1"] . "', 
// `TARGET2` = '" . $_POST["target2"] . "', 
// `TARGET3` = '" . $_POST["target3"] . "', 
// `START_TIME_DAY` = '" . $_POST["start_time"] . "', 
// `START_DATE_DAY` = '" . $_POST["start_date"] . "', 
// `TARGET_TIME_DAY` = '" . $_POST["target_time"] . "', 
// `TARGET_DATE_DAY` = '" . $_POST["target_date"] . "',
// `DATE` = NOW(),
// `TIME` = NOW()
// WHERE `ID` = '" . $_POST["id"] . "'";

$sql = "UPDATE `target_day` SET 
`TARGET1` = '" . $_POST["target1"] . "', 
`TARGET2` = '" . $_POST["target2"] . "', 
`TARGET3` = '" . $_POST["target3"] . "', 
`START_TIME_DAY` = '" . $_POST["start_time"] . "',
`TARGET_TIME_DAY` = '" . $_POST["target_time"] . "',
`DATE` = NOW(),
`TIME` = NOW()
WHERE `ID` = '" . $_POST["id"] . "'";

if (mysqli_query($con, $sql)) {
    echo 'ok';
} else {
    echo 'no';
}
