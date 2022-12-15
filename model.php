<?php

require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");

// print_r($_POST);

if (isset($_POST["PERIOD"])) {
    $PERIOD = $_POST["PERIOD"];
    if ($PERIOD == '2SHIFT') {
        $PERIOD = 'DAY';
    } else if ($PERIOD == '1SHIFT') {
        $PERIOD = 'SHIFT';
    }
} else {
    $PERIOD = '';
}

if (isset($_POST['LINE']) && empty($_POST['TYPE'])) {
    $LINE = $_POST['LINE'];
    $strSQL = "SELECT DISTINCT `TYPE` FROM `item` WHERE `LINE` = '$LINE' AND `PERIOD` = '$PERIOD'";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $TYPE[] = $objResult['TYPE'];
    }
    echo json_encode($TYPE);
} else if (isset($_POST['TYPE']) && isset($_POST['LINE'])) {
    $LINE = $_POST['LINE'];
    $type = $_POST['TYPE'];
    $strSQL = "SELECT DISTINCT MODEL FROM `item` WHERE `LINE` = '$LINE' AND `TYPE` = '$type' AND `PERIOD` LIKE '%$PERIOD%'";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $MODEL[] = $objResult['MODEL'];
    }
    echo json_encode($MODEL);
} else if (isset($_POST['LINE_TYPE'])) {
    $LINE = $_POST['LINE'];
    $strSQL = "SELECT DISTINCT TYPE FROM `item` WHERE `LINE` = '$LINE'";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $TYPE2[] = $objResult['TYPE'];
    }
    echo json_encode($TYPE2);
} else if (isset($_POST['LINE_CENTER'])) {
    /// check center
    $LINE = $_POST['LINE_CENTER'];
    $strSQL = "SELECT `TYPE` FROM `startup_line` WHERE `LINE` = '$LINE'";
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    $TYPE = $objResult['TYPE'];
    echo $TYPE;
    // echo json_encode($TYPE);
} else {
    $LINE = array();
    $strSQL = "SELECT DISTINCT `LINE` FROM `item` WHERE `PERIOD` LIKE '%$PERIOD%' ORDER BY `LINE`";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $LINE[] = $objResult['LINE'];
    }
    echo json_encode($LINE);
}
