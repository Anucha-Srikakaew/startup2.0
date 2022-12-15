<?php
	
	ini_set('display_errors', 1);
	error_reporting(~0);

	$serverName	  	= "43.72.52.84";
	$userName	  	= "inno";
	$userPassword	= "1234";
	$dbName	  		= "di_cl";

	$con84 = mysqli_connect($serverName,$userName,$userPassword,$dbName);

	if (mysqli_connect_errno())
	{
		echo "Database Connect Failed : " . mysqli_connect_error();
		exit();
	}
