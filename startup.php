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
    <script src="framework/js/sweetalert2@9.js"></script>

    <style>
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(framework/img/Preloader.gif) center no-repeat #fff;
        }
    </style>

    <script>
        $(document).ready(function() {
            $(".se-pre-con").fadeOut(2000);

            $("tr").click(function() {
                table = $(this).find('table');

                trId = table.prevObject[0].id;
                var TrItem = document.getElementById(trId);
            });
            $("input").keyup(function() {
                trId = table.prevObject[0].id;
                var TrItem = document.getElementById(trId);

                input = $(this).find(':input');
                InputObj = input.prevObject[0];
                id = $(InputObj).attr('id');
                idObj = $(InputObj).find(id);

                console.log(idObj)

                valueType = $(InputObj).attr('name');

                value = idObj.prevObject[0].value;
                type = idObj.prevObject[0].type;
                console.log(type);

                if (type == 'number') {
                    min = idObj.prevObject[0].min;
                    max = idObj.prevObject[0].max;

                    value = parseFloat("" + value + "");
                    min = parseFloat(min);
                    max = parseFloat(max);

                    console.log(min)
                    console.log(max)
                    console.log(value)

                    if (value >= min && value <= max) {
                        console.log("OKKKK")
                    } else {
                        console.log("NOOOOOOO")
                    }

                    if ((value >= min) && (value <= max)) {
                        $(TrItem).removeClass().addClass("table-success");
                        JUDGEMENT = 'PASS';
                    } else if ((value < min) || (value > max)) {
                        $(TrItem).removeClass().addClass("table-danger");
                        JUDGEMENT = 'FAIL';
                    } else {
                        $(TrItem).removeClass().addClass("table-default");
                        JUDGEMENT = 'BLANK';
                    }

                } else if (type == 'text') {
                    if (this.id.includes("V2")) {
                        var id = this.id.substring(2);
                    } else {
                        var id = this.id;
                    }
                    var max = document.getElementById("MAX" + id)
                    if ((value == max.value)) {
                        $(TrItem).removeClass().addClass("table-success");
                        JUDGEMENT = 'PASS';
                    } else if ((value != max.value)) {
                        $(TrItem).removeClass().addClass("table-danger");
                        JUDGEMENT = 'FAIL';
                    } else {
                        $(TrItem).removeClass().addClass("table-default");
                        JUDGEMENT = 'BLANK';
                    }

                }
                update(value);
            });
            $("select").change(function() {
                trId = table.prevObject[0].id;
                var TrItem = document.getElementById(trId);

                input = $(this).find(':input');
                InputObj = input.prevObject[0];
                id = $(InputObj).attr('id');
                idObj = $(InputObj).find(id);

                valueType = $(InputObj).attr('name');

                value = idObj.prevObject[0].value;
                type = idObj.prevObject[0].type;

                spec = idObj.prevObject[0].children[3].value;

                if (type == 'select-one') {

                    if (value == spec) {
                        $(TrItem).removeClass().addClass("table-success");
                        JUDGEMENT = 'PASS';
                    } else if (value == '') {
                        $(TrItem).removeClass().addClass("table-default");
                        JUDGEMENT = 'BLANK';
                    } else {
                        $(TrItem).removeClass().addClass("table-danger");
                        JUDGEMENT = 'FAIL';
                    }
                }
                update(value);
            });
            $("input").change(function() {
                trId = table.prevObject[0].id;
                var TrItem = document.getElementById(trId);

                input = $(this).find(':input');
                InputObj = input.prevObject[0];
                id = $(InputObj).attr('id');
                idObj = $(InputObj).find(id);

                valueType = $(InputObj).attr('name');

                value = idObj.prevObject[0].value;
                type = idObj.prevObject[0].type;

                if (type == 'date') {

                    var value2 = new Date(value);
                    console.log(value2)
                    console.log(value)

                    if (value !== '') {
                        $(TrItem).removeClass().addClass("table-success");
                        JUDGEMENT = 'PASS';
                    } else {
                        $(TrItem).removeClass().addClass("table-default");
                        JUDGEMENT = 'BLANK';
                    }

                }
                update(value);
            });
        });

        function update() {
            console.log(JUDGEMENT)
            $.ajax({
                url: "config/php/update_input.php",
                type: "POST",
                data: {
                    'ID': trId,
                    'VALUE': value,
                    'VALUE_TYPE': valueType,
                    'JUDGEMENT': JUDGEMENT,
                },
                success: function() {
                    // alert("ok");
                }
            });
        }

        function removeValue1Spec() {
            $('input[name ="VALUE1[]"]').removeAttr("min");
            $('input[name ="VALUE1[]"]').removeAttr("max");
        }
    </script>
    <!-- PHP get parameter -->
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
        // $DATE = date("Y-m-d");
        // $now = date("H");
        // if ($now >= 8 && $now < 20) {
        //     $SHIFT = 'DAY';
        // } else {
        //     $SHIFT = 'NIGHT';
        // }

        // echo "<br>";
        // if ($now >= 0 && $now < 8) {
        //     $DATE = date('Y-m-d', strtotime('-1 day', strtotime($DATE)));
        // } else {
        //     $DATE;
        // }

        if (empty($_POST["SHIFT"]) || empty($_POST["shift_date"])) {
            $sql_shift = "SELECT * FROM `target_shift` WHERE `LINE` = '$LINE'";
            $query_shift = mysqli_query($con, $sql_shift);
            $row_shift = mysqli_fetch_array($query_shift, MYSQLI_ASSOC);

            if ((time() >= strtotime($row_shift["START_TIME_SHIFT_DAY"])) && (time() <= strtotime($row_shift["TARGET_TIME_SHIFT_DAY"]))) {
                $SHIFT = 'DAY';
                $DATE = $row_shift["SHIFT_DATE"];
                $check_time_startup = "YES";
            } else if ((time() >= strtotime($row_shift["START_TIME_SHIFT_NIGHT"])) && (time() <= strtotime($row_shift["TARGET_TIME_SHIFT_NIGHT"]))) {
                $SHIFT = 'NIGHT';
                $DATE = $row_shift["SHIFT_DATE"];
                $check_time_startup = "YES";
            } else {
                // echo 'Not Working';
                $check_time_startup = "NO";
            }
        } else {
            $SHIFT = $_POST["SHIFT"];
            $DATE = $_POST["shift_date"];
            $check_time_startup = "YES";

            if ($SHIFT == 'DAY') {
                $SHIFT = 'NIGHT';
            } else if ($SHIFT == 'NIGHT') {
                $SHIFT = 'DAY';
            }
        }

        // ECHO $SHIFT;
        // ECHO $DATE;
        echo 'STARTUP';

        ////////// ITEM //////////////////
        if ($check_time_startup <> "NO") {
            $strSQL = "SELECT * FROM `item` WHERE LINE = '$LINE' AND MODEL = '$MODEL' AND TYPE = '$LINE_TYPE' ORDER BY `item`.`ID` ASC";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);
            $PERIOD = $objResult['PERIOD'];

            ///////// DATETIME DIFF //////////

            $strSQL = "SELECT * FROM `startup_time` 
                        WHERE `BIZ` = '$BIZ' 
                        AND `LINE` = '$LINE' 
                        AND `TYPE` = '$LINE_TYPE' 
                        AND `MODEL` = '$MODEL' 
                        AND `SHIFT_DATE` = '$DATE'
                        AND `SHIFT` = '$SHIFT'
                        ORDER BY `startup_time`.`STARTTIME` DESC LIMIT 1";
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


            $datetimeObj1 = strtotime($LastUpdate);
            $datetimeObj2 = strtotime($now);
            $datetimeObj3 = strtotime($STARTUPTIME);



            $d1 = date('d', $datetimeObj1);
            $d2 = date('d', $datetimeObj2);
            $d3 = date('d', $datetimeObj3);

            $H1 = date('H', $datetimeObj1);
            $H2 = date('H', $datetimeObj2);
            $H3 = date('H', $datetimeObj3);


            if (($d2 - $d1) > 0) {
                $hour1 = ($d2 - $d1) * 24;
            }
            if (($H2 - $H1) > 0) {
                $hour2 = ($H2 - $H1);
            }

            $DIFF = $hour1 + $hour2;
            // echo "<br>";

            $hour1 = 0;
            $hour2 = 0;

            if (($d3 - $d2) > 0) {
                $hour1 = ($d3 - $d2) * 24;
            }
            if (($H3 - $H2) > 0) {
                $hour2 = ($H3 - $H2);
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

                $strSQL_test = "SELECT * FROM `item` WHERE LINE = '$LINE' AND MODEL = '$MODEL' AND TYPE = '$LINE_TYPE' AND PIC = '%$PIC%' ORDER BY `item`.`ID` ASC";
                $objQuery_test = mysqli_query($con, $strSQL_test);
                while ($objResult_test = mysqli_fetch_array($objQuery_test)) {
                    $PROCESS_TEST = $objResult_test['PROCESS'];
                    $ITEM_TEST = $objResult_test['ITEM'];
                    $SPEC_DES_TEST = $objResult_test['SPEC_DES'];
                    $SPEC_TEST = $objResult_test['SPEC'];
                    $MIN = $objResult_test['MIN'];
                    $MAX = $objResult_test['MAX'];

                    $DRAWING = $objResult_test['DRAWING'];
                    $JIG_NAME = $objResult_test['JIG_NAME'];
                    $PICTURE = $objResult_test['PICTURE'];
                    $PERIOD_CHECK = 'SHIFT';
                    // $PERIOD_CHECK = $objResult_test['PERIOD'];

                    $strSQL55 = "INSERT INTO `startup_item` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `DRAWING`, `MODEL`, `PROCESS`, `JIG_NAME`, `PICTURE`, `ITEM`, `SPEC_DES`, `MIN`, `MAX`, `SPEC`, `VALUE1`, `VALUE2`, `JUDGEMENT`, `REMARK`, `SHIFT_DATE`,`SHIFT`,`PERIOD` , `RESULT`, `LastUpdate`) 
                        VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$DRAWING', '$MODEL', '$PROCESS_TEST', '$JIG_NAME', '$PICTURE', '$ITEM_TEST', '$SPEC_DES_TEST', '$MIN', '$MAX', '$SPEC_TEST', '', '', '', '', '$DATE', '$SHIFT','$PERIOD_CHECK', '',NOW());";
                    $objQuery55 = mysqli_query($con, $strSQL55);
                }

                if ($SHIFT == 'NIGHT') {
                    $SHIFT_RESULT = 'B';
                } else {
                    $SHIFT_RESULT = 'A';
                }

                $strSQL = "INSERT INTO `tbl_startup_check` VALUES ('','$DATE_RESULT','','$LINE','ON PROCESS','$SHIFT_RESULT','$now_time')";
                $objQuery = mysqli_query($con84, $strSQL);

                $strSQL = "INSERT INTO `startup_time` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `REMARK`, `SHIFT_DATE`, `SHIFT`, `PERIOD`, `STARTTIME`, `CONFIRM1`, `DATETIME1`, `CONFIRM2`, `DATETIME2`, `CONFIRM3`, `DATETIME3`, `TAKT`, `RESULT`) 
                            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL', '', '$DATE', '$SHIFT','$PERIOD_CHECK', NOW(), '$MEMBER_ID', NOW(), '', '', '', '', '', '');";
                // VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL', '', '$SHIFT', '2020-09-19 04:14:53', '$MEMBER_ID', '2020-09-19 04:14:53', '', '', '', '', '', '');";

                $objQuery = mysqli_query($con, $strSQL);
                $MODEL = str_replace(' ', '%%', $MODEL);



                $strSQL = "SELECT ID FROM `startup_time` 
                        WHERE `COUNTRY` = '$COUNTRY'
                        AND `FACTORY` = '$FACTORY' 
                        AND `BIZ` = '$BIZ' 
                        AND `LINE` = '$LINE' 
                        AND `TYPE` = '$LINE_TYPE' 
                        AND MODEL = '$MODEL' 
                        AND SHIFT = '$SHIFT' 
                        ORDER BY STARTTIME DESC LIMIT 1";
                $objQuery = mysqli_query($con, $strSQL);
                $objResult = mysqli_fetch_array($objQuery);
                $TIME_ID = $objResult['ID'];

                echo "<script>location.reload();</script>";

                // echo "<br>";

                // print_r($objResult);
                // echo "<br>";
            } else if ($MODE == "UPDATE") {
                // echo $MODE;
                // echo "<br>";


                $strSQL = "SELECT * FROM `startup_item` 
                    WHERE `LINE` = '$LINE' 
                    AND `MODEL` = '$MODEL' 
                    AND `SHIFT` = '$SHIFT'
                    AND `TYPE` = '$LINE_TYPE'
                    AND `SHIFT_DATE` = '$DATE' 
                    ORDER BY  `startup_item`.`ID` ASC";
                $objQuery = mysqli_query($con, $strSQL);
                $objResult = mysqli_fetch_array($objQuery);

                if (isset($objResult)) {
                    $MODE = "UPDATE";
                    $objQuery = mysqli_query($con, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                        $ID[] = $objResult['ID'];
                        $CUR_VALUE1[] = $objResult['VALUE1'];
                        $CUR_VALUE2[] = $objResult['VALUE2'];
                        $JUDGEMENT[] = $objResult['JUDGEMENT'];
                    }
                    $i = 0;
                } else {
                    $ID = '';
                    $CUR_VALUE1 = '';
                    $CUR_VALUE2 = '';
                    $JUDGEMENT = '';
                }
            } else if ($MODE == "OK") {
                echo "<script>window.location.replace('http://43.72.52.51/startup2.0/visual_line.php?LINE=" . $LINE . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $DATE_SHIFT . "');</script>";
            } else {
                echo "<script>window.location.replace('http://43.72.52.51/startup2.0/')</script>";
                echo $test = 'NO LOOP';
            }
        } else {
            echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'ERROR',
            text: 'ยังไม่อยู่ในช่วงเวลาทำกรุณาติดต่อ PIC เพื่อเลื่อนเวลา',
        }).then(function(){
            window.location.href='startup_c.php?MEMBER_ID=" . $MEMBER_ID . "'
        })
    </script>";
        }
    }


    $SHIFT_SELECT = $SHIFT;
    $DATE_SELECT = $DATE;
    ?>

