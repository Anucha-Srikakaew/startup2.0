<?php
require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");
$array_value = array();

// print_r($_GET);
$LINE = $_GET['LINE'];
$MODEL = $_GET['MODEL'];
$PROCESS = $_GET['PROCESS'];
if (isset($_POST['number'])) {
    $number = $_POST['number'];
}
if (isset($_POST['check'])) {
    $check = $_POST['check'];
}

$DATE = date("Y-m-d");


if ($PROCESS == 'NO DATA' or (empty($_GET['PROCESS']))) {
    header("Location: visual_line.php?LINE=$LINE");
}

if (!isset($check)) {
    $strSQL = "SELECT * FROM `startup_item` 
    WHERE LINE = '$LINE' AND MODEL = '$MODEL' AND PROCESS = '$PROCESS' 
    -- AND LastUpdate = (SELECT LastUpdate FROM `startup_item` WHERE LINE = '$LINE'  AND PROCESS = '$PROCESS' ORDER BY LastUpdate DESC LIMIT 1)
    AND LastUpdate LIKE '$DATE%'
    ORDER BY ID ASC";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $ID = $objResult['ID'];
        $PROCESS = $objResult['PROCESS'];
        $ITEM = $objResult['ITEM'];
        $SPEC_DES = $objResult['SPEC_DES'];
        $SPEC = $objResult['SPEC'];
        $VALUE1 = $objResult['VALUE1'];
        $VALUE2 = $objResult['VALUE2'];
        $JUDGEMENT = $objResult['JUDGEMENT'];
        // echo $ID . '<br>';
        // echo $SPEC. '<br>';
        // echo $VALUE1. '<br>';
        // echo $VALUE2. '<br>';
        // echo $JUDGEMENT. '<br>';
        $i = 0;
        $STATUS = 'success';
        if ($JUDGEMENT == 'PASS') {
            $STATUS = 'success';
        } else if ($JUDGEMENT == 'FAIL') {
            $STATUS = 'danger';
        } else {
            $STATUS = 'warning';
        }
        if (($SPEC == 'PHOTO') && ((!empty($VALUE1)))) {
            $SHOW_VALUE1 = '  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter' . $i . '" >
                                                            <i class="fa fa-eye" aria-hidden="true"></i> WATCH
                                                        </button>';

            if (empty($VALUE1)) {
                $SHOW_VALUE1 = '';
            }
        } else {
            $SHOW_VALUE1 = $VALUE1;
        }
        array_push(
            $array_value,
            array(
                'use_STATUS' => $STATUS,
                'use_ITEM' => $ITEM,
                'use_SPEC_DES' => $SPEC_DES,
                'use_VALUE1' => $SHOW_VALUE1,
                'use_VALUE2' => $VALUE2,
            )
        );
    }

    echo json_encode($array_value);
} else {

    $strSQL = "SELECT * FROM `startup_item` 
    WHERE LINE = '$LINE' AND PROCESS = '$PROCESS' 
    AND LastUpdate = (SELECT LastUpdate FROM `startup_item` WHERE LINE = '$LINE'  AND PROCESS = '$PROCESS'  ORDER BY LastUpdate DESC LIMIT {$_POST['number']},6) 
    ORDER BY ID ASC";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $ID = $objResult['ID'];
        $PROCESS = $objResult['PROCESS'];
        $ITEM = $objResult['ITEM'];
        $SPEC_DES = $objResult['SPEC_DES'];
        $SPEC = $objResult['SPEC'];
        $VALUE1 = $objResult['VALUE1'];
        $VALUE2 = $objResult['VALUE2'];
        $JUDGEMENT = $objResult['JUDGEMENT'];
        // echo $ID . '<br>';
        // echo $SPEC. '<br>';
        // echo $VALUE1. '<br>';
        // echo $VALUE2. '<br>';
        // echo $JUDGEMENT. '<br>';
        $i = 0;
        $STATUS = 'success';
        if ($JUDGEMENT == 'PASS') {
            $STATUS = 'success';
        } else if ($JUDGEMENT == 'FAIL') {
            $STATUS = 'danger';
        } else {
            $STATUS = 'warning';
        }
        if (($SPEC == 'PHOTO') && ((!empty($VALUE1)))) {
            $SHOW_VALUE1 = '  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter' . $i . '" >
                                                            <i class="fa fa-eye" aria-hidden="true"></i> WATCH
                                                        </button>';

            if (empty($VALUE1)) {
                $SHOW_VALUE1 = '';
            }
        } else {
            $SHOW_VALUE1 = $VALUE1;
        }
        array_push(
            $array_value,
            array(
                'use_STATUS' => $STATUS,
                'use_ITEM' => $ITEM,
                'use_SPEC_DES' => $SPEC_DES,
                'use_VALUE1' => $SHOW_VALUE1,
                'use_VALUE2' => $VALUE2,
            )
        );
    }

    echo json_encode($array_value);
}
