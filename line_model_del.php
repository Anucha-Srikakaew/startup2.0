<?php

include("connect.php");

$id = $_POST["id"];

$sql = "DELETE FROM `model_center` WHERE ID = '$id'";

if (mysqli_query($con, $sql)) {
    echo 1;
} else {
    echo 0;
}
