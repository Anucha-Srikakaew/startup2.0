<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXPORT</title>

    <link rel="icon" href="../framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

    <link href="../framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../framework/css/scrolling-nav.css" rel="stylesheet">
    <link rel="stylesheet" href="../framework/css/bootstrap.min.css">
    <script src="../framework/js/jquery.min.js"></script>
    <script src="../framework/js/bootstrap.min.js"></script>
    <script src="../framework/js/jquery-3.5.1.js"></script>
    <script src="../framework/js/jquery.min.js"></script>
    <script src="../framework/js/jquery-ui.js"></script>
    <script src="../framework/js/a076d05399.js"></script>

    <link href="../framework/fontawesome/css/all.css" rel="stylesheet">
    <script defer src="../framework/fontawesome/js/all.js"></script>
    <link href="../framework/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="../framework/fontawesome/css/brands.css" rel="stylesheet">
    <link href="../framework/fontawesome/css/solid.css" rel="stylesheet">
    <script defer src="../framework/fontawesome/js/brands.js"></script>
    <script defer src="../framework/fontawesome/js/solid.js"></script>
    <script defer src="../framework/fontawesome/js/fontawesome.js"></script>
</head>

<body>
    <?php
    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");

    if ((isset($_GET)) && (isset($_GET['LINE'])) && (isset($_GET['MODEL'])) && (isset($_GET['SHIFT_DATE'])) && (isset($_GET['SHIFT']))) {

        $LINE = $_GET['LINE'];
        $MODEL = $_GET['MODEL'];
        $SHIFT_DATE = $_GET['SHIFT_DATE'];
        $SHIFT = $_GET['SHIFT'];
        $TYPE = $_GET['TYPE'];

        // diff time
        function DateDiff($strDate1, $strDate2)
        {
            return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
        }

        // check time
        if (DateDiff($SHIFT_DATE, date("Y-m-d")) > 3) {
            $tbl_item = 'startup_item_trace';
            $tbl_time = 'startup_time_trace';
        } else {
            $tbl_item = 'startup_item';
            $tbl_time = 'startup_time';
        }

        $strSQL = "SELECT * FROM `$tbl_time` WHERE `LINE` LIKE '$LINE' AND `TYPE` LIKE '$TYPE' AND `MODEL` LIKE '$MODEL' AND `SHIFT_DATE` LIKE '%$SHIFT_DATE%' AND SHIFT LIKE '$SHIFT' ORDER BY `ID` ASC";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);
        $CONFIRM1 = $objResult['CONFIRM1'];
        $CONFIRM2 = $objResult['CONFIRM2'];
        $CONFIRM3 = $objResult['CONFIRM3'];
        $DATETIME1 = $objResult['DATETIME1'];
        $DATETIME2 = $objResult['DATETIME2'];
        $DATETIME3 = $objResult['DATETIME3'];

        $strSQL = "SELECT NAME FROM `member` WHERE `MEMBER_ID` LIKE '$CONFIRM1'";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);
        $NAME1 = $objResult['NAME'];


        $strSQL = "SELECT NAME FROM `member` WHERE `MEMBER_ID` LIKE '$CONFIRM2'";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);
        $NAME2 = $objResult['NAME'];


        $strSQL = "SELECT NAME FROM `member` WHERE `MEMBER_ID` LIKE '$CONFIRM3'";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);
        $NAME3 = $objResult['NAME'];

        $strSQL = "SELECT * FROM `$tbl_item` WHERE `LINE` LIKE '$LINE' AND `TYPE` LIKE '$TYPE' AND `MODEL` LIKE '$MODEL' AND `SHIFT_DATE` LIKE '%$SHIFT_DATE%' AND SHIFT LIKE '$SHIFT' ORDER BY `ID` ASC";
        $data = array();
        $objQuery = mysqli_query($con, $strSQL);
        while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
            array_push($data, $objResult);
            if (($objResult['SPEC'] == 'PHOTO') && (($objResult['VALUE1'] != "") or (!empty($objResult['VALUE1'])))) {
                $img[] = $objResult['VALUE1'];
            }
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Please review information");';
        echo 'window.location.href = "../index.php";';
        echo '</script>';
    }


    ?>
    <div class="text-center">
        <h1>SMART STARTUP SYSTEM</h1>
        <p>LINE : <?php echo $LINE; ?> <b>|</b> MODEL : <?php echo $MODEL; ?> <b>|</b> DATE : <?php echo $SHIFT_DATE; ?> <?php echo $SHIFT; ?></p>
    </div>

    <br><br>

    <div class="row">
        <div class="col-sm-4">
            <div class="text-center">
                <h5><?php echo $NAME1; ?></h5>
                <p><b>TECHNICIAN</b></p>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="text-center">
                <h5><?php echo $NAME2; ?></h5>
                <p><b>MFE SUPERVISIOR</b></p>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="text-center">
                <h5><?php echo $NAME3; ?></h5>
                <p><b>PRODUCTION LEADER</b></p>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>PROCESS</th>
                <th>ITEM</th>
                <th>SPEC</th>
                <th>INITIAL</th>
                <th>ADJUST</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $value) {
            ?>
                <tr>
                    <td><?php print_r($value['PROCESS']) ?></td>
                    <td><?php print_r($value['ITEM']) ?></td>
                    <td><?php print_r($value['SPEC_DES']) ?></td>
                    <td><?php print_r($value['VALUE1']) ?></td>
                    <td><?php print_r($value['VALUE2']) ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <div class="row">
        <?php
        if (empty($img)) {
            $img = array();
        } else {
            foreach ($img as $value) {
        ?>

                <div class="col-sm-6">
                    <div class="text-center">
                        <img src="../photo/<?php echo $value; ?>" width="90%">
                        <br>
                        <p><?php echo $value; ?></p>
                    </div>
                </div>

        <?php
            }
        }
        ?>
    </div>

</body>

</html>