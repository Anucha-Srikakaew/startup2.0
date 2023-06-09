<?php

include('../connect.php');
date_default_timezone_set("Asia/Bangkok");
session_start();

$output = array(
    'STARTUP_EMP_ID' => '',
    'STARTUP_EMP_NAME' => '',
    'STARTUP_EMP_IMG' => '',
    'STARTUP_EMP_BIZ' => '',
    'STARTUP_EMP_FACTORY' => '',
    'STARTUP_EMP_COUNTRY' => '',
    'STARTUP_EMP_TYPE' => '',
);

if (isset($_POST['username']) && isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT `ID`, `COUNTRY`, `FACTORY`, `MEMBER_ID`, `NAME`, `PASSWORD`, 
    `TYPE`, `SHIFT`, `LINE`, `BIZ`, `LastUpdate` 
            FROM `member` 
            WHERE `MEMBER_ID` = '$username' AND `PASSWORD` = '$password'";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    if (isset($row)) {
        if ($row['FACTORY'] == 'STTB') {
            $output['STARTUP_EMP_IMG'] = 'http://43.72.228.147/attend/img_opt/' . $row['MEMBER_ID'] . '.jpg';
        } else {
            $output['STARTUP_EMP_IMG'] = 'http://43.72.52.159/attend/img_opt/' . $row['MEMBER_ID'] . '.jpg';
        }

        $stmt = $con158->prepare("SELECT [GID] ,[ENID] ,[EMP_NAME_TH] ,[EMP_NAME_EN] ,
        [EMP_LEVEL] ,[EMP_POSITION] ,[CENTER] ,[DIVISION] ,[DEPARTMENT],
        [EMP_STATUS] ,[PLANT] ,[PLANT_EN] ,[RFID]
        FROM [STTC_HUMAN_RESOURCE].[dbo].[V_EMPLOYEE_COMBIN_PLANTE]
        WHERE [ENID]=:ENID");
        $stmt->execute(['ENID' => $row['MEMBER_ID']]);
        $row2 = $stmt->fetchAll()[0];

        if (isset($row2)) {
            $output['STARTUP_EMP_DEPARTMENT'] = $row2['DEPARTMENT'];
            $RFID = $row2['RFID'];
            $url = "http://43.72.52.159:8002/api/stt_rfid_resframe_apiview/?rfid=$RFID";
            $str_token = '51b23c8df4068ce0d223da9bb94a07a378021c8f';
            $context = stream_context_create(array(
                'http' => array(
                    'header'  => "Authorization: Token " . $str_token
                )
            ));
            $data = file_get_contents($url, false, $context);
        }

        $output['STARTUP_EMP_ID'] = $row['MEMBER_ID'];
        $output['STARTUP_EMP_NAME'] = $row['NAME'];
        $output['STARTUP_EMP_BIZ'] = $row['BIZ'];
        $output['STARTUP_EMP_FACTORY'] = $row['FACTORY'];
        $output['STARTUP_EMP_COUNTRY'] = $row['COUNTRY'];
        $output['STARTUP_EMP_TYPE'] = $row['TYPE'];

        $_SESSION['STARTUP_LOGIN'] = $output;
    }
} else {
    if (isset($_SESSION['STARTUP_LOGIN'])) {
        $output = $_SESSION['STARTUP_LOGIN'];
    }
}

echo json_encode($output);
