<?php
	
	ini_set('display_errors', 1);
	error_reporting(~0);

	$serverName	  	= "43.72.52.56";
	$userName	  	= "im";
	$userPassword	= "1234";
	$dbName	  		= "im";

	$con_torque = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_query($con_torque,"SET CHARACTER SET UTF8");

	if (mysqli_connect_errno())
	{
		echo "Database Connect Failed : " . mysqli_connect_error();
		exit();
	}
?>