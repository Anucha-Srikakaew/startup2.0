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
    if (isset($_POST['CHECKLATE']) && ($_POST['CHECKLATE'] == 'LATE')) {
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
        $ItemID = $_POST['ItemID'];
        $VALUE1 = $_POST['VALUE1'];
        if (isset($_POST['VALUE2'])) {
            $VALUE2 = $_POST['VALUE2'];
        }

        $MEMBER_ID = $_POST['MEMBER_ID'];
        $TIME_ID = $_POST['TIME_ID'];
        // $MODE = $_POST['MODE'];
        $MODE = "UPDATE";
        $LINE = $_POST['LINE'];
        $MODEL = $_POST['MODEL'];



        $strSQL = "SELECT * FROM `startup_item` 
        WHERE LINE LIKE '%$LINE%' 
        AND MODEL LIKE '%$MODEL%' 
        AND SHIFT LIKE '%$SHIFT%' 
        AND LastUpdate LIKE '$DATE%' 
        ORDER BY `startup_item`.`ID` ASC";

        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        if (isset($MODE)) {

            if ($MODE == 'UPDATE' && (isset($objResult))) {
                $arr = array_combine($ItemID, $VALUE1);

                $strSQL = "SELECT * FROM `startup_item` 
                        WHERE LINE LIKE '%$LINE%' 
                        AND MODEL LIKE '%$MODEL%' 
                        AND SHIFT LIKE '%$SHIFT%' 
                        AND LastUpdate LIKE '$DATE%' 
                        ORDER BY `startup_item`.`ID` ASC";

                $objQuery = mysqli_query($con, $strSQL);
                while ($objResult = mysqli_fetch_array($objQuery)) {
                    $ID[] = $objResult['ID'];
                }

                $VALUE1 = $_POST['VALUE1'];
                $VALUE2 = $_POST['VALUE2'];

                $arrValue = array_combine($ID, $VALUE1);

                $i = 0;
                $x = 0;
                foreach ($ID as &$ItemID) {
                    $ItemID;
                    $V1 = $VALUE1[$i];

                    $strSQL = "SELECT * FROM `startup_item` WHERE ID = '$ItemID'";
                    $objQuery = mysqli_query($con, $strSQL);
                    $objResult = mysqli_fetch_array($objQuery);
                    $SPEC = $objResult['SPEC'];

                    if ($SPEC == 'VALUE') {
                        $V2 = $VALUE2[$x];
                        $x++;
                    } else {
                        $V2 = '';
                    }

                    $strSQL = "UPDATE `startup_item` SET VALUE1='$V1', VALUE2='$V2',LastUpdate = '$GLOBAL_NOW ' WHERE ID = '$ItemID'";
                    $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                    $i++;
                }
                if (isset($error)) {
                    print_r($error);
                    $color = 'danger';
                    $text = 'UPDATE ERROR';
                } else {

                    $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW ', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
                    $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                    $color = 'success';
                    $text = 'UPDATE COMPLETE';
                }
            }
        } else {

            $LINE = $_GET['LINE'];
            $MEMBER_ID = $_GET['MEMBER_ID'];
            $LINE_TYPE = $_GET['LINE_TYPE'];

            $strSQL = "SELECT BIZ FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);

            $BIZ = $objResult['BIZ'];

            $strSQL = "SELECT * FROM `biz` WHERE BIZ = '$BIZ'";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);
            $COUNTRY = $objResult['COUNTRY'];
            $FACTORY = $objResult['FACTORY'];

            $strSQL = "INSERT INTO `startup_item`
                VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', 'NO PRODUCTION', '', '', '', '', '', '', 'NO PRODUCTION', '', '', '', '', '$SHIFT', '', '$GLOBAL_NOW ');";
            $objQuery = mysqli_query($con, $strSQL)  or die($error[] = $strSQL);

            $strSQL = "INSERT INTO `startup_time` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `REMARK`, `SHIFT`, `STARTTIME`, `CONFIRM1`, `DATETIME1`, `CONFIRM2`, `DATETIME2`, `CONFIRM3`, `DATETIME3`, `TAKT`, `RESULT`) 
                VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', 'NO PRODUCTION', '', '$SHIFT', '$GLOBAL_NOW ', '$MEMBER_ID', '', '', '', '', '', '', '');";
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

            $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW ', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
            $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

            //////UPDATE GOOD STARTUP TO 84 MONITOR///////////

            if ($SHIFT=='DAY') {
                $SHIFT_SEND = 'A';
            } else {
                $SHIFT_SEND = 'B';
            }

            require_once("connect84.php");
            $strSQL = "INSERT INTO `di_cl`.`tbl_startup_check` 
            (`data_id` , `shift_date` , `for_model` ,`line` ,`result` ,`shift` , `rec_date`)
            VALUES 
            (NULL , '$DATE', '$BIZ', '$LINE', 'STOP', '$SHIFT_SEND', '$GLOBAL_NOW ')";
            $objQuery = mysqli_query($con84, $strSQL);

            $color = '';
            $text = $LINE . '<br><p>NO PRODUCTION</p>';
        }
    } else {

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
            // $MODE = $_POST['MODE'];
            $MODE = "UPDATE";
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

            $BIZ = $objResult[]


            if (isset($MODE)) {
                if ($MODE == 'UPDATE' && (isset($objResult))) {

                    $arr = array_combine($ItemID, $VALUE1);

                    $strSQL = "SELECT * FROM `startup_item` 
                    WHERE LINE LIKE '%$LINE%' 
                    AND MODEL LIKE '%$MODEL%' 
                    AND SHIFT LIKE '%$SHIFT%' 
                    AND LastUpdate LIKE '$DATE%' 
                    ORDER BY `startup_item`.`ID` ASC";

                    $objQuery = mysqli_query($con, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                        $ID[] = $objResult['ID'];
                    }
                    $VALUE1 = $_POST['VALUE1'];
                    $VALUE2 = $_POST['VALUE2'];
                    $arrValue = array_combine($ID, $VALUE1);

                    $i = 0;
                    $x = 0;
                    foreach ($ID as $ItemID) {
                        $ItemID;
                        $V1 = $VALUE1[$i];

                        $strSQL = "SELECT * FROM `startup_item` WHERE ID = '$ItemID'";
                        $objQuery = mysqli_query($con, $strSQL);
                        $objResult = mysqli_fetch_array($objQuery);
                        $SPEC = $objResult['SPEC'];

                        if ($SPEC == 'VALUE') {
                            $V2 = $VALUE2[$x];
                            $x++;
                        } else {
                            $V2 = '';
                        }

                        $strSQL = "UPDATE `startup_item` SET VALUE1='$V1', VALUE2='$V2',LastUpdate = '$GLOBAL_NOW ' WHERE ID = '$ItemID'";
                        $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                        $i++;
                    }
                    if (isset($error)) {
                        print_r($error);
                        $color = 'danger';
                        $text = 'UPDATE ERROR';
                    } else {

                        $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW ', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
                        $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                        $color = 'success';
                        $text = 'UPDATE COMPLETE';
                    }

                }
                if ($MODE == 'INSERT') {

                    $arr = array_combine($ItemID, $VALUE1);

                    $i = 0;
                    $x = 0;
                    foreach ($arr as &$value) {

                        $ID = $ItemID[$i];
                        $VALUE1 = $value;

                        $strSQL = "SELECT * FROM `item` WHERE ID = '$ID'";
                        $objQuery = mysqli_query($con, $strSQL);
                        $objResult = mysqli_fetch_array($objQuery);
                        $BIZ = $objResult['BIZ'];
                        $LINE = $objResult['LINE'];
                        $LINE_TYPE = $objResult['TYPE'];
                        $MODEL = $objResult['MODEL'];
                        $PROCESS = $objResult['PROCESS'];
                        $ITEM = $objResult['ITEM'];
                        $SPEC_DES = $objResult['SPEC_DES'];
                        $MIN = $objResult['MIN'];
                        $MAX = $objResult['MAX'];
                        $SPEC = $objResult['SPEC'];

                        if ($SPEC == 'VALUE') {
                            $V2 = $VALUE2[$x];
                            $x++;
                        } else {
                            $V2 = '';
                        }

                        $strSQL = "SELECT * FROM `biz` WHERE BIZ = '$BIZ'";
                        $objQuery = mysqli_query($con, $strSQL);
                        $objResult = mysqli_fetch_array($objQuery);
                        $COUNTRY = $objResult['COUNTRY'];
                        $FACTORY = $objResult['FACTORY'];
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

                        $strSQL = "INSERT INTO `startup_item`
                        VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '$MODEL', '$PROCESS', '$ITEM', '$SPEC_DES', '$MIN', '$MAX', '$SPEC', '$VALUE1', '$V2', '', '', '', '$SHIFT', '', '$GLOBAL_NOW ');";
                        $objQuery = mysqli_query($con, $strSQL)  or die($error[] = $strSQL);

                        $i++;
                    }

                    if (isset($error)) {
                        print_r($error);
                        $color = 'danger';
                        $text = 'INSERT ERROR';
                    } else {

                        $strSQL = "SELECT ID FROM `startup_time` 
                        WHERE `BIZ` LIKE '$BIZ' 
                        AND `LINE` LIKE '$LINE' 
                        AND `TYPE` LIKE '$LINE_TYPE' 
                        AND `SHIFT` LIKE '$SHIFT' 
                        ORDER BY STARTTIME DESC LIMIT 1";
                        $objQuery = mysqli_query($con, $strSQL);
                        $objResult = mysqli_fetch_array($objQuery);

                        $TIME_ID = $objResult['ID'];

                        $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW ', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
                        $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                        $color = 'success';
                        $text = 'INSERT COMPLETE';
                    }
                }
                if ($MODE == 'NO PRODUCTION') {


                    $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW ', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
                    $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

                    echo "NO PRODUCTION";
                    $text = 'NO PRODUCTION';
                }
            } else {
                header("Location: login.php?text=PLEASE LOGIN BEFORE DO STARTUP");
                echo $test = 'NO LOOP';
                $text = 'PLEASE LOGIN';
            }
        } else {

            // print_r($_POST);

            $LINE = $_GET['LINE'];
            $MEMBER_ID = $_GET['MEMBER_ID'];
            $LINE_TYPE = $_GET['LINE_TYPE'];

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

            $strSQL = "SELECT BIZ FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);

            $BIZ = $objResult['BIZ'];

            $strSQL = "SELECT * FROM `biz` WHERE BIZ = '$BIZ'";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);
            $COUNTRY = $objResult['COUNTRY'];
            $FACTORY = $objResult['FACTORY'];

            $strSQL = "INSERT INTO `startup_item`
            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', '', '', '', '', '', '', '', 'NO PRODUCTION', '', '', '', '$DATE', '$SHIFT', '', '$GLOBAL_NOW ');";
            $objQuery = mysqli_query($con, $strSQL)  or die($error[] = $strSQL);

            $strSQL = "INSERT INTO `startup_time` (`ID`, `COUNTRY`, `FACTORY`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `REMARK`, `SHIFT_DATE`, `SHIFT`, `STARTTIME`, `CONFIRM1`, `DATETIME1`, `CONFIRM2`, `DATETIME2`, `CONFIRM3`, `DATETIME3`, `TAKT`, `RESULT`) 
            VALUES (NULL, '$COUNTRY', '$FACTORY', '$BIZ', '$LINE', '$LINE_TYPE', 'NO PRODUCTION', '', '$DATE', '$SHIFT', '$GLOBAL_NOW ', '$MEMBER_ID', '', '', '', '', '', '', '');";
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

            $strSQL = "UPDATE `startup_time` SET `DATETIME1` = '$GLOBAL_NOW ', `DATETIME2` = '' ,CONFIRM2 = '', `DATETIME3` = '' ,CONFIRM3 = '' WHERE `startup_time`.`ID` = '$TIME_ID';";
            $objQuery = mysqli_query($con, $strSQL) or die($error[] = $strSQL);

            //////UPDATE GOOD STARTUP TO 84 MONITOR///////////

            if ($SHIFT=='DAY') {
                $SHIFT_SEND = 'A';
            } else {
                $SHIFT_SEND = 'B';
            }

            require_once("connect84.php");
            $strSQL = "INSERT INTO `di_cl`.`tbl_startup_check` 
            (`data_id` , `shift_date` , `for_model` ,`line` ,`result` ,`shift` , `rec_date`)
            VALUES 
            (NULL , '$DATE', '$BIZ', '$LINE', 'STOP', '$SHIFT_SEND', '$GLOBAL_NOW ')";
            $objQuery = mysqli_query($con84, $strSQL);

            $color = '';
            $text = $LINE . '<br><p>NO PRODUCTION</p>';
        }
    }

    ?>
</head>

<body>
    <section id="login">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>SMART STARTUP CHECK</b></h1><BR><BR>
                    <h1 class="text-<?php echo $color; ?>"><?php echo $text; ?></h1>
                    <BR><BR><BR><BR>
                </div>
                <div class="col-lg-6 mx-auto">
                    <a href="startup_c.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>" class="btn btn-dark">STARTUP MORE</a>
                    <a href="visual.php?BIZ=<?php echo $BIZ; ?>" class="btn btn-success">CHECK RESULT</a>
                </div>
            </div>
        </div>
    </section>
</body>

</html>