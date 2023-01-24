<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP CHECK</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">

    <script src="framework/js/a076d05399.js"></script>

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

        .animated {
            background-image: url(framework/img/SMART_LOGO.png);
            background-repeat: no-repeat;
            background-position: left top;
            /* padding-top: 95px;
            margin-bottom: 60px; */
            -webkit-animation-duration: 3s;
            animation-duration: 3s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        @-webkit-keyframes fadeInDown {
            0% {
                opacity: 0;
                -webkit-transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                -webkit-transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeInDown {
            -webkit-animation-name: fadeInDown;
            animation-name: fadeInDown;
        }

        .fadeInUp {
            -webkit-animation-name: fadeInUp;
            animation-name: fadeInUp;
        }
    </style>

</head>

<body>

    <?php
    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");

    if (isset($_GET['STARTUP_DATE'])) {
        $DATE = $_GET['STARTUP_DATE'];
    } else {
        $DATE = date("Y-m-d");
    }

    if (isset($_GET["PERIOD"])) {
        $PERIOD_GET = $_GET["PERIOD"];
    } else {
        $PERIOD_GET = 'DAY';
    }

    if (strpos($DATE, 'W') !== true && $PERIOD_GET == 'WEEK') {
        $DATE = date('Y', strtotime($DATE)) . '-W' . date('W', strtotime($DATE));
    } else {
        if (strpos($DATE, 'W')) {
            $DATE = date("Y-m-d");
        } else {
            if (isset($_GET['STARTUP_DATE'])) {
                $DATE = $_GET['STARTUP_DATE'];
            } else {
                $DATE = date("Y-m-d");
            }
        }
    }
    // echo $DATE;

    if (isset($_GET['STARTUP_SHIFT'])) {
        $SHIFT = $_GET['STARTUP_SHIFT'];
    } else {
        $now = date("H");
        if ($now >= 8 && $now < 20) {
            $SHIFT = 'DAY';
        } else {
            $SHIFT = 'NIGHT';
            if ($now >= 0 && $now < 8) {
                $DATE = date("Y-m-d", strtotime("-1 days", strtotime($DATE)));
            } else if ($now >= 20 && $now <= 23) {
                $DATE = date("Y-m-d");
            }
        }
    }
    $BIZ = $_GET['BIZ'];


    if ($BIZ == 'IM' || $BIZ == 'IM') {
        if ($BIZ == 'IM') {
            $BIZ = "IM";
        }

        // require_once("connectLine.php");
        // $strSQL = "SELECT line_name FROM `checkin_production_line` ORDER BY line_name ASC ";
        // $objQuery = mysqli_query($conLine, $strSQL);
        // while ($objResult = mysqli_fetch_array($objQuery)) {
        //     $LINE[] = $objResult['line_name'];
        // }
        // array_push($LINE, "HEH1");
        // array_push($LINE, "SRPC");
        // array_push($LINE, "FES");
        // array_push($LINE, "HEM");

        $strSQL = "SELECT `LINE`,`TYPE` FROM `startup_line` ORDER BY LINE ASC ";
        $objQuery = mysqli_query($con, $strSQL);
        while ($objResult = mysqli_fetch_array($objQuery)) {
            $LINE[] = $objResult['LINE'];
            $LINE_TYPE[] = $objResult['TYPE'];
        }

        $BIZ = 'IM';
    }
    sort($LINE);

    if ($PERIOD_GET == 'SHIFT') {
        $PERIOD_GET_SHIFT = 'checked';
        $PERIOD_GET_DAILY = '';
        $PERIOD_GET_WEEK = '';

        $PERIOD_GET_SHIFT_CLASS = 'active';
        $PERIOD_GET_DAILY_CLASS = '';
    } else if ($PERIOD_GET == 'DAY') {
        $PERIOD_GET_SHIFT = '';
        $PERIOD_GET_DAILY = 'checked';
        $PERIOD_GET_WEEK = '';

        $PERIOD_GET_SHIFT_CLASS = '';
        $PERIOD_GET_DAILY_CLASS = 'active';
        $PERIOD_GET_WEEK_CLASS = '';
    } else {
        $PERIOD_GET_SHIFT = '';
        $PERIOD_GET_DAILY = '';
        $PERIOD_GET_WEEK = 'checked';

        $PERIOD_GET_SHIFT_CLASS = '';
        $PERIOD_GET_DAILY_CLASS = '';
        $PERIOD_GET_WEEK_CLASS = 'active';
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow"> -->
        <a class="navbar-brand" href="http://43.72.52.52/system/">SONY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="http://43.72.52.51/startup2.0/">HOME <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="http://43.72.52.51/startup2.0/login.php?BIZ=<?php echo $BIZ; ?>">LOGIN</a>
                </li>
            </ul>
        </div>
    </nav>
    <br><br><br>
    <!-- End Navbar -->

    <div class="row text-center">
        <div class="col-lg-12 mx-auto">
            <img src="" width="15%">
            <h1><b class="animated fadeInDown"><a style="color:black;" href="http://43.72.52.51/startup2.0/">SMART STARTUP CHECK</a></b></h1>
            <p class="lead">startup result update</p>

            <form action="visual.php" medthod="GET" class="text-center" id="form_search">
                <input type="hidden" name="BIZ" value="<?php echo $BIZ; ?>">
                <div class="container text-center">
                    <div class="row text-center justify-content-center form-group">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary <?php echo $PERIOD_GET_SHIFT_CLASS ?>">
                                <input type="radio" class="PERIOD" name="PERIOD" id="option1" value="SHIFT" autocomplete="off" <?php echo $PERIOD_GET_SHIFT ?>> SHIFT
                            </label>
                            <label class="btn btn-secondary <?php echo $PERIOD_GET_DAILY_CLASS ?>">
                                <input type="radio" class="PERIOD" name="PERIOD" id="option2" value="DAY" autocomplete="off" <?php echo $PERIOD_GET_DAILY ?>> DAILY
                            </label>
                            <label class="btn btn-secondary <?php echo $PERIOD_GET_WEEK_CLASS ?>">
                                <input type="radio" class="PERIOD" name="PERIOD" id="option3" value="WEEK" autocomplete="off" <?php echo $PERIOD_GET_WEEK ?>> WEEKLY
                            </label>
                        </div>
                    </div>
                    <div class="row text-center justify-content-center form-group">
                        <?php if ($PERIOD_GET == "WEEK") { ?>
                            <div class="col-auto text-center">
                                <input class="form-control text-center" type="week" name="STARTUP_DATE" max="<?php echo date('W') ?> " value="<?php echo $DATE; ?>">
                            </div>
                        <?php } else if ($PERIOD_GET == "DAY") { ?>
                            <div class="col-auto text-center">
                                <input class="form-control text-center" type="date" name="STARTUP_DATE" max="<?php echo date('Y-m-d') ?> " value="<?php echo $DATE; ?>">
                            </div>
                        <?php } else { ?>
                            <div class="col-auto text-center">
                                <input class="form-control text-center" type="date" name="STARTUP_DATE" max="<?php echo date('Y-m-d') ?> " value="<?php echo $DATE; ?>">
                            </div>
                            <div class="col-auto text-center" id="STARTUP_SHIFT_DIV">
                                <select class="form-control" id="STARTUP_SHIFT" name="STARTUP_SHIFT">
                                    <option disabled>SHIFT</option>
                                    <?php if ($SHIFT == 'DAY') { ?>
                                        <option value="DAY" selected>DAY</option>
                                        <option value="NIGHT">NIGHT</option>
                                    <?php } else if ($SHIFT == 'NIGHT') { ?>
                                        <option value="DAY">DAY</option>
                                        <option value="NIGHT" selected>NIGHT</option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>

                        <div class="col-auto text-center">
                            <button class="form-control btn btn-primary" type="submit">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
            <br><br>

            <script>
                $(document).ready(function() {
                    $(".PERIOD").click(function() {
                        $("#form_search").submit();
                    })
                })
            </script>

            <div class="container">
                <table class="table thead-light table-hover">
                    <div style="overflow-x:auto;">
                        <thead class="thead-dark text-black">
                            <tr>
                                <th width="20%" align="center">LINE</th>
                                <th width="10%" align="center">PASS</th>
                                <th width="10%" align="center">TOTAL</th>
                                <th width="10%" align="center">STATUS</th>
                                <th width="20%" align="center">LINE</th>
                                <th width="10%" align="center">PASS</th>
                                <th width="10%" align="center">TOTAL</th>
                                <th width="10%" align="center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // diff time
                            function DateDiff($strDate1, $strDate2)
                            {
                                return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
                            }

                            if ($PERIOD_GET == 'DAY') {
                                echo '
                                <script>
                                    $(document).ready(function() {
                                        document.getElementById("STARTUP_SHIFT").disabled = true;
                                        document.getElementById("STARTUP_SHIFT").value = "DISABLED";
                                    })
                                </script>';

                                $i = 0;
                                if (isset($_GET['STARTUP_DATE']) || isset($_GET['STARTUP_SHIFT'])) {
                                    if ($SHIFT == 'DAY') {
                                        $SHIFT = 'NIGHT';
                                        $SHIFT_DATE = date('Y-m-d', strtotime('-1 day', strtotime($DATE)));
                                    } else {
                                        $SHIFT = 'DAY';
                                        $SHIFT_DATE = $DATE;
                                    }
                                } else {
                                    // check time
                                    if (DateDiff($DATE, date("Y-m-d")) > 3) {
                                        $tbl_item = 'startup_item_trace';
                                        $tbl_time = 'startup_time_trace';
                                    } else {
                                        $tbl_item = 'startup_item';
                                        $tbl_time = 'startup_time';
                                    }

                                    // echo $DATE;
                                    foreach ($LINE as $LINE_NAME) {
                                        $strSQL = "SELECT `SHIFT_DATE` FROM `$tbl_time` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` = '$LINE_NAME' AND `SHIFT_DATE` = '$DATE' AND `BIZ` = '$BIZ' ORDER BY `ID` DESC";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        if (!isset($objResult)) {
                                            $CHECK_SHIFT_DATE[] = '0';
                                        } else {
                                            $CHECK_SHIFT_DATE[] = '1';
                                        }
                                    }

                                    // // echo $strSQL;
                                    // print_r($objResult);

                                    if (in_array('1', $CHECK_SHIFT_DATE)) {
                                        $SHIFT = $SHIFT;
                                        $SHIFT_DATE = $DATE;
                                    } else {
                                        if ($SHIFT == 'DAY') {
                                            $SHIFT = 'NIGHT';
                                            $SHIFT_DATE = date('Y-m-d', strtotime('-1 day', strtotime($DATE)));
                                        } else {
                                            $SHIFT = 'DAY';
                                            $SHIFT_DATE = $DATE;
                                        }
                                    }
                                }
                                $SHIFT = 'DAY';
                                // echo $SHIFT_DATE . '<br>';
                                // echo $SHIFT . '<br>';
                                // time();
                                // echo strtotime($SHIFT_DATE);

                                // if($PERIOD_GET == 'DAY'){
                                //     $SHIFT = '';
                                // }

                                // check time
                                if (DateDiff($SHIFT_DATE, date("Y-m-d")) > 3) {
                                    $tbl_item = 'startup_item_trace';
                                    $tbl_time = 'startup_time_trace';
                                } else {
                                    $tbl_item = 'startup_item';
                                    $tbl_time = 'startup_time';
                                }
                                foreach ($LINE as $LINE_NAME) {

                                    require_once("connect.php");
                                    // $sql = "SELECT * FROM `$tbl_item`
                                    // WHERE `PERIOD` = '$PERIOD_GET' 
                                    // AND `LINE` LIKE '%$LINE_NAME%' 
                                    // AND `SHIFT_DATE` LIKE '$SHIFT_DATE%'
                                    // AND MODEL != 'NO PRODUCTION'";
                                    // $query = mysqli_query($con, $sql);
                                    // $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                    // if(isset($row)){

                                    // }

                                    $strSQL = "SELECT `CONFIRM1`,`CONFIRM2`,`CONFIRM3` 
                                    FROM `$tbl_time` 
                                    WHERE `PERIOD` = '$PERIOD_GET' 
                                    AND `LINE` = '$LINE_NAME' 
                                    AND `SHIFT_DATE` LIKE '$SHIFT_DATE%' 
                                    AND `STATUS` != 'NO PRODUCTION' 
                                    ORDER BY ID DESC ";
                                    $objQuery = mysqli_query($con, $strSQL);
                                    $CONFIRM1 = array();
                                    $CONFIRM2 = array();
                                    $CONFIRM3 = array();
                                    while ($objResult = mysqli_fetch_array($objQuery)) {
                                        array_push($CONFIRM1, $objResult['CONFIRM1']);
                                        array_push($CONFIRM2, $objResult['CONFIRM2']);
                                        array_push($CONFIRM3, $objResult['CONFIRM3']);
                                    }

                                    // 2022-01-17 เปลี่ยนตามวันที่เริ่มใช้งานระบบ SHIFT,DAILY
                                    if (strtotime($SHIFT_DATE) <= strtotime('2022-01-23')) {
                                        $PERIOD = $PERIOD_GET;
                                    } else {
                                        $strSQL = "SELECT `PERIOD` FROM `item` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$LINE_NAME%' ORDER BY `item`.`ID` ASC";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $PERIOD = $objResult['PERIOD'];
                                        // echo $strSQL;echo '<br>';
                                    }
                                    // echo $strSQL;echo '<br>';
                                    if (empty($PERIOD)) {
                                        $MODE = "EMPTY";
                                    } else if (isset($PERIOD)) {
                                        $MODE = "SHOW";
                                    }

                                    ///////// DATETIME DIFF //////////
                                    $strSQL2 = "SELECT `ID`,`SHIFT`,`DATETIME3`,`SHIFT_DATE`,`STARTTIME` 
                                    FROM `$tbl_time` 
                                    WHERE `PERIOD` = '$PERIOD_GET' 
                                    AND `BIZ` LIKE '%$BIZ%' 
                                    AND `LINE` = '$LINE_NAME' 
                                    AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                    ORDER BY STARTTIME DESC LIMIT 1";
                                    $objQuery2 = mysqli_query($con, $strSQL2);
                                    $objResult2 = mysqli_fetch_array($objQuery2);
                                    $TIME_ID = $objResult2['ID'];
                                    $SHIFT_DB = $objResult2['SHIFT'];
                                    $LastUpdate = $objResult2['DATETIME3'];
                                    $DATE2 = $objResult2['SHIFT_DATE'];
                                    // $strSQL2 . '<br>';
                                    // $CONFIRM2
                                    // $LastUpdate = "2020-09-08 22:00:00";
                                    // echo "<br>";

                                    $STARTUPTIME = $objResult2['STARTTIME'];

                                    // check center 
                                    $sql_line = "SELECT * FROM `startup_line` WHERE `LINE` = '$LINE_NAME'";
                                    $query_line = mysqli_query($con, $sql_line);
                                    $row_line = mysqli_fetch_array($query_line);

                                    if ($row_line["TYPE"] == 'PRODUCTION') {
                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,VALUE1,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'PASS') AS PASS,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'FAIL') AS FAIL,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'BLANK') AS BLANK,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE '') AS 'NULL',
                                            COUNT(`ID`) AS TOTAL
                                            FROM `$tbl_item`
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                            AND LINE = '$LINE_NAME' 
                                            AND SHIFT_DATE LIKE '$SHIFT_DATE%'
                                            GROUP BY `LINE`
                                            -- GROUP BY '$LINE_NAME'
                                            ORDER BY `SHIFT_DATE` DESC";
                                    } else {
                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,VALUE1,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'PASS') AS PASS,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'FAIL') AS FAIL,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'BLANK') AS BLANK,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE '') AS 'NULL',
                                            COUNT(`ID`) AS TOTAL
                                            FROM `$tbl_item`
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                            AND `LINE` = '$LINE_NAME' 
                                            AND SHIFT_DATE LIKE '$SHIFT_DATE%'
                                            AND `VALUE1` != 'NO PRODUCTION'
                                            GROUP BY `LINE`
                                            -- GROUP BY '$LINE_NAME'
                                            ORDER BY `SHIFT_DATE` DESC";
                                    }

                                    if ($LINE_NAME == "HEI") {
                                        // echo $strSQL;echo '<br';
                                    }
                                    // echo $strSQL;echo '<br';

                                    $objQuery = mysqli_query($con, $strSQL);
                                    $objResult = mysqli_fetch_array($objQuery);

                                    // $STARTUPTIME = "2020-09-08 04:00:00";
                                    // echo "<br>";
                                    $now = date('Y-m-d H:i:s');
                                    $check_date = date('Y-m-d');
                                    // echo "<br>";

                                    $hour1 = 0;
                                    $hour2 = 0;
                                    $datetimeObj2 = new DateTime($now);


                                    $timestamp_from = strtotime($LastUpdate);
                                    $timestamp_from2 = strtotime($STARTUPTIME);
                                    $timestamp_to = (int) $datetimeObj2->format('U');

                                    $interval = (int) round(($timestamp_to - $timestamp_from) / (60 * 60 * 24));
                                    $interval_h = (int) round(($timestamp_to - $timestamp_from) / (60 * 60));

                                    if ($interval > 0) {
                                        $hour1 = $interval * 24;
                                    }
                                    if ($interval_h > 0) {
                                        $hour2 = $interval_h;
                                    }

                                    $DIFF = $hour1 + $hour2;

                                    $hour1 = 0;
                                    $hour2 = 0;
                                    $interval = (int) round(($timestamp_to - $timestamp_from2) / (60 * 60 * 24));
                                    $interval_h = (int) round(($timestamp_to - $timestamp_from2) / (60 * 60));
                                    if ($interval > 0) {
                                        $hour1 = $interval;
                                    }
                                    if ($interval_h > 0) {
                                        $hour2 = $interval_h;
                                    }
                                    $DIFFSTARTTIME = $hour1 + $hour2;

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

                                    /////////////temp for BODY please downgrade function above/////////
                                    // $RANGE = 24;
                                    if ($MODE == "SHOW") {
                                        if ($objResult['VALUE1'] == 'NO PRODUCTION') {
                                            // echo $row_line["TYPE"];
                                            // echo $LINE_NAME;
                                            $HIDDEN = 'hidden';
                                            $SPAN = 'colspan="2"';
                                            $PASS = '<p class="blockquote text-muted animated fadeInDown">' . $objResult['VALUE1'] . '</p>';
                                            $TOTAL = 'PRODUCTION';
                                            $STATUS = '<img src="framework/img/Wlight.png" width="50">';
                                            $TEXT = '<p>&nbsp; &nbsp;</p>';
                                            $SECON = 'table-active';
                                        } else {
                                            // echo $LINE_NAME;
                                            // if ($LINE_NAME == 'HQA') {
                                            //     echo $LINE_NAME;
                                            // } else {
                                            //     // echo $objResult['VALUE1'];
                                            // }
                                            $SECON = '';
                                            $SPAN = '';
                                            $HIDDEN = '';
                                            $PASS = $objResult['PASS'];
                                            $TOTAL = $objResult['TOTAL'];

                                            if (($LastUpdate == '0000-00-00 00:00:00') && ($DIFFSTARTTIME < $RANGE)) {
                                                // echo $LINE_NAME;
                                                // $PASS = $objResult['PASS'];
                                                // $TOTAL = $objResult['TOTAL'];
                                                // if ($SHIFT != $SHIFT_DB || $TOTAL == null) {
                                                //     $PASS = '-';
                                                //     $TOTAL = '-';
                                                //     $TEXT = 'NO DATA2';
                                                //     $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                // } else {
                                                if ($PASS == $TOTAL && $PASS != '0') {
                                                    if (in_array('', $CONFIRM2)) {
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'SUP.MFE';
                                                    } else if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'PROD';
                                                    } else {
                                                        $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                        $TEXT = 'GOOD';
                                                    }
                                                } else if ($PASS < $TOTAL) {
                                                    $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                    $TEXT = 'TECH';
                                                }
                                                // }
                                            } else {
                                                // echo $LINE_NAME;
                                                if ($DIFF > $RANGE) {
                                                    // if ($LINE_NAME == 'HQA') {
                                                    //     echo $LINE_NAME;
                                                    // }
                                                    // echo $LINE_NAME;
                                                    if ($objResult['PASS'] == $objResult['TOTAL'] && $objResult['PASS'] != 0) {
                                                        $PASS = $objResult['PASS'];
                                                        $TOTAL = $objResult['TOTAL'];
                                                        // print_r($CONFIRM2);
                                                        if (in_array('', $CONFIRM2)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'SUP.MFE';
                                                        } else if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'PROD';
                                                        } else {
                                                            $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                            $TEXT = 'GOOD';
                                                        }
                                                    } else if ($objResult['PASS'] < $objResult['TOTAL'] && $objResult['TOTAL'] != null && $objResult['TOTAL'] != "") {
                                                        $PASS = $objResult['PASS'];
                                                        $TOTAL = $objResult['TOTAL'];
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'TECH';
                                                    } else {
                                                        $PASS = '-';
                                                        $TOTAL = '-';
                                                        $TEXT = 'NO DATA3';
                                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    }
                                                } else {
                                                    // if ($LINE_NAME == 'HQA') {
                                                    //     echo $LINE_NAME;
                                                    // }
                                                    // echo $LINE_NAME;

                                                    // if ($SHIFT != $SHIFT_DB) {
                                                    //     $PASS = '-';
                                                    //     $TOTAL = '-';
                                                    //     $TEXT = 'NO DATA5';
                                                    //     $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    // } else {
                                                    if ($PASS == $TOTAL && $PASS != '0') {
                                                        // if ($LINE_NAME == 'HQA') {
                                                        //     echo $CONFIRM2;
                                                        // }
                                                        if (in_array('', $CONFIRM2)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'SUP.MFE';
                                                        } else if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'PROD';
                                                        } else {
                                                            $PASS = $objResult['PASS'];
                                                            $TOTAL = $objResult['TOTAL'];
                                                            $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                            $TEXT = 'GOOD';
                                                        }
                                                    } else if ($objResult['PASS'] < $objResult['TOTAL'] && $objResult['TOTAL'] != null && $objResult['TOTAL'] != "") {
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'TECH2';
                                                    } else {
                                                        $PASS = '-';
                                                        $TOTAL = '-';
                                                        $TEXT = 'NO DATA4';
                                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    }
                                                    // }
                                                }
                                            }
                                        }
                                    } else if ($MODE == "EMPTY") {
                                        // echo $LINE_NAME;
                                        $SECON = '';
                                        $HIDDEN = '';
                                        $SPAN = '';

                                        $PASS = '-';
                                        $TOTAL = '-';
                                        $TEXT = 'NO DATA';
                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                    }

                                    if ($i % 2 == 0) {
                                        // EVEN NUMBER
                                        echo "<tr>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_line.php?LINE=" . $LINE_NAME . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&BIZ=" . $BIZ . "&PERIOD=" . $PERIOD_GET . "'>" . $LINE_NAME . "</a></b></h4></a></td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                        echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                    } else {
                                        // ODD NUMBER
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_line.php?LINE=" . $LINE_NAME .  "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&BIZ=" . $BIZ . "&PERIOD=" . $PERIOD_GET . "'>" . $LINE_NAME . "</a></b></h4></a></td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                        echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                        echo "</tr>";
                                    }
                                    $i++;
                                }
                            } else if ($PERIOD_GET == 'WEEK') {

                                ######### WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK #########
                                function getStartAndEndDate($week, $year)
                                {
                                    $week_start = new DateTime();
                                    $week_start->setISODate($year, $week);
                                    $return[0] = $week_start->format('Y-m-d');
                                    $time = strtotime($return[0], time());
                                    $time += 6 * 24 * 3600;
                                    $return[1] = date('Y-m-d', $time);
                                    return $return;
                                }

                                $date_arr = explode("-", $DATE);
                                $start_date = getStartAndEndDate(str_replace('W', '', $date_arr[1]), $date_arr[0])[0];
                                $end_date = getStartAndEndDate(str_replace('W', '', $date_arr[1]), $date_arr[0])[1];

                                // if (str_replace("W", "", $date_arr[1]) == date('W')) {
                                $tbl_item = 'startup_item';
                                $tbl_time = 'startup_time';
                                // } else {
                                //     $tbl_item = 'startup_item_trace';
                                //     $tbl_time = 'startup_time_trace';
                                // }

                                // check time
                                // if (DateDiff($DATE, date("Y-m-d")) > 3) {
                                //     $tbl_item = 'startup_item_trace';
                                //     $tbl_time = 'startup_time_trace';
                                // } else {
                                //     $tbl_item = 'startup_item';
                                //     $tbl_time = 'startup_time';
                                // }

                                // if (str_replace("W", "", $date_arr[1]) == date('W')) {
                                //     $tbl_item = 'startup_item';
                                //     $tbl_time = 'startup_time';
                                // } else {
                                //     $tbl_item = 'startup_item_trace';
                                //     $tbl_time = 'startup_time_trace';
                                // }
                                $i = 0;
                                foreach ($LINE as $LINE_NAME) {

                                    require_once("connect.php");

                                    $strSQL = "SELECT `SHIFT_DATE`,`SHIFT` FROM `$tbl_time` WHERE `ID` = (SELECT MAX(`ID`) FROM `$tbl_time` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` = '$LINE_NAME' AND `BIZ` = '$BIZ' AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') ";
                                    $objQuery = mysqli_query($con, $strSQL);
                                    $objResult = mysqli_fetch_array($objQuery);
                                    $SHIFT = $objResult["SHIFT"];
                                    $SHIFT_DATE = $objResult["SHIFT_DATE"];

                                    // $sql = "SELECT * FROM `$tbl_item` 
                                    // WHERE `PERIOD` = '$PERIOD_GET' 
                                    // AND `LINE` LIKE '%$LINE_NAME%' 
                                    // AND `SHIFT_DATE` LIKE '$SHIFT_DATE%'
                                    // AND MODEL != 'NO PRODUCTION'";
                                    // $query = mysqli_query($con, $sql);
                                    // $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                    // if(isset($row)){

                                    // }

                                    $strSQL = "SELECT `CONFIRM1`,`CONFIRM2`,`CONFIRM3` 
                                    FROM `$tbl_time` 
                                    WHERE `PERIOD` = '$PERIOD_GET' 
                                    AND `LINE` = '$LINE_NAME' 
                                    AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'
                                    AND `STATUS` != 'NO PRODUCTION' 
                                    ORDER BY ID DESC ";
                                    $objQuery = mysqli_query($con, $strSQL);
                                    // $objResult = mysqli_fetch_array($objQuery);
                                    $CONFIRM1 = array();
                                    $CONFIRM2 = array();
                                    $CONFIRM3 = array();
                                    while($objResult = mysqli_fetch_array($objQuery)){
                                        array_push($CONFIRM1, $objResult["CONFIRM1"]);
                                        array_push($CONFIRM2, $objResult["CONFIRM2"]);
                                        array_push($CONFIRM2, $objResult["CONFIRM3"]);
                                    }

                                    // 2022-01-17 เปลี่ยนตามวันที่เริ่มใช้งานระบบ SHIFT,DAILY
                                    if (strtotime($SHIFT_DATE) <= strtotime('2022-01-23')) {
                                        $PERIOD = $PERIOD_GET;
                                    } else {
                                        $strSQL = "SELECT `PERIOD` FROM `item` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$LINE_NAME%' ORDER BY `item`.`ID` ASC";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $PERIOD = $objResult['PERIOD'];
                                        // echo $strSQL;echo '<br>';
                                    }
                                    // echo $strSQL;echo '<br>';
                                    if (empty($PERIOD)) {
                                        $MODE = "EMPTY";
                                    } else if (isset($PERIOD)) {
                                        $MODE = "SHOW";
                                    }

                                    ///////// DATETIME DIFF //////////
                                    $strSQL2 = "SELECT `ID`,`SHIFT`,`DATETIME3`,`SHIFT_DATE`,`STARTTIME` 
                                    FROM `$tbl_time` 
                                    WHERE `PERIOD` = '$PERIOD_GET' 
                                    AND `BIZ` LIKE '%$BIZ%' 
                                    AND `LINE` = '$LINE_NAME'
                                    AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'
                                    ORDER BY STARTTIME DESC LIMIT 1";
                                    $objQuery2 = mysqli_query($con, $strSQL2);
                                    $objResult2 = mysqli_fetch_array($objQuery2);
                                    $TIME_ID = $objResult2['ID'];
                                    $SHIFT_DB = $objResult2['SHIFT'];
                                    $LastUpdate = $objResult2['DATETIME3'];
                                    $DATE2 = $objResult2['SHIFT_DATE'];
                                    // $strSQL2 . '<br>';
                                    // $CONFIRM2
                                    // $LastUpdate = "2020-09-08 22:00:00";
                                    // echo "<br>";
                                    // if ($LINE_NAME == "HEB") {
                                    //     echo $strSQL2 . '<br>';
                                    // }

                                    $STARTUPTIME = $objResult2['STARTTIME'];

                                    // check center 
                                    $sql_line = "SELECT * FROM `startup_line` WHERE `LINE` = '$LINE_NAME'";
                                    $query_line = mysqli_query($con, $sql_line);
                                    $row_line = mysqli_fetch_array($query_line);

                                    if ($row_line["TYPE"] == 'PRODUCTION') {
                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,VALUE1,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND JUDGEMENT LIKE 'PASS'
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS PASS,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND JUDGEMENT LIKE 'FAIL'
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS FAIL,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND JUDGEMENT LIKE 'BLANK'
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS BLANK,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND JUDGEMENT LIKE ''
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS 'NULL',
                                            COUNT(`ID`) AS TOTAL
                                            FROM `$tbl_item`
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                            AND LINE = '$LINE_NAME'
                                            AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'
                                            GROUP BY `LINE`
                                            ORDER BY `SHIFT_DATE` DESC";
                                    } else {
                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,VALUE1,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'PASS'
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS PASS,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'FAIL'
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS FAIL,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'BLANK'
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS BLANK,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME'
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE ''
                                                AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date') AS 'NULL',
                                            COUNT(`ID`) AS TOTAL
                                            FROM `$tbl_item`
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                            AND `LINE` = '$LINE_NAME' 
                                            AND `VALUE1` != 'NO PRODUCTION'
                                            AND `SHIFT_DATE` BETWEEN '$start_date' AND '$end_date'
                                            GROUP BY `LINE`
                                            -- GROUP BY '$LINE_NAME'
                                            ORDER BY `SHIFT_DATE` DESC";
                                    }

                                    // if ($LINE_NAME == 'FEY') {
                                    //     echo $strSQL;
                                    //     echo '<br';
                                    // }
                                    // echo $strSQL;echo '<br';

                                    $objQuery = mysqli_query($con, $strSQL);
                                    $objResult = mysqli_fetch_array($objQuery);

                                    // $STARTUPTIME = "2020-09-08 04:00:00";
                                    // echo "<br>";
                                    $now = date('Y-m-d H:i:s');
                                    $check_date = date('Y-m-d');
                                    // echo "<br>";

                                    $hour1 = 0;
                                    $hour2 = 0;
                                    $datetimeObj2 = new DateTime($now);


                                    $timestamp_from = strtotime($LastUpdate);
                                    $timestamp_from2 = strtotime($STARTUPTIME);
                                    $timestamp_to = (int) $datetimeObj2->format('U');

                                    $interval = (int) round(($timestamp_to - $timestamp_from) / (60 * 60 * 24));
                                    $interval_h = (int) round(($timestamp_to - $timestamp_from) / (60 * 60));

                                    if ($interval > 0) {
                                        $hour1 = $interval * 24;
                                    }
                                    if ($interval_h > 0) {
                                        $hour2 = $interval_h;
                                    }

                                    $DIFF = $hour1 + $hour2;

                                    $hour1 = 0;
                                    $hour2 = 0;
                                    $interval = (int) round(($timestamp_to - $timestamp_from2) / (60 * 60 * 24));
                                    $interval_h = (int) round(($timestamp_to - $timestamp_from2) / (60 * 60));
                                    if ($interval > 0) {
                                        $hour1 = $interval;
                                    }
                                    if ($interval_h > 0) {
                                        $hour2 = $interval_h;
                                    }
                                    $DIFFSTARTTIME = $hour1 + $hour2;

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

                                    /////////////temp for BODY please downgrade function above/////////
                                    // $RANGE = 24;
                                    if ($MODE == "SHOW") {
                                        if ($objResult['VALUE1'] == 'NO PRODUCTION') {
                                            $HIDDEN = 'hidden';
                                            $SPAN = 'colspan="2"';
                                            $PASS = '<p class="blockquote text-muted animated fadeInDown">' . $objResult['VALUE1'] . '</p>';
                                            $TOTAL = 'PRODUCTION';
                                            $STATUS = '<img src="framework/img/Wlight.png" width="50">';
                                            $TEXT = '<p>&nbsp; &nbsp;</p>';
                                            $SECON = 'table-active';
                                        } else {
                                            $SECON = '';
                                            $SPAN = '';
                                            $HIDDEN = '';
                                            $PASS = $objResult['PASS'];
                                            $TOTAL = $objResult['TOTAL'];

                                            if (($LastUpdate == '0000-00-00 00:00:00') && ($DIFFSTARTTIME < $RANGE)) {
                                                if ($PASS == $TOTAL && $PASS != '0') {
                                                    if (in_array('', $CONFIRM2)) {
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'SUP.MFE';
                                                    } else if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'PROD';
                                                    } else {
                                                        $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                        $TEXT = 'GOOD';
                                                    }
                                                } else if ($PASS < $TOTAL) {
                                                    $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                    $TEXT = 'TECH';
                                                }
                                            } else {
                                                if ($DIFF > $RANGE) {
                                                    if ($objResult['PASS'] == $objResult['TOTAL'] && $objResult['PASS'] != 0) {
                                                        $PASS = $objResult['PASS'];
                                                        $TOTAL = $objResult['TOTAL'];
                                                        if (in_array('', $CONFIRM2)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'SUP.MFE';
                                                        } else if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'PROD';
                                                        } else {
                                                            $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                            $TEXT = 'GOOD';
                                                        }
                                                    } else if ($objResult['PASS'] < $objResult['TOTAL'] && $objResult['TOTAL'] != null && $objResult['TOTAL'] != "") {
                                                        $PASS = $objResult['PASS'];
                                                        $TOTAL = $objResult['TOTAL'];
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'TECH';
                                                    } else {
                                                        $PASS = '-';
                                                        $TOTAL = '-';
                                                        $TEXT = 'NO DATA3';
                                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    }
                                                } else {
                                                    $PASS = $objResult['PASS'];
                                                    $TOTAL = $objResult['TOTAL'];
                                                    $TEXT = 'NO DATA4';
                                                    $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    if ($PASS == $TOTAL && $PASS != '0') {
                                                        if (in_array('', $CONFIRM2)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'SUP.MFE';
                                                        }
                                                        if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'PROD';
                                                        } else {
                                                            $PASS = $objResult['PASS'];
                                                            $TOTAL = $objResult['TOTAL'];
                                                            $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                            $TEXT = 'GOOD';
                                                        }
                                                    }
                                                    if ($objResult['PASS'] < $objResult['TOTAL'] && $objResult['TOTAL'] != null && $objResult['TOTAL'] != "") {
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'TECH2';
                                                    }
                                                }
                                            }
                                        }
                                    } else if ($MODE == "EMPTY") {
                                        // echo $LINE_NAME;
                                        $SECON = '';
                                        $HIDDEN = '';
                                        $SPAN = '';

                                        $PASS = '-';
                                        $TOTAL = '-';
                                        $TEXT = 'NO DATA';
                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                    }

                                    if ($i % 2 == 0) {
                                        // EVEN NUMBER
                                        echo "<tr>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_line.php?LINE=" . $LINE_NAME . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&BIZ=" . $BIZ . "&PERIOD=" . $PERIOD_GET . "&STRAT_DATE=" . $start_date . "&END_DATE=" . $end_date . "'>" . $LINE_NAME . "</a></b></h4></a></td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                        echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                    } else {
                                        // ODD NUMBER
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_line.php?LINE=" . $LINE_NAME .  "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&BIZ=" . $BIZ . "&PERIOD=" . $PERIOD_GET . "&STRAT_DATE=" . $start_date . "&END_DATE=" . $end_date . "'>" . $LINE_NAME . "</a></b></h4></a></td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                        echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                        echo "</tr>";
                                    }
                                    $i++;
                                }

                                ######### WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK ################## WEEK #########
                            } else {
                                $i = 0;
                                if (isset($_GET['STARTUP_DATE']) || isset($_GET['STARTUP_SHIFT'])) {
                                    if ($SHIFT == 'DAY') {
                                        $SHIFT = 'NIGHT';
                                        $SHIFT_DATE = date('Y-m-d', strtotime('-1 day', strtotime($DATE)));
                                    } else {
                                        $SHIFT = 'DAY';
                                        $SHIFT_DATE = $DATE;
                                    }
                                } else {

                                    // check time
                                    if (DateDiff($DATE, date("Y-m-d")) > 3) {
                                        $tbl_item = 'startup_item_trace';
                                        $tbl_time = 'startup_time_trace';
                                    } else {
                                        $tbl_item = 'startup_item';
                                        $tbl_time = 'startup_time';
                                    }

                                    foreach ($LINE as $LINE_NAME) {
                                        $strSQL = "SELECT `SHIFT`, `SHIFT_DATE` FROM `$tbl_time` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` = '$LINE_NAME' AND `SHIFT` = '$SHIFT' AND `SHIFT_DATE` = '$DATE' AND `BIZ` = '$BIZ' ORDER BY `ID` DESC";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        if (!isset($objResult)) {
                                            $CHECK_SHIFT_DATE[] = '0';
                                        } else {
                                            $CHECK_SHIFT_DATE[] = '1';
                                        }
                                    }

                                    // // echo $strSQL;
                                    // print_r($objResult);

                                    if (in_array('1', $CHECK_SHIFT_DATE)) {
                                        $SHIFT = $SHIFT;
                                        $SHIFT_DATE = $DATE;
                                    } else {
                                        if ($SHIFT == 'DAY') {
                                            $SHIFT = 'NIGHT';
                                            $SHIFT_DATE = date('Y-m-d', strtotime('-1 day', strtotime($DATE)));
                                        } else {
                                            $SHIFT = 'DAY';
                                            $SHIFT_DATE = $DATE;
                                        }
                                    }
                                }
                                // echo $SHIFT_DATE . '<br>';
                                // echo $SHIFT . '<br>';
                                // time();
                                // echo strtotime($SHIFT_DATE);

                                // if($PERIOD_GET == 'DAY'){
                                //     $SHIFT = '';
                                // }


                                // check time
                                if (DateDiff($SHIFT_DATE, date("Y-m-d")) > 3) {
                                    $tbl_item = 'startup_item_trace';
                                    $tbl_time = 'startup_time_trace';
                                } else {
                                    $tbl_item = 'startup_item';
                                    $tbl_time = 'startup_time';
                                }
                                foreach ($LINE as $LINE_NAME) {

                                    require_once("connect.php");
                                    $strSQL = "SELECT `CONFIRM1`,`CONFIRM2`,`CONFIRM3` FROM `$tbl_time` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` = '$LINE_NAME' AND SHIFT LIKE '%$SHIFT%' AND SHIFT_DATE LIKE '$SHIFT_DATE%' ORDER BY ID DESC ";
                                    $objQuery = mysqli_query($con, $strSQL);
                                    $objResult = mysqli_fetch_array($objQuery);
                                    // echo $strSQL . '<br>';

                                    $CONFIRM1 = $objResult['CONFIRM1'];
                                    $CONFIRM2 = $objResult['CONFIRM2'];
                                    $CONFIRM3 = $objResult['CONFIRM3'];

                                    // 2022-01-17 เปลี่ยนตามวันที่เริ่มใช้งานระบบ SHIFT,DAILY
                                    if (strtotime($SHIFT_DATE) <= strtotime('2022-01-23')) {
                                        $PERIOD = $PERIOD_GET;
                                    } else {
                                        $strSQL = "SELECT `PERIOD` FROM `item` WHERE `PERIOD` = '$PERIOD_GET' AND LINE LIKE '%$LINE_NAME%' ORDER BY `item`.`ID` ASC";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $PERIOD = $objResult['PERIOD'];
                                        // echo $strSQL;echo '<br';
                                    }
                                    if (empty($PERIOD)) {
                                        $MODE = "EMPTY";
                                    } else if (isset($PERIOD)) {
                                        $MODE = "SHOW";
                                    }

                                    ///////// DATETIME DIFF //////////
                                    $strSQL2 = "SELECT `ID`,`SHIFT`,`DATETIME3`,`SHIFT_DATE`,`STARTTIME` 
                                    FROM `$tbl_time` 
                                    WHERE `PERIOD` = '$PERIOD_GET' 
                                    AND `BIZ` LIKE '%$BIZ%' 
                                    AND `LINE` = '$LINE_NAME' 
                                    AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                    AND SHIFT LIKE '%$SHIFT%'
                                    ORDER BY STARTTIME DESC LIMIT 1";
                                    $objQuery2 = mysqli_query($con, $strSQL2);
                                    $objResult2 = mysqli_fetch_array($objQuery2);
                                    $TIME_ID = $objResult2['ID'];
                                    $SHIFT_DB = $objResult2['SHIFT'];
                                    $LastUpdate = $objResult2['DATETIME3'];
                                    $DATE2 = $objResult2['SHIFT_DATE'];
                                    // $strSQL2 . '<br>';
                                    // $CONFIRM2
                                    // $LastUpdate = "2020-09-08 22:00:00";
                                    // echo "<br>";

                                    $STARTUPTIME = $objResult2['STARTTIME'];

                                    // check center 
                                    $sql_line = "SELECT * FROM `startup_line` WHERE `LINE` = '$LINE_NAME'";
                                    $query_line = mysqli_query($con, $sql_line);
                                    $row_line = mysqli_fetch_array($query_line);

                                    if ($row_line["TYPE"] == 'PRODUCTION') {
                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,VALUE1,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'PASS') AS PASS,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'FAIL') AS FAIL,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'BLANK') AS BLANK,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE '') AS 'NULL',
                                            COUNT(`ID`) AS TOTAL
                                            FROM `$tbl_item`
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                            AND LINE = '$LINE_NAME' 
                                            AND SHIFT LIKE '%$SHIFT%' 
                                            AND SHIFT_DATE LIKE '$SHIFT_DATE%'
                                            GROUP BY `LINE`
                                            -- GROUP BY '$LINE_NAME'
                                            ORDER BY `SHIFT_DATE` DESC";
                                    } else {
                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,VALUE1,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'PASS') AS PASS,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'FAIL') AS FAIL,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE 'BLANK') AS BLANK,
                                            (SELECT COUNT(`ID`) 
                                                FROM `$tbl_item` 
                                                WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` = '$LINE_NAME' 
                                                AND SHIFT LIKE '%$SHIFT%' 
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND `VALUE1` != 'NO PRODUCTION' 
                                                AND JUDGEMENT LIKE '') AS 'NULL',
                                            COUNT(`ID`) AS TOTAL
                                            FROM `$tbl_item`
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                            AND `LINE` = '$LINE_NAME' 
                                            AND SHIFT LIKE '%$SHIFT%' 
                                            AND SHIFT_DATE LIKE '$SHIFT_DATE%'
                                            AND `VALUE1` != 'NO PRODUCTION'
                                            GROUP BY `LINE`
                                            -- GROUP BY '$LINE_NAME'
                                            ORDER BY `SHIFT_DATE` DESC";
                                    }

                                    // echo $strSQL;echo '<br';

                                    $objQuery = mysqli_query($con, $strSQL);
                                    $objResult = mysqli_fetch_array($objQuery);

                                    // $STARTUPTIME = "2020-09-08 04:00:00";
                                    // echo "<br>";
                                    $now = date('Y-m-d H:i:s');
                                    $check_date = date('Y-m-d');
                                    // echo "<br>";

                                    $hour1 = 0;
                                    $hour2 = 0;
                                    $datetimeObj2 = new DateTime($now);


                                    $timestamp_from = strtotime($LastUpdate);
                                    $timestamp_from2 = strtotime($STARTUPTIME);
                                    $timestamp_to = (int) $datetimeObj2->format('U');

                                    $interval = (int) round(($timestamp_to - $timestamp_from) / (60 * 60 * 24));
                                    $interval_h = (int) round(($timestamp_to - $timestamp_from) / (60 * 60));

                                    if ($interval > 0) {
                                        $hour1 = $interval * 24;
                                    }
                                    if ($interval_h > 0) {
                                        $hour2 = $interval_h;
                                    }

                                    $DIFF = $hour1 + $hour2;

                                    $hour1 = 0;
                                    $hour2 = 0;
                                    $interval = (int) round(($timestamp_to - $timestamp_from2) / (60 * 60 * 24));
                                    $interval_h = (int) round(($timestamp_to - $timestamp_from2) / (60 * 60));
                                    if ($interval > 0) {
                                        $hour1 = $interval;
                                    }
                                    if ($interval_h > 0) {
                                        $hour2 = $interval_h;
                                    }
                                    $DIFFSTARTTIME = $hour1 + $hour2;

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

                                    /////////////temp for BODY please downgrade function above/////////
                                    // $RANGE = 24;
                                    if ($MODE == "SHOW") {
                                        if ($objResult['VALUE1'] == 'NO PRODUCTION') {
                                            // echo $row_line["TYPE"];
                                            // echo $LINE_NAME;
                                            $HIDDEN = 'hidden';
                                            $SPAN = 'colspan="2"';
                                            $PASS = '<p class="blockquote text-muted animated fadeInDown">' . $objResult['VALUE1'] . '</p>';
                                            $TOTAL = 'PRODUCTION';
                                            $STATUS = '<img src="framework/img/Wlight.png" width="50">';
                                            $TEXT = '<p>&nbsp; &nbsp;</p>';
                                            $SECON = 'table-active';
                                        } else {
                                            // if ($LINE_NAME == 'SOLDERING') {
                                            //     echo $objResult['VALUE1'];
                                            // } else {
                                            //     echo $objResult['VALUE1'];
                                            // }
                                            $SECON = '';
                                            $SPAN = '';
                                            $HIDDEN = '';
                                            $PASS = $objResult['PASS'];
                                            $TOTAL = $objResult['TOTAL'];

                                            if (($LastUpdate == '0000-00-00 00:00:00') && ($DIFFSTARTTIME < $RANGE)) {
                                                // echo $LINE_NAME;
                                                if ($SHIFT != $SHIFT_DB || $TOTAL == null) {
                                                    $PASS = '-';
                                                    $TOTAL = '-';
                                                    $TEXT = 'NO DATA2';
                                                    $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                } else {
                                                    if ($PASS == $TOTAL && $PASS != '0') {
                                                        if (in_array('', $CONFIRM2)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'SUP.MFE';
                                                        } else if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'PROD';
                                                        } else {
                                                            $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                            $TEXT = 'GOOD';
                                                        }
                                                    } else if ($PASS < $TOTAL) {
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'TECH';
                                                    }
                                                }
                                            } else {
                                                // echo $LINE_NAME;
                                                if ($DIFF > $RANGE) {
                                                    // echo $LINE_NAME;
                                                    $PASS = '-';
                                                    $TOTAL = '-';
                                                    $TEXT = 'NO DATA3';
                                                    $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';

                                                    if ($objResult['PASS'] == $objResult['TOTAL'] && $objResult['PASS'] != 0) {
                                                        $PASS = $objResult['PASS'];
                                                        $TOTAL = $objResult['TOTAL'];
                                                        if (in_array('', $CONFIRM2)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'SUP.MFE';
                                                        } else if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'PROD';
                                                        } else {
                                                            $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                            $TEXT = 'GOOD';
                                                        }
                                                    } else if ($PASS < $TOTAL) {
                                                        $PASS = $objResult['PASS'];
                                                        $TOTAL = $objResult['TOTAL'];
                                                        $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                        $TEXT = 'TECH';
                                                    }
                                                } else {
                                                    $PASS = '-';
                                                    $TOTAL = '-';
                                                    $TEXT = 'NO DATA4';
                                                    $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    if ($SHIFT != $SHIFT_DB) {
                                                        $PASS = '-';
                                                        $TOTAL = '-';
                                                        $TEXT = 'NO DATA5';
                                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    } else {
                                                        if ($PASS == $TOTAL && $PASS != '0') {
                                                            if (in_array('', $CONFIRM2)) {
                                                                $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                                $TEXT = 'SUP.MFE';
                                                            }
                                                            if (!in_array('', $CONFIRM2) && in_array('', $CONFIRM3)) {
                                                                $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                                $TEXT = 'PROD';
                                                            } else {
                                                                $PASS = $objResult['PASS'];
                                                                $TOTAL = $objResult['TOTAL'];
                                                                $STATUS = '<img src="framework/img/Glight.png"  width="50">';
                                                                $TEXT = 'GOOD';
                                                            }
                                                        }
                                                        if ($PASS < $TOTAL) {
                                                            $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                            $TEXT = 'TECH2';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else if ($MODE == "EMPTY") {
                                        // echo $LINE_NAME;
                                        $SECON = '';
                                        $HIDDEN = '';
                                        $SPAN = '';

                                        $PASS = '-';
                                        $TOTAL = '-';
                                        $TEXT = 'NO DATA';
                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                    }

                                    if ($i % 2 == 0) {
                                        // EVEN NUMBER
                                        echo "<tr>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_line.php?LINE=" . $LINE_NAME . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&BIZ=" . $BIZ . "&PERIOD=" . $PERIOD_GET . "'>" . $LINE_NAME . "</a></b></h4></a></td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                        echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                    } else {
                                        // ODD NUMBER
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_line.php?LINE=" . $LINE_NAME .  "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&BIZ=" . $BIZ . "&PERIOD=" . $PERIOD_GET . "'>" . $LINE_NAME . "</a></b></h4></a></td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                        echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                        echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                        echo "</tr>";
                                    }
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </div>
                </table>
                <h5><img src="framework/img/GLight.png" width="50"> STARTUP OK <img src="framework/img/YLight.png" width="50"> ON PROGRESS <img src="framework/img/RLight.png" width="50"> OVERDUE <img src="framework/img/WLight.png" width="50"> NO PRODUCTION </h5>
            </div>
            <section>
                <div class="container">
                    <div class="col-lg-12 mx-auto text-center">
                        <!-- <a href="index.php" class="btn btn-success"><i class='fas fa-home' style='color:white'></i> BACK</a> -->
                    </div>
                </div>
            </section>
        </div>


</body>

</html>

<script type="text/javascript">
    // $(document).ready(function() {
    //     $(".se-pre-con").fadeOut(2000);
    // });
</script>
<script>
    // alert("OK");
    $(document).ready(function() {
        var shift = '<?php echo $SHIFT ?>';
        <?php if ($PERIOD_GET == 'DAY') { ?>

        <?php } else if ($PERIOD_GET == 'WEEK') { ?>
            console.log("WEEK")
            $("#STARTUP_SHIFT_DIV").hide()
        <?php } else { ?>
            if (shift == 'DAY') {
                $("#STARTUP_SHIFT").val("NIGHT");
            } else {
                $("#STARTUP_SHIFT").val("DAY");
            }
        <?php } ?>
    })
</script>