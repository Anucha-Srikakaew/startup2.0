<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$COUNTRY = $_POST['COUNTRY'];
$FACTORY = $_POST['FACTORY'];
$BIZ = $_POST['BIZ'];
if (isset($_POST['SEARCH'])) {
    $SEARCH = $_POST['SEARCH'];
    if ($SEARCH == 'LINE') {
        $PERIOD = $_POST['PERIOD'];
        $strSQL = "SELECT DISTINCT `LINE` 
                    FROM `item` 
                    WHERE `PERIOD` = '$PERIOD' 
                    AND `COUNTRY` = '$COUNTRY'
                    AND `FACTORY` = '$FACTORY'
                    AND `BIZ` = '$BIZ'
                    ORDER BY `LINE`";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
        $response['message'] = 'Search LINE success.';
    } else if ($SEARCH == 'TYPE') {
        $PERIOD = $_POST['PERIOD'];
        $LINE = $_POST['LINE'];
        $strSQL = "SELECT DISTINCT `TYPE` 
                FROM `item` 
                WHERE `PERIOD` = '$PERIOD' 
                AND `LINE` = '$LINE' 
                AND `COUNTRY` = '$COUNTRY'
                AND `FACTORY` = '$FACTORY'
                AND `BIZ` = '$BIZ'
                ORDER BY `TYPE`";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
        $response['message'] = 'Search TYPE success.';
    } else if ($SEARCH == 'MODEL') {
        $PERIOD = $_POST['PERIOD'];
        $LINE = $_POST['LINE'];
        $TYPE = $_POST['TYPE'];
        $strSQL = "SELECT DISTINCT `MODEL` 
                    FROM `item` 
                    WHERE `PERIOD` = '$PERIOD' 
                    AND `LINE` = '$LINE'
                    AND `TYPE` = '$TYPE'
                    AND `COUNTRY` = '$COUNTRY'
                    AND `FACTORY` = '$FACTORY'
                    AND `BIZ` = '$BIZ'
                    ORDER BY `MODEL`";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
        $response['message'] = 'Search MODEL success.';
    }
    $response['data'] = $objResult;
    $response['response'] = true;
}

echo json_encode($response);


// if (isset($_POST['LINE']) && empty($_POST['TYPE'])) {
//     $LINE = $_POST['LINE'];
//     $strSQL = "SELECT DISTINCT `TYPE` FROM `item` WHERE `LINE` = '$LINE' AND `PERIOD` = '$PERIOD'";
//     $objQuery = mysqli_query($con, $strSQL);
//     while ($objResult = mysqli_fetch_array($objQuery)) {
//         $TYPE[] = $objResult['TYPE'];
//     }
//     echo json_encode($TYPE);
// } else if (isset($_POST['TYPE']) && isset($_POST['LINE'])) {
//     $LINE = $_POST['LINE'];
//     $type = $_POST['TYPE'];
//     $strSQL = "SELECT DISTINCT MODEL FROM `item` WHERE `LINE` = '$LINE' AND `TYPE` = '$type' AND `PERIOD` LIKE '%$PERIOD%'";
//     $objQuery = mysqli_query($con, $strSQL);
//     while ($objResult = mysqli_fetch_array($objQuery)) {
//         $MODEL[] = $objResult['MODEL'];
//     }
//     echo json_encode($MODEL);
// } else if (isset($_POST['LINE_TYPE'])) {
//     $LINE = $_POST['LINE'];
//     $strSQL = "SELECT DISTINCT TYPE FROM `item` WHERE `LINE` = '$LINE'";
//     $objQuery = mysqli_query($con, $strSQL);
//     while ($objResult = mysqli_fetch_array($objQuery)) {
//         $TYPE2[] = $objResult['TYPE'];
//     }
//     echo json_encode($TYPE2);
// } else if (isset($_POST['LINE_CENTER'])) {
//     /// check center
//     $LINE = $_POST['LINE_CENTER'];
//     $strSQL = "SELECT `TYPE` FROM `startup_line` WHERE `LINE` = '$LINE'";
//     $objQuery = mysqli_query($con, $strSQL);
//     $objResult = mysqli_fetch_array($objQuery);
//     $TYPE = $objResult['TYPE'];
//     echo json_encode($TYPE);
// } else {
//     $LINE = array();
//     $strSQL = "SELECT DISTINCT `LINE` FROM `item` WHERE `PERIOD` LIKE '%$PERIOD%' ORDER BY `LINE`";
//     $objQuery = mysqli_query($con, $strSQL);
//     while ($objResult = mysqli_fetch_array($objQuery)) {
//         $LINE[] = $objResult['LINE'];
//     }
//     echo json_encode($LINE);
// }
