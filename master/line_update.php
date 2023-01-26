<?php

include("connect.php");

$type = $_POST["type"];
$id = $_POST["id"];

$sql = "UPDATE `startup_line` SET `TYPE`='$type', `LastUpdate` = NOW() WHERE `ID` = '$id'";

if (mysqli_query($con, $sql)) {
    echo '1';
} else {
    echo '0';
}
