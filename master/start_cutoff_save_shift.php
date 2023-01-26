<?php

include("connect.php");

$sql = "UPDATE `target_shift` SET 
`TARGET1` = '" . $_POST["target1"] . "', 
`TARGET2` = '" . $_POST["target2"] . "', 
`TARGET3` = '" . $_POST["target3"] . "', 
`START_TIME_SHIFT_DAY` = '" . $_POST["TimeStartDay"] . "', 
`START_TIME_SHIFT_NIGHT` = '" . $_POST["TimeStartNight"] . "', 
`TARGET_TIME_SHIFT_DAY` = '" . $_POST["TimeTargetDay"] . "', 
`TARGET_TIME_SHIFT_NIGHT` = '" . $_POST["TimeTargetNight"] . "',
`SHIFT_DATE` = '" . $_POST["shift_date"] . "'
WHERE `ID` = '" . $_POST["id"] . "'";

if (mysqli_query($con, $sql)) {
    echo 'ok';
} else {
    echo 'no';
}
