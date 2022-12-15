<?php
    ini_set('display_errors', 1);
    error_reporting(~0);
    $serverName = "43.72.52.170";
    $userName = "SWALLOW";
    $userPassword = "Passw0rd";
    $dbName = "SWALLOW";  
    $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);
    $conMSSQL170 = sqlsrv_connect( $serverName, $connectionInfo);
    date_default_timezone_set("Asia/Bangkok");
?>