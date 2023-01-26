<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$sql = '';
foreach ($_POST['data'] as $key => $data) {
    $id = $data['ID'];
    $sql .= "UPDATE `item` SET `NUM_ORDER`='$key' WHERE `ID` = '$id';";
    // mysqli_query($con, $sql);
}
// print_r($_POST['data']);
// echo $sql;

if (mysqli_multi_query($con, $sql)) {
    while (mysqli_more_results($con)) {
        mysqli_next_result($con);
    }
    
    include('ajax_query_item-sort.php');
}
