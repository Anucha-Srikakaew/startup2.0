<?php
	
	ini_set('display_errors', 1);
	error_reporting(~0);

	$serverName	  	= "43.72.52.51";
	$userName	  	= "inno";
	$userPassword	= "1234";
	$dbName	  		= "startup2_0";

	$con = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_query($con,"SET CHARACTER SET UTF8");

	if (mysqli_connect_errno())
	{
		echo "Database Connect Failed : " . mysqli_connect_error();
		exit();
	}
?>