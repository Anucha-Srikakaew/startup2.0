<?php
// require_once 'item.php';
require("framework/PHPExcel/Classes/PHPExcel/IOFactory.php");
date_default_timezone_set("Asia/Bangkok");

// print_r($_FILES["excel_file"]);

if (!empty($_FILES["excel_file"])) {

    // TABLE IS TABLE THAT YPU SELECT TO INPUT DATA
    $table = $_POST["table"];
    $error = $_POST["check"];
    $obj2 = $_POST['myData'];
    $MEMBER_ID = $_POST['check_biz'];

    $connect = mysqli_connect("43.72.52.51", "inno", "1234", "startup2_0");

    // get field
    $sql = "SHOW COLUMNS FROM " . $table . " ";
    $result = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $column_name[] = $row['Field'];
    };
    // count column
    $count_column = count($column_name);
    // print_r($count_column);
    // check login for startup system
    if (isset($MEMBER_ID)) {
        $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
        $objQuery = mysqli_query($connect, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        $MEMBER_ID = $objResult['MEMBER_ID'];
        $NAME = $objResult['NAME'];
        $TYPE = $objResult['TYPE'];
        if (isset($_POST['BIZ'])) {
            $BIZ = $_POST['BIZ'];
            if ($BIZ == 'ALL') {
                if (empty($_POST['BIZ'])) {
                    $BIZ = '';
                } else {
                    $BIZ = $_POST['BIZ'];
                }
            }
        } else {
            $BIZ = $objResult['BIZ'];
            if ($BIZ == 'ALL') {
                if (empty($_POST['BIZ'])) {
                    $BIZ = '';
                } else {
                    $BIZ = $_POST['BIZ'] = $objResult['BIZ'];
                }
            }
        }
    } else {
        if (isset($_POST['MEMBER_ID'])) {
            $MEMBER_ID = $_POST['MEMBER_ID'];
        } else {
            header("Location: login.php");
        }
    }
    $file_array = explode(".", $_FILES["excel_file"]["name"]);
    // print_r($file_array);

    if ($file_array[1] == "xlsx" || $file_array[1] == "csv") {

        // load data excel
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        $object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);

        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $count = 0;
            $RowSkip = 2; //row excel start 2
            for ($row = $RowSkip; $row <= $highestRow; $row++) {
                for ($column_number = 0; $column_number < $count_column; $column_number++) {
                    $data_in_file = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($column_number, $row)->getValue());
                    $check_value_excel[$column_number] = $data_in_file;
                    // print_r($data_in_file);
                }

                $value_excel = array_combine($column_name, $check_value_excel);
                $value_excel['ID'] = NULL;
                $value_excel['LastUpdate'] = date("Y-m-d H:i:s");

                $BIZ = 'IM';
                if ($value_excel['BIZ'] != $BIZ) {
                    $error_biz[$row - 1] = 'BIZ';
                    $biz = $error_biz;
                    $row_error[] = $row - 1;
                    $query_db = '';
                }

                $arr_value = ('\'' . implode('\',\'', array_values($value_excel)) . '\'');
                if ($value_excel['BIZ'] == "ALL") {
                    $query_db[] = "INSERT INTO $table VALUES ($arr_value)";
                } else {
                    $query_db[] = "INSERT INTO $table VALUES ($arr_value)";
                }
            }
        }

        if (isset($row_error)) {
            $unique_error = array_unique($row_error);
            foreach ($unique_error as $row) {

                if (isset($min[$row])) {
                    // $min_data = implode(', ', array_values($min));
                    $min_data = $min[$row];
                    $error_data[] = $min_data;
                }
                if (isset($max[$row])) {
                    // $max_data = implode(', ', array_values($max));
                    $max_data = $max[$row];
                    $error_data[] = $max_data;
                }
                if (isset($biz[$row])) {
                    $biz_data = $biz[$row];
                    // $biz_data = implode(', ', array_values($biz_r));
                    $error_data[] = $biz_data;
                }
                $str_error_data = implode(', ', array_values($error_data));
                $data[] = "<br>row " . $row . " error column (" . $str_error_data . ")";
                $error_data = NULL;
            }
            echo json_encode($data);
        } else {
            $data = "success";
            echo json_encode($data);
            foreach ($query_db as $key) {
                // mysqli_query($connect, $key);
            }
        }
    }
}
