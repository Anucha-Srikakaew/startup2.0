<?php
// MSSQL MEMBER STTC
// $servername158 = "43.72.52.158";
// $connectionInfo158 = array(
//     "Database" => "STTC_HUMAN_RESOURCE",
//     "UID" => "mfe",
//     "PWD" => "mfeP@ssw0rd",
//     "MultipleActiveResultSets" => true,
//     "CharacterSet"  => 'UTF-8'
// );
// $con158 = sqlsrv_connect($servername158, $connectionInfo158);
// // if ($con158 === false) {
// //     die(print_r(sqlsrv_errors(), true));
// // }


// echo $sql2 = "SELECT [GID] ,[ENID] ,[EMP_NAME_TH] ,[EMP_NAME_EN] ,
//         [EMP_LEVEL] ,[EMP_POSITION] ,[CENTER] ,[DIVISION] ,[DEPARTMENT],
//         [EMP_STATUS] ,[PLANT] ,[PLANT_EN] ,[RFID]
//         FROM [STTC_HUMAN_RESOURCE].[dbo].[V_EMPLOYEE_COMBIN_PLANTE] 
//         WHERE [ENID] = '22210063'";
// $query2 = sqlsrv_query($con158, $sql2);
// $row2 = sqlsrv_fetch_array($query2, MYSQLI_ASSOC);

// print_r($query2);
// print_r($row2);

//Connect MSSQL
// $serverName = '192.xxx.xxx.xx';
// $userName = 'usertest';
// $userPassword = 'pwdtest';
// $dbName = 'dbtest';
 
try{
	$conn = new PDO("sqlsrv:server=43.72.52.158 ; Database = STTC_HUMAN_RESOURCE", "mfe", "mfeP@ssw0rd");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
	die(print_r($e->getMessage()));
}
