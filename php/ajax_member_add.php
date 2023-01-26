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
        $sql_member = "SELECT [GID] ,[ENID] ,
        [EMP_NAME_TH] ,[EMP_NAME_EN] ,[EMP_LEVEL] ,
        [EMP_POSITION] ,[CENTER] ,[DIVISION] ,
        [DEPARTMENT] ,[EMP_STATUS] ,[PLANT] ,[RFID]
        FROM [STTC_HUMAN_RESOURCE].[dbo].[V_EMPLOYEE_COMBIN_PLANTE] 
        WHERE [RFID] = '$memberId' OR [ENID] = '$memberId'";
        $query_member = sqlsrv_query($con158, $sql_member);
        $row_member = sqlsrv_fetch_array($query_member, MYSQLI_NUM);
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
