<?php

require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");

if(isset($_GET['MEMBER_ID']))
{
    $MEMBER_ID = $_GET['MEMBER_ID'];
    $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
    $objQuery = mysqli_query($con,$strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    
    $NAME = $objResult['NAME'];
}
else
{
    header("Location: login.php");
}



if(isset($_GET['ID']))
    {
        $ID=$_GET['ID'];
        $COUNTRY=$_GET['COUNTRY'];
        $FACTORY=$_GET['FACTORY'];
        $BIZ=$_GET['BIZ'];

        ////////////IP ADRESS////////////////
            //whether ip is from share internet
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   
            {
                $IP = $_SERVER['HTTP_CLIENT_IP'];
            }
            //whether ip is from proxy
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
            {
                $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            //whether ip is from remote address
            else
            {
                $IP = $_SERVER['REMOTE_ADDR'];
            }
            $IP;

        if(isset($objResult))
        {
            $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'EDIT BIZ', CURRENT_TIMESTAMP, 'SUCCESS');";
            $objQuery = mysqli_query($con,$strSQL);

            $strSQL = "UPDATE `biz` SET `COUNTRY` = '$COUNTRY',`FACTORY` = '$FACTORY',`BIZ` = '$BIZ' WHERE `ID` = $ID;";
            $objQuery = mysqli_query($con,$strSQL);
            header("Location: biz.php?MEMBER_ID=$MEMBER_ID");
        }
        else
        {
            $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'EDIT BIZ', CURRENT_TIMESTAMP, 'FAIL');";
            $objQuery = mysqli_query($con,$strSQL);
            header("Location: login.php");
        }


    }
else
    {

        echo $COUNTRY=$_GET['COUNTRY'];
        echo $FACTORY=$_GET['FACTORY'];
        echo $BIZ=$_GET['BIZ'];
        
        ////////////IP ADRESS////////////////
            //whether ip is from share internet
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   
            {
                $IP = $_SERVER['HTTP_CLIENT_IP'];
            }
            //whether ip is from proxy
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
            {
                $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            //whether ip is from remote address
            else
            {
                $IP = $_SERVER['REMOTE_ADDR'];
            }
            $IP;

        if(isset($objResult))
        {
            $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'ADD NEW BIZ', CURRENT_TIMESTAMP, 'SUCCESS');";
            $objQuery = mysqli_query($con,$strSQL);

            echo $strSQL = "INSERT INTO `biz` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`) VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ');";
            $objQuery = mysqli_query($con,$strSQL);
            header("Location: biz.php?MEMBER_ID=$MEMBER_ID");
        }
        else
        {
            $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'ADD NEW BIZ', CURRENT_TIMESTAMP, 'FAIL');";
            $objQuery = mysqli_query($con,$strSQL);
            header("Location: login.php");
        }
    }



?>

