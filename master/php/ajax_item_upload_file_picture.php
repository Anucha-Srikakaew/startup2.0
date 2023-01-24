<?php
// require_once 'item.php';
include('../connect.php');
require("../framework/vendor copy/autoload.php");
require("../framework/PHPExcel/Classes/PHPExcel/IOFactory.php");
date_default_timezone_set("Asia/Bangkok");
ini_set('max_execution_time', '10000'); //10000 seconds = 5 minutes

$response = array(
    "response" => false,
    "data" => array(),
    "message" => "No data post",
);

if (!empty($_FILES["excel_file"])) {

    $sql_id = "SELECT MAX( `ID` ) AS ID_DATA FROM `item`";
    $query_id = mysqli_query($con, $sql_id);
    $row_max = mysqli_fetch_array($query_id);
    $max_id = $row_max["ID_DATA"] + 1;

    $column = array(
        'FACTORY',
        'BIZ',
        'LINE',
        'TYPE',
        'DRAWING',
        'MODEL',
        'PROCESS',
        'JIG_NAME',
        'PICTURE',
        'ITEM',
        'SPEC_DES',
        'MIN',
        'MAX',
        'SPEC',
        'PIC',
        'PERIOD'
    );

    $file_array = explode(".", $_FILES["excel_file"]["name"]);
    $key1 = array_key_last($file_array);

    $sql = '';
    if ($file_array[$key1] == "xlsx") {
        $object = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);
        $objPHPExcel = PHPExcel_IOFactory::load($_FILES["excel_file"]["tmp_name"]);

        $worksheet = $object->getActiveSheet();
        $worksheetArray = $worksheet->toArray();
        array_shift($worksheetArray);

        foreach ($worksheetArray as $key => $value) {
            $valDB = array_combine($column, $value);

            $worksheet1 = $object->getActiveSheet();
            $drawing = $worksheet1->getDrawingCollection()[$key];

            if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing) {
                ob_start();
                call_user_func(
                    $drawing->getRenderingFunction(),
                    $drawing->getImageResource()
                );

                $imageContents = ob_get_contents();
                ob_end_clean();
                $extension = 'png';
            } else {
                $zipReader = fopen($drawing->getPath(), 'r');
                $imageContents = '';

                while (!feof($zipReader)) {
                    $imageContents .= fread($zipReader, 1024);
                }
                fclose($zipReader);
                $extension = $drawing->getExtension();
            }

            $valDB['PICTURE'] = $max_id . '.' . $extension;
            $url = 'http://43.72.52.239/STARTUP_photo_body/photo_By_item/uploadphoto.php';
            $data = array(
                'name' => $valDB['PICTURE'],
                'img' => $imageContents
            );
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                )
            );

            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            $valDB['ID'] = $max_id;

            if ($valDB['BIZ'] != 'IM') {
                $error_biz[$row - 1] = 'BIZ';
                $biz = $error_biz;
                $row_error[] = $row - 1;
                $query_db = '';
            }

            $sql .= "INSERT INTO `item` ( `ID`, `FACTORY`,`BIZ`, `LINE`, `TYPE`, `DRAWING`, `MODEL`, `PROCESS`, `JIG_NAME`, `PICTURE`, `ITEM`, `SPEC_DES`, `MIN`, `MAX`, `SPEC`, `PIC`, `PERIOD`, `LastUpdate` ) VALUES (
                    '" . $valDB['ID'] . "',
                    '" . $valDB['FACTORY'] . "',
                    '" . $valDB['BIZ'] . "',
                    '" . $valDB['LINE'] . "',
                    '" . $valDB['TYPE'] . "',
                    '" . $valDB['DRAWING'] . "',
                    '" . $valDB['MODEL'] . "',
                    '" . $valDB['PROCESS'] . "',
                    '" . $valDB['JIG_NAME'] . "',
                    '" . $valDB['PICTURE'] . "',
                    '" . $valDB['ITEM'] . "',
                    '" . $valDB['SPEC_DES'] . "',
                    '" . $valDB['MIN'] . "',
                    '" . $valDB['MAX'] . "',
                    '" . $valDB['SPEC'] . "',
                    '" . $valDB['PIC'] . "',
                    '" . $valDB['PERIOD'] . "',
                    NOW()
                    );";

            $max_id++;
        }

        if (mysqli_multi_query($con, $sql)) {
            while (mysqli_more_results($con)) {
                mysqli_next_result($con);
            }
            $response['response'] = true;
            $response['message'] = 'Complete.';
        } else {
            $response['response'] = false;
            $response['message'] = "Failed to query to MySQL: " . $con->error;
        }
    }
}

echo json_encode($response);
