<?php
include('../connect.php');
date_default_timezone_set("Asia/Bangkok");

$response = array(
        "response" => false,
        "data" => array(),
        "message" => "No data post",
);

$typeQuery = $_POST['typeQuery'];
if ($typeQuery == 'select') {
        $memberId = $_POST['memberID'];

        $stmt = $con158->prepare("SELECT [GID] ,[ENID] ,[EMP_NAME_TH] ,[EMP_NAME_EN] ,
        [EMP_LEVEL] ,[EMP_POSITION] ,[CENTER] ,[DIVISION] ,[DEPARTMENT],
        [EMP_STATUS] ,[PLANT] ,[PLANT_EN] ,[RFID]
        FROM [STTC_HUMAN_RESOURCE].[dbo].[V_EMPLOYEE_COMBIN_PLANTE]
        WHERE [ENID]=:ENID OR [RFID]=:RFID");
        $stmt->execute(['ENID' => $memberId, 'RFID' => $memberId]);
        $row_member = $stmt->fetchAll()[0];

        if(empty($row_member)){
                $stmt = $con158->prepare("SELECT [ID] ,[GID],[ENID],[EMP_NAME_TH],[EMP_NAME_EN],
                [EMP_GENDER],[EMP_LEVEL],[EMP_POSITION],[CENTER],
                [DIVISION],[DEPARTMENT],[COSTCENTER],[JOIN_DATE],
                [RESIGN_DATE],[EMP_STATUS],[NATIONALITY],[EMP_TYPE],[EMP_ETC],
                [REMARK1],[REMARK2],[REMARK3],[UPDATE_DATE],[EMP_GENDER_EN],
                [EMP_STATUS_EN],[NATIONALITY_EN],[END_CONTRACT],[PLANT],[PLANT_COST]
                  FROM [STTC_HUMAN_RESOURCE].[dbo].[TBL_MANPOW_MASTER_BANGKADI]
                WHERE [ENID]=:ENID");
                $stmt->execute(['ENID' => $memberId]);
                $row_member = $stmt->fetchAll()[0];
        }

        $response['data'] = $row_member;
        $response['response'] = true;
        $response['message'] = 'query.';
} else {
        $FACTORY = $_POST['FACTORY'];
        $MEMBER_ID = $_POST['MEMBER_ID'];
        $NAME = $_POST['NAME'];
        $TYPE = $_POST['TYPE'];
        $sql = "INSERT INTO `member`(
                `FACTORY`,
                `MEMBER_ID`, 
                `NAME`, 
                `PASSWORD`, 
                `TYPE`, 
                `SHIFT`, 
                `LINE`, 
                `BIZ`, 
                `LastUpdate`
                ) 
        VALUES (
                '$FACTORY',
                '$MEMBER_ID', 
                '$NAME', 
                '$MEMBER_ID', 
                '$TYPE', 
                'ALL', 
                'ALL', 
                'IM', 
                NOW()
        )";

        if (mysqli_query($con, $sql)) {
                $response['response'] = true;
                $response['message'] = 'Complete.';
        } else {
                $response['response'] = false;
                $response['message'] = "Failed to query to MySQL: " . $con->error;
        }
}

echo json_encode($response);
