<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP 2.0</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">

    <!-- w3 school CSS -->
    <link rel="stylesheet" href="framework/vendor/bootstrap/css/w3.css">
    <script src="framework/js/jquery.min.js"></script>
    <script src="framework/js/bootstrap/bootstrap.min.js"></script>

    <style>
        input[type=text],
        input[type=password] {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
    </style>


    <?php

    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");

    $GLOBAL_NOW = date("Y-m-d H:i:s");


    if (empty($_GET)) {

        $DATE = date("Y-m-d");
        $now = date("H");
        if ($now >= 8 && $now < 20) {
            $SHIFT = 'DAY';
        } else {
            $SHIFT = 'NIGHT';
            if ($now >= 0 && $now < 8) {
                $DATE = date("Y-m-d", strtotime("-1 days", strtotime($DATE)));
                // echo "NIGHT AFTER ZERO";
                // echo $SHIFT;
            } else if ($now >= 20 && $now <= 23) {
                // echo $DATE;
                $DATE = date("Y-m-d");
                // echo $now;
                echo "NIGHT BEFORE ZERO";
            } else {
                echo $SHIFT . "<br>";
                echo $DATE . "<br>";
                echo "WRONG DAY TO NIGHT";
                // echo $newDate;
            }
        }
        // echo $SHIFT;
        $ItemID = $_POST['ItemID'];
        $VALUE1 = $_POST['VALUE1'];
        if (isset($_POST['VALUE2'])) {
            $VALUE2 = $_POST['VALUE2'];
        }

        $MEMBER_ID = $_POST['MEMBER_ID'];
        $TIME_ID = $_POST['TIME_ID'];
        $MODE = $_POST['MODE'];
        // $MODE = "UPDATE";
        $LINE = $_POST['LINE'];
        $MODEL = $_POST['MODEL'];
        $TYPE = $_POST['TYPE'];

        $strSQL = "SELECT * FROM `startup_item` 
            WHERE LINE LIKE '%$LINE%' 
            AND MODEL LIKE '%$MODEL%' 
            AND SHIFT LIKE '%$SHIFT%' 
            AND TYPE LIKE '%$TYPE%'
            AND LastUpdate LIKE '$DATE%' 
            ORDER BY `startup_item`.`ID` ASC";


        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        $BIZ = $objResult['BIZ'];


        if (isset($MODE)) {
            if ($MODE == 'NO PRODUCTION') {

                // $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
                // $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                echo "NO PRODUCTION";
                $text = 'NO PRODUCTION';
            }
            if ($MODE == "UPDATE") {

                $strSQL = "UPDATE `startup_time` SET `STATUS` = 'RUN', `DATETIME1` = '$GLOBAL_NOW', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
                $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                $text = $LINE . '<br><p>UPDATE COMPLETE</p>';
            }
        } else {
            header("Location: login.php?text=PLEASE LOGIN BEFORE DO STARTUP");
            echo $test = 'NO LOOP';
            $text = 'PLEASE LOGIN';
        }
    } else {
        $LINE = $_GET['LINE'];
        $MEMBER_ID = $_GET['MEMBER_ID'];
        $PERIOD = $_GET['PERIOD'];
        // $PERIOD = 'SHIFT';
        // echo $_GET['LINE_TYPE'];
        if (isset($_GET['LINE_TYPE'])) {
            $LINE_TYPE = $_GET['LINE_TYPE'];
            if ($LINE_TYPE == '' || $LINE_TYPE == null) {
                $LINE_TYPE = 'ALL TYPE';
            }
        } else {
            $LINE_TYPE = 'ALL TYPE';
        }
        // echo $LINE_TYPE;
        if (empty($_GET["SHIFT"]) && empty($_GET["shift_date"])) {
            // echo 'if';
            $sql_shift = "SELECT * FROM `target_shift` WHERE `LINE` = '$LINE'";
            $query_shift = mysqli_query($con, $sql_shift);
            $row_shift = mysqli_fetch_array($query_shift, MYSQLI_ASSOC);

            if ((time() >= strtotime($row_shift["START_TIME_SHIFT_DAY"])) && (time() <= strtotime($row_shift["TARGET_TIME_SHIFT_DAY"]))) {
                $SHIFT = 'DAY';
                $check_time_startup = "YES";
            } else if ((time() >= strtotime($row_shift["START_TIME_SHIFT_NIGHT"])) && (time() <= strtotime($row_shift["TARGET_TIME_SHIFT_NIGHT"]))) {
                $SHIFT = 'NIGHT';
                $check_time_startup = "YES";
            } else {
                $check_time_startup = "NO";
            }
            $DATE = $row_shift["SHIFT_DATE"];
        } else {
            $SHIFT = $_GET["SHIFT"];
            $DATE = $_GET["SHIFT_DATE"];
            $check_time_startup = "YES";

            if ($SHIFT == 'DAY') {
                $SHIFT = 'NIGHT';
            } else if ($SHIFT == 'NIGHT') {
                $SHIFT = 'DAY';
            }
            $DATE = date('Y-m-d', strtotime('-1 day', strtotime($DATE)));
        }

        // check center 
        $sql_line = "SELECT * FROM `startup_line` WHERE `LINE` = '$LINE'";
        $query_line = mysqli_query($con, $sql_line);
        $row_line = mysqli_fetch_array($query_line);
        // $LINE_CENTER = $_GET['LINE_CENTER'];
        if ($row_line['TYPE'] == 'CENTER') {
            $MODEL = $_GET["MODEL"];
            $STATUS = 'NO PRODUCTION';
            $SHIFT = 'DAY';
        } else {
            $STATUS = 'NO PRODUCTION';
            $MODEL = 'NO PRODUCTION';
        }
        $DATE_SHIFT = $DATE;
        // $DATE = $_GET["SHIFT_DATE"];
        // echo $DATE;

        // echo $SHIFT .'<br>'. $DATE;

        // if (empty($_GET['SHIFT']) || empty($_GET['SHIFT_DATE'])) {
        //     $DATE = date("Y-m-d");
        //     $now = date("H");
        //     if ($now >= 8 && $now < 20) {
        //         $SHIFT = 'DAY';
        //     } else {
        //         $SHIFT = 'NIGHT';
        //         if ($now >= 0 && $now < 8) {
        //             $DATE = date("Y-m-d", strtotime("-1 days", strtotime($DATE)));
        //             // echo "NIGHT AFTER ZERO";
        //             // echo $SHIFT;
        //         } else if ($now >= 20 && $now <= 23) {
        //             // echo $DATE;
        //             $DATE = date("Y-m-d");
        //             // echo $now;
        //             echo "NIGHT BEFORE ZERO";
        //         } else {
        //             echo $SHIFT . "<br>";
        //             echo $DATE . "<br>";
        //             echo "WRONG DAY TO NIGHT";
        //             // echo $newDate;
        //         }
        //     }
        // } else {
        //     $DATE = $_GET['SHIFT_DATE'];
        //     if($_GET['SHIFT'] == 'DAY'){
        //         $SHIFT = 'NIGHT';
        //     }else{
        //         $SHIFT = 'DAY';
        //     }
        // }

        $strSQL = "SELECT BIZ FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        $BIZ = $objResult['BIZ'];

        $strSQL = "SELECT * FROM `biz` WHERE BIZ = '$BIZ'";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);
        $COUNTRY = $objResult['COUNTRY'];
        $FACTORY = $objResult['FACTORY'];

        $strSQL = "INSERT INTO `startup_item` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `VALUE1`, `SHIFT_DATE`, `SHIFT`,`PERIOD`, `LastUpdate`)
            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL' , 'NO PRODUCTION', '$DATE', '$SHIFT','$PERIOD', '$GLOBAL_NOW');";
        $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

        $strSQL = "INSERT INTO `startup_time` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `REMARK`, `SHIFT_DATE`, `SHIFT`,`PERIOD`,`STATUS`,`STARTTIME`, `CONFIRM1`, `DATETIME1`, `CONFIRM2`, `DATETIME2`, `CONFIRM3`, `DATETIME3`, `TAKT`, `RESULT`) 
            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL', '', '$DATE', '$SHIFT','$PERIOD','$STATUS', '$GLOBAL_NOW ', '$MEMBER_ID', '', '', '', '', '', '', '');";
        $objQuery = mysqli_query($con, $strSQL);

        $strSQL = "SELECT ID FROM `startup_time`
            WHERE `BIZ` LIKE '$BIZ'
            AND `LINE` LIKE '$LINE'
            AND `TYPE` LIKE '$LINE_TYPE'
            AND `SHIFT` LIKE '$SHIFT'
            ORDER BY STARTTIME DESC LIMIT 1";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        $TIME_ID = $objResult['ID'];

        $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";

        $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);
        //////UPDATE GOOD STARTUP TO 84 MONITOR///////////

        if ($SHIFT == 'DAY') {
            $SHIFT_SEND = 'A';
        } else {
            $SHIFT_SEND = 'B';
        }

        require_once("connect84.php");
        $strSQL = "INSERT INTO `di_cl`.`tbl_startup_check` 
            (`data_id` , `shift_date` , `for_model` ,`line` ,`result` ,`shift` , `rec_date`)
            VALUES 
            (NULL , '$DATE', '$BIZ', '$LINE', 'STOP', '$SHIFT_SEND', '$GLOBAL_NOW ')";
        // $objQuery = mysqli_query($con84, $strSQL);

        $color = '';
        $text = $LINE . '<br><p>NO PRODUCTION</p>';
    }
    ?>
