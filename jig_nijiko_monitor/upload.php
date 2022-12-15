<?php

use Shuchkin\SimpleXLSX;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

date_default_timezone_set("Asia/Bangkok");
include("connect.php");

require __DIR__ . '/src/SimpleXLSX.php';

if (!empty($_FILES["file"])) {

    $table = $_POST["table"];

    if($table == "tbl_nejiko_register"){
        $colid = "NEJIKOID";
        $colname = "NEJIKONAME";
    }else{
        $colid = "JIGID";
        $colname = "JIGNAME";
    }

    $file_array = explode(".", $_FILES["file"]["name"]);
    if ($file_array[1] == "xlsx") {

        if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name'])) {

            $dim = $xlsx->dimension();
            $cols = $dim[0];

            if ($cols == 6) {
                $sql = "INSERT INTO `$table`(`ID`, `LINENAME`, `MODEL`, `PROCESSNAME`, `PROCESSID`,`$colname`, `$colid`, `DATETIME`) VALUES";
                foreach ($xlsx->readRows() as $k => $r) {
                    if($k == 1){
                        $sql .= "(NULL,'$r[0]','$r[1]','$r[2]','$r[3]','$r[4]','$r[5]',NOW())";
                    }else if ($k > 1){
                        $sql .= ",(NULL,'$r[0]','$r[1]','$r[2]','$r[3]','$r[4]','$r[5]',NOW())";
                    }
                }
                if(mysqli_query($con, $sql)){
                    echo "success";
                }else{
                    echo "query error";
                }
            }else{
                echo "please check template";
            }
        } else {
            echo SimpleXLSX::parseError();
        }
    }
}

