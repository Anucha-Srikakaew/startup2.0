<?php
include("connect.php");

$sql = "select LINE,ID from item where LINE LIKE '%SOLDERING%'";
$query = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
    print_r($row);
}