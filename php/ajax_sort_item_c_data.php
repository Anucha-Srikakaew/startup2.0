<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

$COUNTRY = $_POST['COUNTRY'];
if (isset($_POST['SEARCH'])) {
    $SEARCH = $_POST['SEARCH'];
    if ($SEARCH == 'FACTORY') {
        $strSQL = "SELECT DISTINCT `FACTORY` 
                    FROM `item` 
                    WHERE `COUNTRY` = '$COUNTRY'
                    ORDER BY `FACTORY`";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
        $response['message'] = 'Search FACTORY success.';
    } else if ($SEARCH == 'BIZ') {
        $FACTORY = $_POST['FACTORY'];
        $strSQL = "SELECT DISTINCT `BIZ` 
                    FROM `item` 
                    WHERE `COUNTRY` = '$COUNTRY'
                    AND `FACTORY` = '$FACTORY'
                    ORDER BY `BIZ`";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
        $response['message'] = 'Search BIZ success.';
    } else if ($SEARCH == 'LINE') {
        $FACTORY = $_POST['FACTORY'];
        $BIZ = $_POST['BIZ'];
        $strSQL = "SELECT DISTINCT `LINE` 
                    FROM `item` 
                    WHERE `COUNTRY` = '$COUNTRY'
                    AND `FACTORY` = '$FACTORY'
                    AND `BIZ` = '$BIZ'
                    ORDER BY `LINE`";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
        $response['message'] = 'Search LINE success.';
    } else if ($SEARCH == 'TYPE') {
        $FACTORY = $_POST['FACTORY'];
        $BIZ = $_POST['BIZ'];
        $LINE = $_POST['LINE'];
        $strSQL = "SELECT DISTINCT `TYPE` 
                FROM `item` 
                WHERE `LINE` = '$LINE' 
                AND `COUNTRY` = '$COUNTRY'
                AND `FACTORY` = '$FACTORY'
                AND `BIZ` = '$BIZ'
                ORDER BY `TYPE`";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_all($objQuery, MYSQLI_ASSOC);
        $response['message'] = 'Search TYPE success.';
    } else if ($SEARCH == 'MODEL') {
        $FACTORY = $_POST['FACTORY'];
        $BIZ = $_POST['BIZ'];
        $LINE = $_POST['LINE'];
        $TYPE = $_POST['TYPE'];
        $strSQL = "SELECT DISTINCT `MODEL` 
                    FROM `item` 
                    WHERE `LINE` = '$LINE'
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
