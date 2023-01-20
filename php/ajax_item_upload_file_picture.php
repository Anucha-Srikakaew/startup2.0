<?php
include('../connect.php');
require("../framework/PHPExcel/Classes/PHPExcel/IOFactory.php");
date_default_timezone_set("Asia/Bangkok");

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

if (!empty($_FILES["excel_file"])) {

    // TABLE IS TABLE THAT YPU SELECT TO INPUT DATA
    $table = $_POST["table"];

    $connect = mysqli_connect("43.72.52.51", "inno", "1234", "startup2_0");

    $column_name = array(
        'FACTORY',
        'BIZ',
        'LINE',
        'TYPE',
        'MODEL',
        'PROCESS',
        'ITEM',
        'SPEC_DES',
        'MIN',
        'MAX',
        'SPEC',
        'PIC',
        'PERIOD'
    );
    
    // count column
    $count_column = count($column_name);

    $file_array = explode(".", $_FILES["excel_file"]["name"]);

    if ($file_array[1] == "xlsx" || $file_array[1] == "csv") {

        // load data excel
        PHPExcel_Settings::setZipClass(PHPExcel_Settings::ZIPARCHIVE);
        $object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);

        $sql = '';
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $count = 0;
            $RowSkip = 2; //row excel start 2
            for ($row = $RowSkip; $row <= $highestRow; $row++) {
                print_r($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                // for ($column_number = 0; $column_number < $count_column; $column_number++) {
                //     $data_in_file = mysqli_real_escape_string($connect, $worksheet->getCellByColumnAndRow($column_number, $row)->getValue());
                //     $check_value_excel[$column_number] = $data_in_file;
                // }
            }
        } 
    }
    // echo json_encode($response);
}
