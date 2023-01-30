<?php
// MSSQL MEMBER STTC
$serverName = "43.72.52.158";
$database = "STTC_HUMAN_RESOURCE";
$uid = 'mfe';
$pwd = 'mfeP@ssw0rd';
try {
	$conn = new PDO(
		"sqlsrv:server=$serverName;Database=$database",
		$uid,
		$pwd,
		array(
			//PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		)
	);
} catch (PDOException $e) {
	die("Error connecting to SQL Server: " . $e->getMessage());
}

$stmt = $conn->prepare("SELECT [GID] ,[ENID] ,[EMP_NAME_TH] ,[EMP_NAME_EN] ,
[EMP_LEVEL] ,[EMP_POSITION] ,[CENTER] ,[DIVISION] ,[DEPARTMENT],
[EMP_STATUS] ,[PLANT] ,[PLANT_EN] ,[RFID]
FROM [STTC_HUMAN_RESOURCE].[dbo].[V_EMPLOYEE_COMBIN_PLANTE]
WHERE [ENID]=:ENID");
$stmt->execute(['ENID' => '22210063']);
$row = $stmt->fetchAll();
print_r($row);
