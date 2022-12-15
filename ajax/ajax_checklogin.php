<?php

include('../connect.php');
date_default_timezone_set("Asia/Bangkok");
session_start();

if (isset($_POST)) {
    $output = array();
} else {
    $output = $_SESSION;
}

echo json_encode($output);