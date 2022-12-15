<?php
	
	ini_set('display_errors', 1);
	error_reporting(~0);

	$serverName	  	= "43.72.52.51";
	$userName	  	= "inno";
	$userPassword	= "1234";
	$dbName	  		= "checkin";

	$conLine = mysqli_connect($serverName,$userName,$userPassword,$dbName);

	if (mysqli_connect_errno())
	{
		echo "Database Connect Failed : " . mysqli_connect_error();
		exit();
	}
?>