</head>

<body>
    <div class="se-pre-con"></div>

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


        <input type='hidden' name="MODE" value="<?php echo $MODE; ?>">
        <input type='hidden' name="DATE_SELECT" value="<?php echo $DATE_SELECT; ?>">
        <input type='hidden' name="LINE" value="<?php echo $LINE; ?>">
        <input type='hidden' name="LINE_TYPE" value="<?php echo $LINE_TYPE; ?>">
        <input type='hidden' name="SHIFT_SELECT" value="<?php echo $SHIFT_SELECT; ?>">
        <input type='hidden' name="MODEL" value="<?php echo $MODEL; ?>">
        <input type='hidden' name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">
        <input type='hidden' name="TIME_ID" value="<?php echo $TIME_ID; ?>">
        <div class="col-lg-12 mx-auto">
            <div class="row">
                <div class="scrollable">
                    <table class="table table-bordered table-hover">
                        <thead class="thead thead-dark">
                            <tr>
                                <div class="col-lg-12 mx-auto text-center">
                                    <!-- <th>ID</th> -->
                                    <th>PROCESS</th>
                                    <th class="col-lg-2">PICTURE</th>
                                    <th>ITEM</th>
                                    <th>SPEC</th>
                                    <th>VALUE</th>
                                </div>
                            </tr>
                        </thead>
                        <?php
                        $MODEL = str_replace(' ', '%%', $MODEL);
                        $strSQL = "SELECT * FROM `startup_item`
                        WHERE `LINE` = '$LINE'
                        AND `MODEL` = '$MODEL'
                        AND `SHIFT` = '$SHIFT'
                        AND `TYPE` = '$LINE_TYPE'
                        AND `SHIFT_DATE` = '$DATE'
                        ORDER BY  `startup_item`.`ID` ASC";

                        require_once("connect.php");
                        date_default_timezone_set("Asia/Bangkok");
                        include("config/php/function_startup_check51.php");

                        ?>

                        <input type='hidden' name="TYPE" value="<?php echo $TYPE; ?>">

                    </table>
                </div>
            </div>
        </div>

        <br><br>

        <div class="col-lg-12 mx-auto text-center">
            <input type="submit" class="btn btn-dark" value="RECORD" onclick="removeValue1Spec()">
        </div>



    </form>

</body>

</html>