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
