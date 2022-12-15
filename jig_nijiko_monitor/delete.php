<?php
include("connect.php");

$table = $_POST["table"];
$id = $_POST["id"];

$sql = "DELETE FROM `$table` WHERE `ID` = '$id'";

if(mysqli_query($con, $sql)){
    echo "success";
}else{
    echo "query error";
}