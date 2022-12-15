<?php
    $BIZ = $_GET['BIZ'];
    
    if(($BIZ=='AC')OR($BIZ=='LINE_FIT'))
    {
        ini_set('display_errors', 1);
        error_reporting(~0);
        $serverName = "43.72.52.152";
        $userName = "SWALLOW";
        $userPassword = "Passw0rd";
        $dbName = "SWALLOW";  
        $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        date_default_timezone_set("Asia/Bangkok");
        if($conn)
        {
            // echo "Database Connected.";
        }
        else
        {
            die( print_r( sqlsrv_errors(), true));
        }
        $stmt = "SELECT * FROM TBL_MODEL_MASTER WHERE CATEGORY_NAME LIKE '%$BIZ%' ORDER BY ID";
        $query = sqlsrv_query($conn, $stmt);



        while($result = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC))
        {
            $MODEL_NAME = $result['MODEL_NAME'];
            $model[] = $MODEL_NAME;
        }
        
        $jsonModel = json_encode($model);
        echo $jsonModel;
    }
    else if($BIZ=='AU')
    {
        ini_set('display_errors', 1);
        error_reporting(~0);
        $serverName = "43.72.52.170";
        $userName = "SWALLOW";
        $userPassword = "Passw0rd";
        $dbName = "SWALLOW";  
        $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true);
        $conn = sqlsrv_connect( $serverName, $connectionInfo);
        date_default_timezone_set("Asia/Bangkok");
        if($conn)
        {
            // echo "Database Connected.";
        }
        else
        {
            die( print_r( sqlsrv_errors(), true));
        }
        $stmt = "SELECT * FROM TBL_MODEL_MASTER WHERE CATEGORY_NAME LIKE '%$BIZ%' ORDER BY ID";
        $query = sqlsrv_query($conn, $stmt);



        while($result = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC))
        {
            $MODEL_NAME = $result['MODEL_NAME'];
            $model[] = $MODEL_NAME;
        }
        
        $jsonModel = json_encode($model);
        echo $jsonModel;
    }
    else if ($BIZ == 'IM' || $BIZ == 'IM') {
        if ($BIZ == 'IM') {
            $BIZ = "IM";
        }
    
        $serverName = "43.72.52.154";
        $userName = "sa";
        $userPassword = "P@ssw0rd";
        $dbName = "SWALLOW";
    
        $objConnect = mssql_connect($serverName, $userName, $userPassword) or die("Error Connect to Database");
        $objDB = mssql_select_db($dbName);
        $strSQL = "SELECT [MODEL_NAME] FROM [SWALLOW].[dbo].[TBL_MODEL_MASTER] WHERE CATEGORY_NAME LIKE '%$BIZ%' ORDER BY MODEL_NAME";
        $objQuery = mssql_query($strSQL) or die("Error Query [" . $strSQL . "]");
        while ($objResult = mssql_fetch_array($objQuery)) {
            $MODEL_NAME = $objResult['MODEL_NAME'];
            $model[] = $MODEL_NAME;
        }
        $jsonModel = json_encode($model);
        echo $jsonModel;
         
    }
?>