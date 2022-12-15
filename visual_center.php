<?php

if (isset($_GET['CENTER'])) {
    $CENTER = $_GET['CENTER'];
    $BIZ = $_GET["BIZ"];
} else {
    header("Location: http://43.72.52.51/startup2.0/visual.php?BIZ=IM");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STARTUP CHECK CENTER</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">

    <script src="framework/js/a076d05399.js"></script>
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


    // if ($BIZ == 'IM' || $BIZ == 'IM') {
    // if ($BIZ == 'IM') {
    //     $BIZ = "IM";
    // }

    $strSQL = "SELECT MODEL FROM `model_center` WHERE CENTER LIKE '%$CENTER%' ORDER BY MODEL ASC ";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $MODEL[] = $objResult['MODEL'];
    }
    $BIZ = 'IM';
    // }
    sort($MODEL);

    if (isset($_GET["PERIOD"])) {
        $PERIOD_GET = $_GET["PERIOD"];
    } else {
        $PERIOD_GET = 'SHIFT';
    }

    if ($PERIOD_GET == 'SHIFT') {
        $PERIOD_GET_SHIFT = 'checked';
        $PERIOD_GET_DAILY = '';

        $PERIOD_GET_SHIFT_CLASS = 'active';
        $PERIOD_GET_DAILY_CLASS = '';
    } else {
        $PERIOD_GET_SHIFT = '';
        $PERIOD_GET_DAILY = 'checked';

        $PERIOD_GET_SHIFT_CLASS = '';
        $PERIOD_GET_DAILY_CLASS = 'active';
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
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
                    <a class="nav-link" href="http://43.72.52.51/startup2.0/login.php?BIZ=<?php echo $BIZ; ?>&CENTER=CENTER">LOGIN</a>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0 ">
                <a style="color: white;" href="http://43.72.52.51/startup2.0/visual.php?BIZ=<?php echo $BIZ ?>">BACK</a>
            </div>
        </div>
    </nav><br><br><br>


    <div class="row text-center">
        <div class="col-lg-12 mx-auto">
            <img src="" width="15%">
            <h1><b class="animated fadeInDown"><a style="color:black;" href="http://43.72.52.51/startup2.0/">SMART STARTUP CHECK</a></b></h1>
            <p class="lead">startup result update</p>

            <form action="visual_center.php" medthod="GET" class="text-center" id="form_search">
                <input type="hidden" name="BIZ" value="<?php echo $BIZ; ?>">
                <input type="hidden" name="CENTER" value="<?php echo $CENTER; ?>">
                <div class="container text-center">
                    <div class="row text-center justify-content-center form-group">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary <?php echo $PERIOD_GET_SHIFT_CLASS ?>">
                                <input type="radio" class="PERIOD" name="PERIOD" id="option1" value="SHIFT" autocomplete="off" <?php echo $PERIOD_GET_SHIFT ?>> SHIFT
                            </label>
                            <label class="btn btn-secondary <?php echo $PERIOD_GET_DAILY_CLASS ?>">
                                <input type="radio" class="PERIOD" name="PERIOD" id="option2" value="DAY" autocomplete="off" <?php echo $PERIOD_GET_DAILY ?>> DAILY
                            </label>
                        </div>
                    </div>
                    <div class="row text-center justify-content-center form-group">
                        <div class="col-auto text-center">
                            <input class="form-control text-center" type="date" name="STARTUP_DATE" max="<?php echo date('Y-m-d') ?> " value="<?php echo $DATE; ?>">
                        </div>
                        <div class="col-auto text-center">
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
                        <div class="col-auto text-center">
                            <button class="form-control btn btn-primary" type="submit">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
            <br><br>

            <script>
                $(document).ready(function() {
                    $('.PERIOD').click(function() {
                        $("#form_search").submit();
                    })
                })
            </script>

            <div class="container">

                <table class="table thead-light table-hover">
                    <div style="overflow-x:auto;">
                        <thead class="thead-dark text-black">
                            <tr>
                                <th width="20%" align="center">MODEL</th>
                                <th width="10%" align="center">PASS</th>
                                <th width="10%" align="center">TOTAL</th>
                                <th width="10%" align="center">STATUS</th>
                                <th width="20%" align="center">MODEL</th>
                                <th width="10%" align="center">PASS</th>
                                <th width="10%" align="center">TOTAL</th>
                                <th width="10%" align="center">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;

                            // diff time
                            function DateDiff($strDate1, $strDate2)
                            {
                                return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
                            }

                            // check time
                            if (DateDiff($DATE, date("Y-m-d")) > 3) {
                                $tbl_item = 'startup_item_trace';
                                $tbl_time = 'startup_time_trace';
                            } else {
                                $tbl_item = 'startup_item';
                                $tbl_time = 'startup_time';
                            }

                            if (isset($MODEL)) {
                                if ($PERIOD_GET == 'DAY') {
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

                                        foreach ($MODEL as $MODEL_NAME) {
                                            $strSQL = "SELECT `SHIFT`, `SHIFT_DATE` 
                                            FROM `$tbl_time` 
                                            WHERE `MODEL` = '$MODEL_NAME' 
                                            AND `LINE` LIKE '%$CENTER%' 
                                            AND `SHIFT_DATE` = '$DATE' 
                                            AND `BIZ` = '$BIZ' ORDER BY `ID` DESC";
                                            $objQuery = mysqli_query($con, $strSQL);
                                            $objResult = mysqli_fetch_array($objQuery);
                                            // echo $strSQL . '<br>';
                                            if (!isset($objResult)) {
                                                $CHECK_SHIFT_DATE[] = '0';
                                            } else {
                                                $CHECK_SHIFT_DATE[] = '1';
                                            }
                                        }
                                        // print_r($CHECK_SHIFT_DATE);
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
                                    // check time
                                    if (DateDiff($SHIFT_DATE, date("Y-m-d")) > 3) {
                                        $tbl_item = 'startup_item_trace';
                                        $tbl_time = 'startup_time_trace';
                                    } else {
                                        $tbl_item = 'startup_item';
                                        $tbl_time = 'startup_time';
                                    }

                                    // echo $SHIFT . $SHIFT_DATE;
                                    foreach ($MODEL as $MODEL_NAME) {

                                        require_once("connect.php");
                                        $strSQL = "SELECT `CONFIRM1`,`CONFIRM2`,`CONFIRM3` 
                                        FROM `$tbl_time` 
                                        WHERE `PERIOD` = '$PERIOD_GET' 
                                        AND `LINE` LIKE '%$CENTER%' 
                                        AND `MODEL` = '$MODEL_NAME' 
                                        AND SHIFT_DATE LIKE '$SHIFT_DATE%' ORDER BY ID DESC ";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $CONFIRM1 = array();
                                        $CONFIRM2 = array();
                                        $CONFIRM3 = array();
                                        while ($objResult = mysqli_fetch_array($objQuery)) {
                                            array_push($CONFIRM1, $objResult['CONFIRM1']);
                                            array_push($CONFIRM2, $objResult['CONFIRM2']);
                                            array_push($CONFIRM3, $objResult['CONFIRM3']);
                                        }
                                        // if ($MODEL_NAME == 'MGA TP') {
                                        //     // $TR = 'shadow';
                                        //     print_r($strSQL);
                                        // } else {
                                        //     // $TR = '';
                                        // }

                                        // $CONFIRM1 = $objResult['CONFIRM1'];
                                        // $CONFIRM2 = $objResult['CONFIRM2'];
                                        // $CONFIRM3 = $objResult['CONFIRM3'];

                                        $strSQL = "SELECT `PERIOD` 
                                        FROM `item` 
                                        WHERE `PERIOD` = '$PERIOD_GET'
                                        AND `LINE` LIKE '%$CENTER%'
                                        AND `MODEL` = '$MODEL_NAME' ORDER BY `item`.`ID` ASC";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $PERIOD = $objResult['PERIOD'];
                                        // echo $strSQL;echo '<br';
                                        if (empty($PERIOD)) {
                                            $MODE = "EMPTY";
                                        }
                                        if (isset($PERIOD)) {
                                            $MODE = "SHOW";
                                        }

                                        ///////// DATETIME DIFF //////////
                                        $strSQL2 = "SELECT `ID`,`SHIFT`,`DATETIME3`,`SHIFT_DATE`,`STARTTIME` 
                                        FROM `$tbl_time` 
                                        WHERE `PERIOD` = '$PERIOD_GET' 
                                        AND `BIZ` LIKE '%$BIZ%' 
                                        AND `LINE` LIKE '%$CENTER%'
                                        AND `MODEL` = '$MODEL_NAME'
                                        AND SHIFT_DATE LIKE '$SHIFT_DATE%'
                                        ORDER BY STARTTIME DESC LIMIT 1";
                                        $objQuery2 = mysqli_query($con, $strSQL2);
                                        $objResult2 = mysqli_fetch_array($objQuery2);
                                        $TIME_ID = $objResult2['ID'];
                                        $SHIFT_DB = $objResult2['SHIFT'];
                                        $LastUpdate = $objResult2['DATETIME3'];
                                        $DATE2 = $objResult2['SHIFT_DATE'];
                                        // echo $strSQL2 . '<br>';
                                        // $CONFIRM2
                                        // $LastUpdate = "2020-09-08 22:00:00";
                                        // echo "<br>";

                                        $STARTUPTIME = $objResult2['STARTTIME'];




                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,
                                        VALUE1,
                                            (SELECT COUNT(ID) 
                                            FROM `$tbl_item` 
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` LIKE '%$CENTER%' 
                                                AND `MODEL` = '$MODEL_NAME'
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'PASS') AS PASS,
                                            (SELECT COUNT(ID) 
                                            FROM `$tbl_item` 
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` LIKE '%$CENTER%' 
                                                AND `MODEL` = '$MODEL_NAME'
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'FAIL') AS FAIL,
                                            (SELECT COUNT(ID) 
                                            FROM `$tbl_item` 
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` LIKE '%$CENTER%' 
                                                AND `MODEL` = '$MODEL_NAME'
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE 'BLANK') AS BLANK,
                                            (SELECT COUNT(ID) 
                                            FROM `$tbl_item` 
                                            WHERE `PERIOD` = '$PERIOD_GET' 
                                                AND `LINE` LIKE '%$CENTER%' 
                                                AND `MODEL` = '$MODEL_NAME'
                                                AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                                AND JUDGEMENT LIKE '') AS 'NULL',
                                            COUNT(ID) AS TOTAL 
                                        FROM `$tbl_item` 
                                        WHERE `PERIOD` = '$PERIOD_GET' 
                                            AND `LINE` LIKE '%$CENTER%' 
                                            AND `MODEL` = '$MODEL_NAME'
                                            AND SHIFT_DATE LIKE '$SHIFT_DATE%'
                                        GROUP BY '$MODEL_NAME'
                                        ORDER BY SHIFT_DATE DESC";

                                        // echo $strSQL . '<br';

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
                                                // echo $MODEL_NAME;
                                                // if ($MODEL_NAME == 'HEA') {
                                                //     $TR = 'shadow';
                                                // } else {
                                                //     $TR = '';
                                                // }
                                                $SECON = '';
                                                $SPAN = '';
                                                $HIDDEN = '';
                                                $PASS = $objResult['PASS'];
                                                $TOTAL = $objResult['TOTAL'];

                                                if (($LastUpdate == '0000-00-00 00:00:00') && ($DIFFSTARTTIME < $RANGE)) {
                                                    // if ($SHIFT != $SHIFT_DB || $TOTAL == null) {
                                                    //     $PASS = '-';
                                                    //     $TOTAL = '-';
                                                    //     $TEXT = 'NO DATA2';
                                                    //     $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    // } else {
                                                    // echo $MODEL_NAME;
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
                                                    // echo $MODEL_NAME;
                                                    if ($DIFF > $RANGE) {
                                                        // echo $MODEL_NAME;
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
                                                        // $PASS = '-';
                                                        // $TOTAL = '-';
                                                        $TEXT = 'NO DATA4';
                                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                        // if ($SHIFT != $SHIFT_DB) {
                                                        //     $PASS = '-';
                                                        //     $TOTAL = '-';
                                                        //     $TEXT = 'NO DATA5';
                                                        //     $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                        // } else {
                                                        // echo $MODEL_NAME;
                                                        if ($PASS == $TOTAL && $PASS != '0') {
                                                            // if ($MODEL_NAME == 'MGA TP') {
                                                            //     // $TR = 'shadow';
                                                            //     print_r($CONFIRM2);
                                                            // } else {
                                                            //     // $TR = '';
                                                            // }
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
                                                        // }
                                                    }
                                                }
                                            }
                                        } else if ($MODE == "EMPTY") {
                                            // echo $MODEL_NAME;
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
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_model.php?MODEL=" . $MODEL_NAME . "&CENTER=" . $CENTER . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&PERIOD=" . $PERIOD_GET . "'>" . $MODEL_NAME . "</a></b></h4></a></td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                            echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                        } else {
                                            // ODD NUMBER
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_model.php?MODEL=" . $MODEL_NAME .  "&CENTER=" . $CENTER . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&PERIOD=" . $PERIOD_GET . "'>" . $MODEL_NAME . "</a></b></h4></a></td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                            echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                            echo "</tr>";
                                        }
                                        $i++;
                                    }
                                } else {
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

                                        foreach ($MODEL as $MODEL_NAME) {
                                            $strSQL = "SELECT `SHIFT`, `SHIFT_DATE` FROM `$tbl_time` WHERE `MODEL` = '$MODEL_NAME' AND `LINE` LIKE '%$CENTER%' AND `SHIFT` = '$SHIFT' AND `SHIFT_DATE` = '$DATE' AND `BIZ` = '$BIZ' ORDER BY `ID` DESC";
                                            $objQuery = mysqli_query($con, $strSQL);
                                            $objResult = mysqli_fetch_array($objQuery);
                                            // echo $strSQL . '<br>';
                                            if (!isset($objResult)) {
                                                $CHECK_SHIFT_DATE[] = '0';
                                            } else {
                                                $CHECK_SHIFT_DATE[] = '1';
                                            }
                                        }
                                        // print_r($CHECK_SHIFT_DATE);
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

                                    // check time
                                    if (DateDiff($SHIFT_DATE, date("Y-m-d")) > 3) {
                                        $tbl_item = 'startup_item_trace';
                                        $tbl_time = 'startup_time_trace';
                                    } else {
                                        $tbl_item = 'startup_item';
                                    }


                                    // echo $SHIFT . $SHIFT_DATE;
                                    foreach ($MODEL as $MODEL_NAME) {

                                        require_once("connect.php");
                                        $strSQL = "SELECT `CONFIRM1`,`CONFIRM2`,`CONFIRM3` FROM `$tbl_time` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$CENTER%' AND `MODEL` = '$MODEL_NAME' AND SHIFT LIKE '$SHIFT' AND SHIFT_DATE LIKE '$SHIFT_DATE%' ORDER BY ID DESC ";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        // echo $strSQL . '<br>';

                                        $CONFIRM1 = $objResult['CONFIRM1'];
                                        $CONFIRM2 = $objResult['CONFIRM2'];
                                        $CONFIRM3 = $objResult['CONFIRM3'];

                                        $strSQL = "SELECT `PERIOD` FROM `item` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$CENTER%' AND `MODEL` = '$MODEL_NAME' ORDER BY `item`.`ID` ASC";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $PERIOD = $objResult['PERIOD'];
                                        // echo $strSQL;echo '<br';
                                        if (empty($PERIOD)) {
                                            $MODE = "EMPTY";
                                        }
                                        if (isset($PERIOD)) {
                                            $MODE = "SHOW";
                                        }

                                        ///////// DATETIME DIFF //////////
                                        $strSQL2 = "SELECT `ID`,`SHIFT`,`DATETIME3`,`SHIFT_DATE`,`STARTTIME` 
                                        FROM `$tbl_time` 
                                        WHERE `PERIOD` = '$PERIOD_GET' 
                                        AND `BIZ` LIKE '%$BIZ%' 
                                        AND `LINE` LIKE '%$CENTER%'
                                        AND `MODEL` = '$MODEL_NAME'
                                        AND SHIFT_DATE LIKE '$SHIFT_DATE%' 
                                        AND SHIFT LIKE '%$SHIFT%'
                                        ORDER BY STARTTIME DESC LIMIT 1";
                                        $objQuery2 = mysqli_query($con, $strSQL2);
                                        $objResult2 = mysqli_fetch_array($objQuery2);
                                        $TIME_ID = $objResult2['ID'];
                                        $SHIFT_DB = $objResult2['SHIFT'];
                                        $LastUpdate = $objResult2['DATETIME3'];
                                        $DATE2 = $objResult2['SHIFT_DATE'];
                                        // echo $strSQL2 . '<br>';
                                        // $CONFIRM2
                                        // $LastUpdate = "2020-09-08 22:00:00";
                                        // echo "<br>";

                                        $STARTUPTIME = $objResult2['STARTTIME'];




                                        $strSQL = "SELECT LINE,LastUpdate,SHIFT_DATE,
                                        VALUE1,
                                        (SELECT COUNT(ID) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$CENTER%' AND `MODEL` = '$MODEL_NAME' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$SHIFT_DATE%' AND JUDGEMENT LIKE 'PASS') AS PASS,
                                        (SELECT COUNT(ID) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$CENTER%' AND `MODEL` = '$MODEL_NAME' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$SHIFT_DATE%' AND JUDGEMENT LIKE 'FAIL') AS FAIL,
                                        (SELECT COUNT(ID) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$CENTER%' AND `MODEL` = '$MODEL_NAME' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$SHIFT_DATE%' AND JUDGEMENT LIKE 'BLANK') AS BLANK,
                                        (SELECT COUNT(ID) FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$CENTER%' AND `MODEL` = '$MODEL_NAME' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$SHIFT_DATE%' AND JUDGEMENT LIKE '') AS 'NULL',
                                        COUNT(ID) AS TOTAL 
                                        FROM `$tbl_item` 
                                        WHERE `PERIOD` = '$PERIOD_GET' AND `LINE` LIKE '%$CENTER%' AND `MODEL` = '$MODEL_NAME' AND SHIFT = '$SHIFT' AND SHIFT_DATE LIKE '$SHIFT_DATE%'
                                        GROUP BY '$MODEL_NAME'
                                        ORDER BY SHIFT_DATE DESC";

                                        // echo $strSQL . '<br';

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
                                                // echo $MODEL_NAME;
                                                // if ($MODEL_NAME == 'HEA') {
                                                //     $TR = 'shadow';
                                                // } else {
                                                //     $TR = '';
                                                // }
                                                $SECON = '';
                                                $SPAN = '';
                                                $HIDDEN = '';
                                                $PASS = $objResult['PASS'];
                                                $TOTAL = $objResult['TOTAL'];

                                                if (($LastUpdate == '0000-00-00 00:00:00') && ($DIFFSTARTTIME < $RANGE)) {
                                                    if ($SHIFT != $SHIFT_DB || $TOTAL == null) {
                                                        $PASS = '-';
                                                        $TOTAL = '-';
                                                        $TEXT = 'NO DATA2';
                                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';
                                                    } else {
                                                        // echo $MODEL_NAME;
                                                        if ($PASS == $TOTAL && $PASS != '0') {
                                                            if ((empty($CONFIRM2)) or ($CONFIRM2 == '')) {
                                                                $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                                $TEXT = 'SUP.MFE';
                                                            } else if ((empty($CONFIRM3)) or ($CONFIRM3 == '')) {
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
                                                    // echo $MODEL_NAME;
                                                    if ($DIFF > $RANGE) {
                                                        // echo $MODEL_NAME;
                                                        $PASS = '-';
                                                        $TOTAL = '-';
                                                        $TEXT = 'NO DATA3';
                                                        $STATUS = '<p><img src="framework/img/Rlight.png" width="50"></p>';

                                                        if ($objResult['PASS'] == $objResult['TOTAL'] && $objResult['PASS'] != 0) {
                                                            $PASS = $objResult['PASS'];
                                                            $TOTAL = $objResult['TOTAL'];
                                                            if ((empty($CONFIRM2)) or ($CONFIRM2 == '')) {
                                                                $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                                $TEXT = 'SUP.MFE';
                                                            } else if ((empty($CONFIRM3)) or ($CONFIRM3 == '')) {
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
                                                                if ((empty($CONFIRM2)) or ($CONFIRM2 == '')) {
                                                                    $STATUS = '<p><img src="framework/img/Ylight.png" width="50"></p>';
                                                                    $TEXT = 'SUP.MFE';
                                                                }
                                                                if ((empty($CONFIRM3)) or ($CONFIRM3 == '')) {
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
                                            // echo $MODEL_NAME;
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
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_model.php?MODEL=" . $MODEL_NAME . "&CENTER=" . $CENTER . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&PERIOD=" . $PERIOD_GET . "'>" . $MODEL_NAME . "</a></b></h4></a></td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                            echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                        } else {
                                            // ODD NUMBER
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'><h4><b><a class='text-dark' href='visual_model.php?MODEL=" . $MODEL_NAME .  "&CENTER=" . $CENTER . "&DATE=" . $DATE . "&SHIFT=" . $SHIFT . "&DATE_SHIFT=" . $SHIFT_DATE . "&PERIOD=" . $PERIOD_GET . "'>" . $MODEL_NAME . "</a></b></h4></a></td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle' " . $SPAN . ">" . $PASS . "</td>";
                                            echo "<td style='text-align:center; vertical-align:middle' " . $HIDDEN . ">" . $TOTAL . "</td>";
                                            echo "<td class='" . $SECON . "' style='text-align:center; vertical-align:middle'>" . $STATUS . $TEXT . "</td>";
                                            echo "</tr>";
                                        }
                                        $i++;
                                    }
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

<script>
    // alert("OK");
    $(document).ready(function() {
        var shift = '<?php echo $SHIFT ?>';
        <?php if ($PERIOD_GET == 'DAY') { ?>
            $("#STARTUP_SHIFT").val("DISABLED");
            document.getElementById("STARTUP_SHIFT").disabled = true;
        <?php } else { ?>
            if (shift == 'DAY') {
                $("#STARTUP_SHIFT").val("NIGHT");
            } else {
                $("#STARTUP_SHIFT").val("DAY");
            }
        <?php } ?>
    })
</script>