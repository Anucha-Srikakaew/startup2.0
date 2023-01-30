<?php

ini_set('display_errors', 1);
error_reporting(~0);

$serverName	  	= "43.72.52.51";
$userName	  	= "inno";
$userPassword	= "1234";
$dbName	  		= "startup2_0";

$con = mysqli_connect($serverName, $userName, $userPassword, $dbName);
mysqli_query($con, "SET CHARACTER SET UTF8");

if (mysqli_connect_errno()) {
	echo "Database Connect Failed : " . mysqli_connect_error();
	exit();
}

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
