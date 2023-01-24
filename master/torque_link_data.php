<?php

include("connect_torque.php");
include("connect.php");
// header('Content-Type: application/json; charset=utf-8');

// $MODEL = 'VX9493_FLORIDA';
// $LINE = 'FEY';
// $DATE = '2022-05-02';

$sql_torque = "SELECT * FROM `tbl_torque_result` 
WHERE IDCODE IN (
    SELECT IDCODE 
    FROM `tbl_torque_process_register` 
    WHERE MODELNAME = '$MODEL'
    AND LINENAME = '$LINE ($MODEL)'
    ) AND RECDATE LIKE '%$DATE%'";
$query_torque = mysqli_query($con_torque, $sql_torque);
while ($row_torque = mysqli_fetch_array($query_torque, MYSQLI_ASSOC)) {
    $RESULT_TORQUE = $row_torque["TORQUE_VALUE"];
    $SPEC_MIN = $row_torque["SPEC_MIN"];
    $SPEC_MAX = $row_torque["SPEC_MAX"];
    $PROCESSID = $row_torque["PROCESSID"];

    $ITEM_TORQUE = "ตรวจวัดค่า Torque ใน Process ต้องอยู่ในค่าตาม Spec";
    $ITEM_DES = "ค่า Torque ต้องอยู่ระหว่าง $SPEC_MIN ถึง $SPEC_MAX";

    if($row_torque["JUDGEMENT"] == 'OK'){
        $JUDGEMENT = "PASS";
    }else{
        $JUDGEMENT = "FAIL";
    }

    echo $sql_insert_tourqe = "INSERT INTO `startup_item` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `DRAWING`, `MODEL`, `PROCESS`, `JIG_NAME`, `PICTURE`, `ITEM`, `SPEC_DES`, `MIN`, `MAX`, `SPEC`, `VALUE1`, `VALUE2`, `JUDGEMENT`, `REMARK`, `SHIFT_DATE`,`SHIFT`,`PERIOD`, `RESULT`, `LastUpdate`) 
                            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '', '$MODEL', '$PROCESSID', '', '', '$ITEM_TORQUE', '$ITEM_DES', '$SPEC_MIN', '$SPEC_MAX', 'SHOW', '$RESULT_TORQUE', '', '$JUDGEMENT', '', '$DATE', '$SHIFT', '$PERIOD_DATA', '',NOW());";
    mysqli_query($con, $sql_insert_tourqe);
}
