<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP CHECK</title>


    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">
    <link href="framework/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">
    <script src="framework/js/a076d05399.js"></script>
    <link rel="stylesheet" href="framework/vendor/bootstrap/css/w3.css">
    <script src="framework/js/webcam.js"></script>
    <script src="framework/js/webcam.min.js"></script>
    <script src="framework/js/jquery-3.5.1.js"></script>
    <script src="framework/js/jquery.min.js"></script>
    <script src="framework/js/jquery-ui.js"></script>
    <script src="framework/js/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="framework/js/bootstrap/bootstrap.js"></script>
    <link href="framework/css/awesome/all.min.css" rel="stylesheet">
    <link href="framework/css/google.icon.css" rel="stylesheet">

    <script type="text/javascript" src="config/javascript/javascript_startup_check.js" async></script>
    <link rel="stylesheet" type="text/css" href="config/style/style_startup.css">
    <script src="framework/js/ga.js"></script>
    <script src="framework/js/adapter-latest.js"></script>
    <link rel="stylesheet" href="framework/css/main.css">

    <?php

        if (empty($_POST)) {
            header("Location: login.php?text=PLEASE LOGIN BEFORE DO STARTUP");
        } else {
            // print_r($_POST);
            // echo "<br>";

            require_once("connect.php");
            require_once("connect84.php");
            date_default_timezone_set("Asia/Bangkok");

            ////////////MODEL///////////////
            $MODEL = $_POST['MODEL'];
            $MODEL = str_replace(' ', '%%', $MODEL);
            $MODEL = str_replace('&nbsp', '%%', $MODEL);

            //////////MEMBER///////////////
            $MEMBER_ID = $_POST['MEMBER_ID'];
            $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);

            $BIZ = $objResult['BIZ'];
            $MEMBER_TYPE = $objResult['TYPE'];
            if ($MEMBER_TYPE == 'TECH') {
                $PIC = 'MFE';
            }
            if ($MEMBER_TYPE == 'OP') {
                $PIC = 'PROD';
            }

            /////////////LINE///////////////
            $LINE = $_POST['LINE'];

            $strSQL = "SELECT * FROM `biz` WHERE BIZ = '$BIZ'";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);
            $COUNTRY = $objResult['COUNTRY'];
            $FACTORY = $objResult['FACTORY'];

            /////////LINE_TYPE////////////
            $LINE_TYPE = $_POST['TYPE'];


            ///////// SHIFT & DATE ///////////////
            $DATE = date("Y-m-d");
            $now = date("H");
            if ($now >= 8 && $now < 20) {
                $SHIFT = 'DAY';
            } else {
                $SHIFT = 'NIGHT';
            }

            // echo "<br>";
            if($now >= 0 && $now <8){
                $DATE = date('Y-m-d', strtotime('-1 day', strtotime($DATE)));
            }else{
                $DATE;
            }

            ////////// ITEM //////////////////

            $strSQL = "SELECT * FROM `item` WHERE LINE LIKE '%$LINE%' AND MODEL LIKE '%$MODEL%' AND TYPE LIKE '%$LINE_TYPE%' ORDER BY `item`.`ID` ASC";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);
            $PERIOD = $objResult['PERIOD'];

            ///////// DATETIME DIFF //////////

            $strSQL = "SELECT * FROM `startup_time` 
                    WHERE `BIZ` LIKE '%$BIZ%' 
                    AND `LINE` LIKE '%$LINE%' 
                    AND `TYPE` LIKE '%$LINE_TYPE%' 
                    AND MODEL LIKE '%$MODEL%' 
                    AND SHIFT_DATE LIKE '%$DATE%'
                    AND SHIFT LIKE '%$SHIFT%'
                    ORDER BY STARTTIME DESC LIMIT 1";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);
            $TIME_ID = $objResult['ID'];
            $SHIFT_DB = $objResult['SHIFT'];
            $DATE_SHIFT = $objResult['SHIFT_DATE'];

            $LastUpdate = $objResult['DATETIME3'];
            // $LastUpdate = "2020-09-08 22:00:00";
            // echo "<br>";

            $STARTUPTIME = $objResult['STARTTIME'];
            // $STARTUPTIME = "2020-09-08 04:00:00";

            // echo "<br>";
            $now = date('Y-m-d H:i:s');
            // echo "<br>";

            $hour1 = 0;
            $hour2 = 0;

            $datetimeObj1 = new DateTime($LastUpdate);
            $datetimeObj2 = new DateTime($now);
            $datetimeObj3 = new DateTime($STARTUPTIME);

            $interval = $datetimeObj1->diff($datetimeObj2);
            if ($interval->format('%a') > 0) {
                $hour1 = $interval->format('%a') * 24;
            }
            if ($interval->format('%h') > 0) {
                $hour2 = $interval->format('%h');
            }

            $DIFF = $hour1 + $hour2;
            // echo "<br>";

            $hour1 = 0;
            $hour2 = 0;

            $interval = $datetimeObj3->diff($datetimeObj2);
            if ($interval->format('%a') > 0) {
                $hour1 = $interval->format('%a') * 24;
            }
            if ($interval->format('%h') > 0) {
                $hour2 = $interval->format('%h');
            }
            $DIFFSTARTTIME = $hour1 + $hour2;
            // echo "<br>";

            switch ($PERIOD) {
                case "SHIFT":
                    $RANGE = 12;
                    break;
                case "DAY":
                    $RANGE = 24;
                    break;
                case "WEEK":
                    $RANGE = 168;
                    break;
                case "MONTH":
                    $RANGE = 720;
                    break;
            }


            if (($LastUpdate == '0000-00-00 00:00:00') && ($DIFFSTARTTIME < $RANGE)) {
                if ($SHIFT != $SHIFT_DB) {
                    // echo "DIFF SHIFT (INSERT)";
                    $MODE = "INSERT";
                } else {
                    // echo "(UPDATE)";
                    $MODE = "UPDATE";
                }
            } else {
                if ($DIFF > $RANGE) {
                    // echo "EXPIRE (INSERT)";
                    $MODE = "INSERT";
                } else {
                    if ($SHIFT != $SHIFT_DB) {
                        // echo "DIFF SHIFT (INSERT)";
                        $MODE = "INSERT";
                    } else {
                        // echo "DO NOTHING JUST SHOW RESULT";
                        $MODE = "OK";
                    }
                }
            }
            ////////////////MODE WORKING////////////////
            // echo $MODE;
            if ($MODE == "INSERT") {
                // echo $MODE;
                // echo "<br>";
                $JUDGEMENT = '';

                $now_time = date('Y-m-d H:i:s');
                $DATE_RESULT = date('Y-m-d');
                $MODEL = str_replace('%%', ' ', $MODEL);

                $strSQL_test = "SELECT * FROM `item` WHERE LINE LIKE '%$LINE%' AND MODEL LIKE '%$MODEL%' AND TYPE LIKE '%$LINE_TYPE%' AND PIC LIKE '%$PIC%' ORDER BY `item`.`ID` ASC";
                $objQuery_test = mysqli_query($con, $strSQL_test);
                while ($objResult_test = mysqli_fetch_array($objQuery_test)) {
                    $PROCESS_TEST = $objResult_test['PROCESS'];
                    $ITEM_TEST = $objResult_test['ITEM'];
                    $SPEC_DES_TEST = $objResult_test['SPEC_DES'];
                    $SPEC_TEST = $objResult_test['SPEC'];
                    $MIN = $objResult_test['MIN'];
                    $MAX = $objResult_test['MAX'];

                    $strSQL55 = "INSERT INTO `startup_item` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `PROCESS`, `ITEM`, `SPEC_DES`, `MIN`, `MAX`, `SPEC`, `VALUE1`, `VALUE2`, `JUDGEMENT`, `REMARK`, `SHIFT_DATE`,`SHIFT` , `RESULT`, `LastUpdate`) 
                    VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL', '$PROCESS_TEST', '$ITEM_TEST', '$SPEC_DES_TEST', '$MIN', '$MAX', '$SPEC_TEST', '', '', '', '', '$DATE', '$SHIFT', '',NOW());";
                    $objQuery55 = mysqli_query($con, $strSQL55);
                }

                if($SHIFT == 'NIGHT'){
                    $SHIFT_RESULT = 'B';
                }else{
                    $SHIFT_RESULT = 'A';
                }

                $strSQL = "INSERT INTO `tbl_startup_check` VALUES ('','$DATE_RESULT','','$LINE','ON PROCESS','$SHIFT_RESULT','$now_time')";
                $objQuery = mysqli_query($con84, $strSQL);

                $strSQL = "INSERT INTO `startup_time` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `REMARK`, `SHIFT_DATE`, `SHIFT`, `STARTTIME`, `CONFIRM1`, `DATETIME1`, `CONFIRM2`, `DATETIME2`, `CONFIRM3`, `DATETIME3`, `TAKT`, `RESULT`) 
                        VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL', '', '$DATE', '$SHIFT', NOW(), '$MEMBER_ID', NOW(), '', '', '', '', '', '');";
                // VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL', '', '$SHIFT', '2020-09-19 04:14:53', '$MEMBER_ID', '2020-09-19 04:14:53', '', '', '', '', '', '');";

                $objQuery = mysqli_query($con, $strSQL);
                $MODEL = str_replace(' ', '%%', $MODEL);



                $strSQL = "SELECT ID FROM `startup_time` 
                    WHERE `COUNTRY` LIKE '$COUNTRY'
                    AND `FACTORY` LIKE '$FACTORY' 
                    AND `BIZ` LIKE '$BIZ' 
                    AND `LINE` LIKE '$LINE' 
                    AND `TYPE` LIKE '$LINE_TYPE' 
                    AND MODEL LIKE '$MODEL' 
                    AND SHIFT LIKE '$SHIFT' 
                    ORDER BY STARTTIME DESC LIMIT 1";
                $objQuery = mysqli_query($con, $strSQL);
                $objResult = mysqli_fetch_array($objQuery);
                $TIME_ID = $objResult['ID'];
                // echo "<br>";

                // print_r($objResult);
                // echo "<br>";
            } else if ($MODE == "UPDATE") {
                // echo $MODE;
                // echo "<br>";


                $strSQL = "SELECT * FROM `startup_item` 
                WHERE LINE LIKE '%$LINE%' 
                AND MODEL LIKE '%$MODEL%' 
                AND SHIFT LIKE '%$SHIFT%'
                AND TYPE LIKE '%$LINE_TYPE%'
                AND SHIFT_DATE LIKE '%$DATE%' 
                ORDER BY  `startup_item`.`ID` ASC";
                $objQuery = mysqli_query($con, $strSQL);
                $objResult = mysqli_fetch_array($objQuery);

                if (isset($objResult)) {
                    $MODE = "UPDATE";
                    $objQuery = mysqli_query($con, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                        $CUR_VALUE1[] = $objResult['VALUE1'];
                        $CUR_VALUE2[] = $objResult['VALUE2'];
                        $JUDGEMENT[] = $objResult['JUDGEMENT'];
                    }

                    $i = 0;
                } else {
                    $CUR_VALUE1 = '';
                    $CUR_VALUE2 = '';
                    $JUDGEMENT = '';
                }
            } else if ($MODE == "OK") {
                header("Location: http://43.72.52.52/startup2.0/visual_line.php?LINE=" . $LINE . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $DATE_SHIFT . "");
            } else {
                header("Location: http://43.72.52.52/startup2.0/");
                echo $test = 'NO LOOP';
            }
        }

        // echo '<br><br><br><br><br><br><br>';
        $SHIFT_SELECT = $SHIFT;
        $DATE_SELECT = $DATE;
    ?>

