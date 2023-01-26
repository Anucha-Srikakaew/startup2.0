<?php
include("connect.php");

$model = $_POST["model"];
$center = $_POST["center"];
$biz = $_POST["biz"];

$sql = "INSERT INTO `model_center`(`BIZ`, `CENTER`, `MODEL`, `Lastupdate`) VALUES ('$biz','$center','$model',NOW())";

if (mysqli_query($con, $sql)) {
    echo '1';
} else {
    echo '0';
}
