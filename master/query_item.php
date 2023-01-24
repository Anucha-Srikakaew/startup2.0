<?php
require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");
$array_value = array();
$BIZ = $_POST['BIZ'];
$LINE = $_POST['LINE'];
$LINE = str_replace('\\', '', $LINE);
$MODEL = $_POST['MODEL'];
$PROCESS = $_POST['PROCESS'];
$PROCESS = str_replace('%%', ' ', $PROCESS);
$TYPE = $_POST['TYPE'];
$SPEC = $_POST['SPEC'];
$PIC = $_POST['PIC'];
$MEMBER_ID = $_POST['MEMBER_ID'];

// print_r($LINE);
// echo "<br>";

if (empty($LINE)) {
    $LINE_QUERY = "AND LINE LIKE '%%'";
} else {
    $LINE_QUERY = "AND LINE IN ('$LINE')";
}

$strSQL = "SELECT * FROM `item` 
 WHERE BIZ LIKE '%$BIZ%' 
 $LINE_QUERY
 AND PROCESS LIKE '%$PROCESS%'
 AND MODEL LIKE '%$MODEL%'
 AND TYPE LIKE '%$TYPE%'
 AND SPEC LIKE '%$SPEC%'
 AND PIC LIKE '%$PIC%' LIMIT 0,100;";
mysqli_set_charset($con, "utf8");
$objQuery = mysqli_query($con, $strSQL);

while ($objResult = mysqli_fetch_array($objQuery)) {
    $ID = $objResult['ID'];
    $BIZ = $objResult['BIZ'];
    $LINE = $objResult['LINE'];
    $TYPE = $objResult['TYPE'];
    $MODEL = $objResult['MODEL'];
    $PROCESS = $objResult['PROCESS'];
    $ITEM = $objResult['ITEM'];
    $SPEC_DES = $objResult['SPEC_DES'];
    $MIN = $objResult['MIN'];
    $MAX = $objResult['MAX'];
    $SPEC = $objResult['SPEC'];
    $PIC = $objResult['PIC'];

    // if ($CHECK != 'DATA') {
    if ($MAX == null) {
        $MAX = '';
    }
    if ($MIN == null) {
        $MIN = '';
    }
    array_push(
        $array_value,
        array(
            'use_ID' => '<input type="checkbox" name="chk[]" value="' . $ID . '">',
            'use_LINE' => $LINE,
            'use_TYPE' => $TYPE,
            'use_MODEL' => $MODEL,
            'use_PROCESS' => $PROCESS,
            'use_ITEM' => $ITEM,
            'use_SPEC_DES' => $SPEC_DES,
            'use_MIN' => $MIN,
            'use_MAX' => $MAX,
            'use_SPEC' => $SPEC,
            'use_PIC' => $PIC,
            'use_TOOL' => '<a href="item_edit.php?MEMBER_ID=' . $MEMBER_ID . '&ID=' . $ID . '" class="btn btn-primary" style="margin-right:5px"><i class="fas fa-edit" style="color:white"></i></a><a href="item_delete.php?MEMBER_ID=' . $MEMBER_ID . '&ID=' . $ID . '" class="btn btn-danger"><i class="fas fa-trash" style="color:white"></i></a>'
        )
    );
    // break;
    // }
}

echo json_encode($array_value);
