<?php
	
	ini_set('display_errors', 1);
	error_reporting(~0);

	$serverName	  	= "43.72.52.159";
	$userName	  	= "root";
	$userPassword	= "123456";
	$dbName	  		= "attendance";

	$con159 = mysqli_connect($serverName,$userName,$userPassword,$dbName);

	if (mysqli_connect_errno())
	{
		echo "Database Connect Failed : " . mysqli_connect_error();
		exit();
	}
?>