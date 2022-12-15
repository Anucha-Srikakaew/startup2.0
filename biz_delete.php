<?php

require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");

if(isset($_GET['ID']))
    {
        $ID=$_GET['ID'];

        $strSQL = "DELETE FROM `biz` WHERE `biz`.`ID` = $ID";
        $objQuery = mysqli_query($con,$strSQL);
        header("Location: biz.php");
    }
else
    {
        header("Location: biz.php");
    }
?>