</head>

<body>
    <section id="login">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>SMART STARTUP CHECK</b></h1><BR><BR>
                    <h1 class="text-success">UPDATE COMPLETE</h1>
                    <h1 class="text-success"><?php echo $text ?></h1>
                    <BR><BR><BR><BR>
                </div>
                <div class="col-lg-6 mx-auto">
                    <a href="startup_c.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>" class="btn btn-dark">STARTUP MORE</a>
                    <?php
                    if (isset($TIME_ID)) {
                        $sql = "SELECT * FROM `startup_time` WHERE ID = '" . $TIME_ID . "'";
                        $query = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                        $LINE = $row["LINE"];
                        $SHIFT = $row["SHIFT"];
                        $DATE_SHIFT = $row["SHIFT_DATE"];
                        $BIZ = $row["BIZ"];
                        $PERIOD = $row["PERIOD"];
                        // $LINE = $row["LINE"];
                    }
                    ?>
                    <a href="visual_line.php?LINE=<?php echo $LINE ?>&DATE=<?php echo $DATE ?>&SHIFT=<?php echo $SHIFT ?>&DATE_SHIFT=<?php echo $DATE_SHIFT ?>&BIZ=<?php echo $BIZ ?>&PERIOD=<?php echo $PERIOD ?>" class="btn btn-success">CHECK RESULT</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>