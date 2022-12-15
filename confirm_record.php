<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP CHECK</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">

    <link rel="stylesheet" href="framework/css/bootstrap.min.css">
    <script src="framework/js/jquery.min.js"></script>
    <script src="framework/js/bootstrap.min.js"></script>
    <script src="framework/js/jquery-3.5.1.js"></script>
    <script src="framework/js/jquery.min.js"></script>
    <script src="framework/js/jquery-ui.js"></script>

    <?php
    #### MY FUCNTION ####
    // DIFF TIME //
    function DateDiff($strDate1, $strDate2)
    {
        return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
    }

    // DATE START, DATE END IN WEEK
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

    function StatusResult($shift_date, $shift, $line, $period)
    {
        if ($period == "DAY") {
            $connect = mysqli_connect("43.72.52.51", "inno", "1234", "startup2_0");
            $sql = "SELECT `ID` FROM `startup_time` WHERE `SHIFT_DATE` = '$shift_date' AND `SHIFT` = '$shift' AND `LINE` = '$line' AND `PERIOD` = '$period' AND `CONFIRM3` = ''";
            $query = mysqli_query($connect, $sql);
            $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
            if (empty($row)) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    if (empty($_POST) or $_POST == '') {
        // header("Location: index.php");
    } else {
        // print_r($_POST);
        $LINE = $_POST['LINE'];
        $LINE_TYPE = $_POST['LINE_TYPE'];
        $SHIFT = $_POST['SHIFT'];
        $DATE = $_POST['DATE'];
        $MODEL = $_POST['MODEL'];
        $DATE_SHIFT = $_POST['DATE_SHIFT'];
        $RFID = $_POST['RFID'];
        $PERIOD = $_POST['PERIOD'];
        $RFID = ltrim($RFID, '0');

        if ($PERIOD == "WEEK") {
            $date_arr = explode("-", $DATE);
            if (str_replace("W", "", $date_arr[1]) == date('W')) {
                $tbl_item = 'startup_item';
                $tbl_time = 'startup_time';
            } else {
                $tbl_item = 'startup_item_trace';
                $tbl_time = 'startup_time_trace';
            }
        } else {
            // check time
            if (DateDiff($DATE_SHIFT, date("Y-m-d")) > 3) {
                $tbl_item = 'startup_item_trace';
                $tbl_time = 'startup_time_trace';
            } else {
                $tbl_item = 'startup_item';
                $tbl_time = 'startup_time';
            }
        }

        ////test RFID////
        // $RFID = '17353499';

        require_once("connect159.php");
        date_default_timezone_set("Asia/Bangkok");

        $strSQL = "SELECT * FROM `t_b_consumer` WHERE `f_CardNO` LIKE '$RFID' OR `f_ConsumerNO` LIKE '$RFID'";
        $objQuery = mysqli_query($con159, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        $MEMBER_ID = $objResult['f_ConsumerNO'];

        if (($objResult == '') or (empty($objResult))) {
            $TEXT = "<h3 class='text-warning'>NOT FOUND THIS RFID</h3><p>Please confirm your card.</p>";
        } else {

            require_once("connect.php");
            date_default_timezone_set("Asia/Bangkok");
            $NOW = date("Y-m-d H:i:s");
            // $DATE = '2021-02-21';/////////////temp/////////////

            if ($PERIOD == "WEEK") {
                $date_arr = explode("-", $DATE);
                $START_DATE = getStartAndEndDate(str_replace('W', '', $date_arr[1]), $date_arr[0])[0];
                $END_DATE = getStartAndEndDate(str_replace('W', '', $date_arr[1]), $date_arr[0])[1];
                $query_shift_date = "AND `SHIFT_DATE` BETWEEN '$START_DATE' AND '$END_DATE'";

                if (str_replace("W", "", $date_arr[1]) == date('W')) {
                    $tbl_item = 'startup_item';
                    $tbl_time = 'startup_time';
                } else {
                    $tbl_item = 'startup_item_trace';
                    $tbl_time = 'startup_time_trace';
                }
            } else {
                $query_shift_date = "AND SHIFT_DATE LIKE '$DATE_SHIFT%' AND SHIFT = '$SHIFT'";
            }

            $strSQL = "SELECT * FROM `$tbl_time` 
            WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND MODEL LIKE '%$MODEL%' AND TYPE LIKE '%$LINE_TYPE%' $query_shift_date ORDER BY DATETIME1 DESC";

            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);

            $ID = $objResult['ID'];
            $BIZ = $objResult['BIZ'];
            $SHIFT_DATE = $objResult['SHIFT_DATE'];
            $SHIFT = $objResult['SHIFT'];
            if ($SHIFT == 'DAY') {
                $SHIFT1 = 'A';
                $SHIFT_DATE1 = date('Y-m-d', strtotime($objResult['SHIFT_DATE'] . "+1 days"));

                $SHIFT2 = 'B';
                $SHIFT_DATE2 = date('Y-m-d', strtotime($objResult['SHIFT_DATE'] . "+1 days"));
            } else {
                $SHIFT1 = 'B';
                $SHIFT_DATE1 = date('Y-m-d', strtotime($objResult['SHIFT_DATE'] . "+1 days"));

                $SHIFT2 = 'A';
                $SHIFT_DATE2 = date('Y-m-d', strtotime($SHIFT_DATE1 . "+1 days"));
            }

            $CONFIRM2 = $objResult['CONFIRM2'];

            if (($objResult == '') or (empty($objResult))) {
                $TEXT = "<h3 class='text-warning'>NO STARTUP IN THIS DETAILS</h3><p>Please confirm your information.</p>";
            } else {
                $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
                $objQuery = mysqli_query($con, $strSQL);
                $objResult = mysqli_fetch_array($objQuery);

                $MEMBER_TYPE = $objResult['TYPE'];
                if ($MEMBER_TYPE == 'SUP.T' or $MEMBER_TYPE == 'ENG' or $MEMBER_TYPE == 'ADMIN' or $MEMBER_TYPE == 'PIC') {

                    $strSQL = "UPDATE `$tbl_time` SET `CONFIRM2` = '$MEMBER_ID',DATETIME2 = '$NOW' WHERE `$tbl_time`.`ID` = $ID;";
                    $objQuery = mysqli_query($con, $strSQL);

                    $TEXT = "<h3 class='text-success'>CONFIRM COMPLETE</h3><p>MFE TEAM</p>";
                } else if ($MEMBER_TYPE == 'SUP.L' or $MEMBER_TYPE == 'LEAD' or $MEMBER_TYPE == 'ADMIN') {

                    if ((empty($CONFIRM2)) or ($CONFIRM2 == '')) {
                        $TEXT =  "NO MFE CONFIRM";
                    } else {

                        ////// RECORD STARTUP2.0 $tbl_time //////////////
                        $strSQL = "UPDATE `$tbl_time` SET `CONFIRM3` = '$MEMBER_ID',DATETIME3 = '$NOW' WHERE `$tbl_time`.`ID` = $ID;";
                        $objQuery = mysqli_query($con, $strSQL);

                        //////UPDATE GOOD STARTUP TO IPRO/////////////////
                        // require_once("connect_ipro.php");
                        // $strSQL = "UPDATE `ipro`.`interlock` SET `interlock`.`STUP` = '1' WHERE `interlock`.`LINE` = '$LINE';";
                        // $objQuery = mysqli_query($con, $strSQL);

                        ////// UPDATE GOOD STARTUP TO 84 MONITOR ///////////
                        if (StatusResult($SHIFT_DATE, $SHIFT, $LINE, $PERIOD) == true) {
                            require_once("connect84.php");
                            // SELECT * FROM tbl_startup_check ORDER BY `data_id` DESC
                            $strSQL = "INSERT INTO `di_cl`.`tbl_startup_check` 
                            (`data_id` , `shift_date` , `for_model` ,`line` ,`result` ,`shift` , `rec_date`)
                            VALUES 
                            (NULL , '$SHIFT_DATE1', '$BIZ', '$LINE', 'GOOD', '$SHIFT1', '$NOW'),
                            (NULL , '$SHIFT_DATE2', '$BIZ', '$LINE', 'GOOD', '$SHIFT2', '$NOW')";
                            $objQuery = mysqli_query($con84, $strSQL);
                        }

                        ///////TEXT SHOW ON SCREEN///////////////////////
                        $TEXT = "<h3 class='text-success'>CONFIRM COMPLETE</h3><p>PRODUCTION</p>";
                    }
                } else {
                    $TEXT = "<h3 class='text-warning'>NO PERMISSION</h3><p>Please confirm your information.</p>";
                }
            }
        }
        // echo $strSQL;
        require_once("connect.php");
        $sql_line = "SELECT * FROM `startup_line` WHERE `LINE` = '$LINE'";
        $query_line = mysqli_query($con, $sql_line);
        $row_line = mysqli_fetch_array($query_line);
        if ($row_line["TYPE"] == 'CENTER') {
            $LINK = "visual_center.php?CENTER=$LINE&DATE=$DATE&SHIFT=$SHIFT&DATE_SHIFT=$DATE_SHIFT&BIZ=IM&PERIOD=$PERIOD";
        } else {
            $LINK = "visual.php?BIZ=IM&PERIOD=$PERIOD";
            // somthing
        }
    }
    ?>

</head>
<?php $DATE = date('Y-m-d'); ?>

<body>

    <section id="login">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>SMART STARTUP CHECK</b></h1>
                    <p>CONFIRM TO STARTUP PRODUCTION LINE</p><br><br>
                    <?php echo $TEXT; ?>
                    <br><br><br><br>
                </div>
                <div class="col-lg-6 mx-auto">
                    <a href="<?php echo $LINK ?>" class="btn btn-success">HOME</a>
                </div>
            </div>
        </div>
    </section>

</body>

</html>