</head>

<body>
    <br><br>
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog-full-width modal-dialog momodel modal-fluid" role="document">
            <div class="modal-content-full-width modal-content">
                <div class="modal-header-full-width   modal-header text-center">
                    <h5 class="modal-title" id="exampleModalLongTitle">Camera</h5>
                    <button type="button" class="close" onclick="stopVideoOnly()" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <center>
                            <video id="video" autoplay></video>
                            <canvas id="canvas"></canvas>
                        </center>
                    </div>
                </div>
                <div class="modal-footer-full-width  modal-footer">
                    <div class="container">
                        <div class="row">
                            <!-- <center> -->
                            <div class="col"><a id='retake' class='btn btn-block m-1 hov' value="Configure" onClick="resetVideoOnly()"><i class="fas fa-sync-alt"></i></a></div>
                            <div class="col"><a id='switchcamera' class='btn btn-block m-1 hov' data-clicked="0" value=""><i class="material-icons">&#xe41e;</i></a></div>
                            <div class="col"><a id='snap' class='btn btn-block m-1 hov' onClick="take_snapshot()"><i class="fas fa-camera"></i></a></div>
                            <div class="col"><a id='save' class='btn btn-block m-1 hov' value="" onClick="saveSnap()"><i class="fa fa-check"></i></a></div>
                            <!-- </center> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $MODEL = str_replace('%%', ' ', $MODEL);
    ?>
    <!-- Main -->
    <div class="row text-center">
        <div class="col-lg-12 mx-auto">
            <h1><b>STARTUP CHECK SYSTEM</b></h1>
            <p1 class="lead">LINE : <?php echo $LINE; ?>, MODEL : <?php echo $MODEL; ?></p1><br><br><br><br>
        </div>
    </div>

    <form name="form" method="POST" action="startup_record.php">
        <div class="col-lg-12 mx-auto">
            <div class="row">
                <div class="scrollable">
                    <table class="table table-bordered table-hover">
                        <thead class="thead thead-dark">
                            <tr>
                                <div class="col-lg-12 mx-auto text-center">
                                    <th>PROCESS</th>
                                    <th>ITEM</th>
                                    <th>SPEC</th>
                                    <th>VALUE</th>
                                </div>
                            </tr>
                        </thead>
                        <?php

                        $MODEL = str_replace(' ', '%%', $MODEL);
                        $strSQL = "SELECT * FROM `item` WHERE LINE LIKE '%$LINE%' AND MODEL LIKE '%$MODEL%' AND TYPE LIKE '%$LINE_TYPE%' AND PIC LIKE '%$PIC%' ORDER BY `item`.`ID` ASC";

                        require_once("connect.php");
                        date_default_timezone_set("Asia/Bangkok");
                        include("config/php/function_startup_check.php");
                        ?>
                    </table>

                </div>
            </div>
        </div>

        <br><br>

        <div class="col-lg-12 mx-auto text-center">
            <input type="submit" class="btn btn-dark" value="RECORD">
        </div>

    </form>

</body>

</html>