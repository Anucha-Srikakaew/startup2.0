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
    <script src="framework/js/a076d05399.js"></script>

    <link rel="stylesheet" href="framework/css/bootstrap.min.css">
    <script src="framework/js/jquery.min.js"></script>
    <script src="framework/js/bootstrap.min.js"></script>
    <script src="framework/js/jquery-3.5.1.js"></script>
    <script src="framework/js/jquery.min.js"></script>
    <script src="framework/js/jquery-ui.js"></script>

    <!-- datatable -->
    <script src="framework/js/jquery.dataTables.min.js"></script>
    <script src="framework/js/dataTables.bootstrap4.min.js"></script>
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

        /* .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(framework/img/Preloader.gif) center no-repeat #fff;
        } */
    </style>

    <script>
        // $(document).ready(function() {
        //     $(".se-pre-con").fadeOut(2000);
        // });
    </script>
</head>

<style>
    /* .nowrap {
        white-space: nowrap;
    } */
</style>

<body>
    <div class="se-pre-con"></div>
    <?php
    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");
    $PROCESS = '';

    $DATE = $_GET['DATE'];
    $CENTER = $_GET['CENTER'];
    $MODEL = $_GET['MODEL'];
    // $DATE = $_GET['DATE_SHIFT'];
    // print_r($_GET);

    if (isset($_GET['CHECK_PROCESS'])) {
        $CHECK_PROCESS = 'YES';
        $MODELS = $_GET['MODEL'];
        $TYPES = $_GET['TYPE'];
        $DATE_SHIFTS = $_GET['DATE_SHIFT'];
        $DATES = $_GET['DATE'];
    } else {
        $CHECK_PROCESS = '';
        $MODELS = '';
        $TYPES = '';
        $DATES = '';
        $DATE_SHIFTS = '';
    }
    $now = date("H");
    if (($now >= 8) && ($now < 20)) {
        $SHIFT = 'DAY';
    } else {
        $SHIFT = 'NIGHT';
    }

    if (isset($_GET['SHIFT'])) {
        $SHIFT_SELECT = $_GET['SHIFT'];
        $DATE_SHIFT = $_GET['DATE_SHIFT'];
    } else {
        $SHIFT_SELECT = '';
        $DATE_SHIFT = $_GET['DATE'];;
    }

    $strSQL = "SELECT DISTINCT PROCESS,MODEL,SHIFT,BIZ 
    FROM `startup_item` 
    WHERE LINE = '$CENTER' AND MODEL = '$MODEL'
    AND LastUpdate LIKE (SELECT DISTINCT CONCAT(date_format(LastUpdate, '%Y-%m-%d %H:%i'), '%') FROM `startup_item` WHERE LINE = '$CENTER' ORDER BY LastUpdate DESC LIMIT 1)";
    $objQuery = mysqli_query($con, $strSQL);
    $PROCESS = array();
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $PROCESS[] = $objResult['PROCESS'];
        $MODEL = $objResult['MODEL'];
        $objResult['SHIFT'];
        $BIZ = $objResult['BIZ'];
    }
    if (!isset($BIZ)) {
        $BIZ = '';
    }
    if (empty($MODEL)) {
        $MODEL = '';
    }

    $DATE = $_GET['DATE'];
    $PERIOD = $_GET['PERIOD'];

    // diff time
    function DateDiff($strDate1, $strDate2)
    {
        return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
    }

    // check time
    if (DateDiff($DATE_SHIFT, date("Y-m-d")) > 3) {
        $tbl_item = 'startup_item_trace';
        $tbl_time = 'startup_time_trace';
    } else {
        $tbl_item = 'startup_item';
        $tbl_time = 'startup_time';
    }

    if (isset($SHIFT_SELECT) && $SHIFT_SELECT != '') {
        $strSQL = "SELECT *,
    TIMESTAMPDIFF(MINUTE, STARTTIME, DATETIME1) AS TAKT1,
    TIMESTAMPDIFF(MINUTE, DATETIME1, DATETIME2) AS TAKT2,
    TIMESTAMPDIFF(MINUTE, DATETIME2, DATETIME3) AS TAKT3  FROM `$tbl_time` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$CENTER' AND MODEL = '$MODEL' AND SHIFT_DATE LIKE '$DATE_SHIFT%' AND SHIFT LIKE '%$SHIFT_SELECT%' ORDER BY ID DESC";
    } else {
        $strSQL = "SELECT *,
    TIMESTAMPDIFF(MINUTE, STARTTIME, DATETIME1) AS TAKT1,
    TIMESTAMPDIFF(MINUTE, DATETIME1, DATETIME2) AS TAKT2,
    TIMESTAMPDIFF(MINUTE, DATETIME2, DATETIME3) AS TAKT3  FROM `$tbl_time` 
    WHERE `PERIOD` = '$PERIOD' AND LINE = '$CENTER' AND MODEL = '$MODEL' AND STARTTIME LIKE '$DATE_SHIFT%' ORDER BY ID DESC";
    }

    //  echo $strSQL;
    $objQuery = mysqli_query($con, $strSQL);
    $CONFIRM1 = array();
    $CONFIRM2 = array();
    $CONFIRM3 = array();
    $TYPE = array();
    // $MODEL = array();
    while ($objResult = mysqli_fetch_array($objQuery)) {
        array_push($CONFIRM1, array('TYPE' => $objResult['TYPE'], 'CONFIRM1' => $objResult['CONFIRM1'], 'TAKT1' => $objResult['TAKT1'], 'DATETIME1' => $objResult['DATETIME1']));
        array_push($CONFIRM2, array('TYPE' => $objResult['TYPE'], 'CONFIRM2' => $objResult['CONFIRM2'], 'TAKT2' => $objResult['TAKT2'], 'DATETIME2' => $objResult['DATETIME2']));
        array_push($CONFIRM3, array('TYPE' => $objResult['TYPE'], 'CONFIRM3' => $objResult['CONFIRM3'], 'TAKT3' => $objResult['TAKT3'], 'DATETIME3' => $objResult['DATETIME3']));
        array_push($TYPE, $objResult['TYPE']);
        // array_push($MODEL, $objResult['MODEL']);
    }

    // $MODEL = array_unique($MODEL);

    if (count($TYPE) != 0) {
        if (12 / count($TYPE) < 12) {
            $show1 = 'h6';
            $show2 = 'h6';
            $show3 = 'h6';
            $container = 'container-fluid';
            $col = "col-" . 12 / count($TYPE) . "";
            if (count($TYPE) > 3) {
                $col = 'col-4';
            }
        } else {
            $show1 = 'h4';
            $show2 = 'h5';
            $show3 = 'h6';
            $container = 'container';
        }
    } else {
        $show1 = 'h4';
        $show2 = 'h5';
        $show3 = 'h6';
        $container = 'container';
    }
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="http://43.72.52.52/system/">SONY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="http://43.72.52.51/startup2.0/">HOME <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="http://43.72.52.51/startup2.0/login.php?BIZ=<?php echo $BIZ; ?>">LOGIN</a>
                </li>
                <li class="nav-item active">
                    <a id="nav-startup" class="nav-link" href="http://43.72.52.51/startup2.0/visual.php?BIZ=<?php echo $BIZ; ?>">STARTUP</a>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0 ">
                <a id="back1" class="nav-link " style="color:white;" href="#" onclick="backtohome()">BACK</a>
                <a id="back2" class="nav-link " style="color:white;" href="#" onclick="refresh()">BACK</a>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <section>
        <div class="row text-center">
            <div class="col-lg-12 mx-auto">
                <img src="" width="15%">
                <h1><b>SMART STARTUP CHECK</b></h1>
                <div class="mx-auto">
                    <p>
                        <span class="nowrap">CENTER : <?php echo $CENTER; ?></span>
                        <span class="nowrap" id="model_show"> / MODEL : <?php echo $MODEL; ?></span>
                        <span class="nowrap" id="type_show"></span>
                    </p>

                </div>
                <br><br><br><br>

                <div class="<?php echo $container ?>" id="container">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <h4><b>TECHNICIAN</b></h4>

                            <div id="index1_tech">
                                <h5 id="IMAGE_SHOW1"></h5>
                                <h5 id="IMAGE1"></h5>
                                <h4 id="NAME1"></h4>
                                <h5 id="TAKT1"></h5>
                                <h6 id="DATE1"></h6>
                            </div>

                            <div class="row" id="index1">
                                <?php
                                if (empty($CONFIRM1)) {
                                    echo '<div class="col-12"><br><img src="framework/img/avatar.png" width="40%"></div>';
                                } else {
                                    foreach ($CONFIRM1 as $TECH) {
                                        $strSQL = "SELECT `NAME` FROM `member` WHERE `MEMBER_ID` = '$TECH[CONFIRM1]'";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $date = date_create($TECH['DATETIME1']);
                                        $DATETIME1 = date_format($date, "d-M-Y H:i:s");
                                ?>
                                        <div class="col-<?php echo 12 / count($TYPE) ?>">
                                            <h5><?php echo $TECH['TYPE']; ?></h5>
                                            <?php echo '<img src="http://43.72.52.159/ATTENd/IMG_opt/' . $TECH['CONFIRM1'] . '.JPG" width="50%">'; ?>
                                            <<?php echo $show1 ?>><?php echo $objResult['NAME']; ?></<?php echo $show1 ?>>
                                            <<?php echo $show2 ?>><?php echo $TECH['TAKT1'] . " MIN."; ?></<?php echo $show2 ?>>
                                            <<?php echo $show3 ?>><?php echo $DATETIME1 ?></<?php echo $show3 ?>>
                                        </div>
                                <?php }
                                } ?>
                            </div>

                        </div>
                        <div class="col-lg-4 mx-auto">
                            <h4><b>MFE SUPERVISIOR</b></h4>

                            <div id="index2_sup">
                                <h5 id="IMAGE_SHOW2"></h5>
                                <h5 id="IMAGE2"></h5>
                                <h4 id="NAME2"></h4>
                                <h5 id="TAKT2"></h5>
                                <h6 id="DATE2"></h6>
                            </div>
                            <div class="row" id="index2">
                                <?php
                                // print_r($CONFIRM2);
                                if (empty($CONFIRM2)) {
                                    echo '<div class="col-12"><br><img src="framework/img/avatar.png" width="40%"></div>';
                                } else {
                                    foreach ($CONFIRM2 as $SUP) {
                                        $strSQL = "SELECT `NAME` FROM `member` WHERE `MEMBER_ID` = '$SUP[CONFIRM2]'";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $date = date_create($SUP['DATETIME2']);
                                        $DATETIME1 = date_format($date, "d-M-Y H:i:s");
                                ?>
                                        <div class="col-<?php echo 12 / count($TYPE) ?>">
                                            <h5><?php echo $SUP['TYPE']; ?></h5>
                                            <?php
                                            if (empty($SUP['CONFIRM2'])) {
                                                echo '<br><img src="framework/img/avatar.png" width="40%">';
                                            } else {
                                                echo '<img src="http://43.72.52.159/ATTENd/IMG_opt/' . $SUP['CONFIRM2'] . '.JPG" width="50%">';
                                            ?>
                                                <<?php echo $show1 ?>><?php echo $objResult['NAME']; ?></<?php echo $show1 ?>>
                                                <<?php echo $show2 ?>><?php echo $SUP['TAKT2'] . " MIN."; ?></<?php echo $show2 ?>>
                                                <<?php echo $show3 ?>><?php echo $DATETIME1 ?></<?php echo $show3 ?>>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                <?php }
                                } ?>
                            </div><br><br>

                            <form method="POST" action="confirm.php">
                                <input type="hidden" name="LINE" value="<?php echo $CENTER; ?>">
                                <?php if (isset($SHIFT_SELECT) && $SHIFT_SELECT != '') { ?>
                                    <input type="hidden" name="SHIFT" value="<?php echo $SHIFT_SELECT; ?>">
                                <?php } else { ?>
                                    <input type="hidden" name="SHIFT" value="<?php echo $SHIFT; ?>">
                                <?php } ?>
                                <input type="hidden" name="DATE_SHIFT" value="<?php echo $DATE_SHIFT; ?>">
                                <input type="hidden" name="DATE" value="<?php echo $DATE; ?>">
                                <input type="hidden" name="LINE_TYPE" ID="LINE_TYPE" placeholder="LINE TYPE">
                                <input type="hidden" name="MODEL" ID="MODEL_CONFIRM" value="<?php echo $MODEL ?>" placeholder="MODEL CONFIRM">
                                <input type="hidden" name="CONFIRM" value="CONFIRM2" placeholder="CONFIRM2">
                                <input type="hidden" name="PERIOD" value="<?php echo $PERIOD ?>" placeholder="PERIOD">
                                <button type="submit" name="confirm2" id="confirm2" class="btn btn-success">CONFIRM</button>
                            </form>
                        </div>

                        <div class="col-lg-4 mx-auto">
                            <h4><b>PRODUCTION LEADER</b></h4>

                            <div id="index3_lead">
                                <h5 id="IMAGE_SHOW3"></h5>
                                <h5 id="IMAGE3"></h5>
                                <h4 id="NAME3"></h4>
                                <h5 id="TAKT3"></h5>
                                <h6 id="DATE3"></h6>
                            </div>

                            <div class="row" id="index3">
                                <?php
                                if (empty($CONFIRM3)) {
                                    echo '<div class="col-12"><br><img src="framework/img/avatar.png" width="40%"></div>';
                                } else {
                                    foreach ($CONFIRM3 as $LEAD) {
                                        $strSQL = "SELECT `NAME` FROM `member` WHERE `MEMBER_ID` = '$LEAD[CONFIRM3]'";
                                        $objQuery = mysqli_query($con, $strSQL);
                                        $objResult = mysqli_fetch_array($objQuery);
                                        $date = date_create($LEAD['DATETIME3']);
                                        $DATETIME1 = date_format($date, "d-M-Y H:i:s");
                                ?>
                                        <div class="col-<?php echo 12 / count($TYPE) ?>">
                                            <h5><?php echo $LEAD['TYPE']; ?></h5>
                                            <?php
                                            if (empty($LEAD['CONFIRM3'])) {
                                                echo '<br><img src="framework/img/avatar.png" width="40%">';
                                            } else {
                                                echo '<img src="http://43.72.52.159/ATTENd/IMG_opt/' . $LEAD['CONFIRM3'] . '.JPG" width="50%">';
                                            ?>
                                                <<?php echo $show1 ?>><?php echo $objResult['NAME']; ?></<?php echo $show1 ?>>
                                                <<?php echo $show2 ?>><?php echo $LEAD['TAKT3'] . " MIN."; ?></<?php echo $show2 ?>>
                                                <<?php echo $show3 ?>><?php echo $DATETIME1 ?></<?php echo $show3 ?>>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                <?php }
                                } ?>
                            </div>
                            <br><br>

                            <form method="POST" action="confirm.php">
                                <input type="hidden" name="LINE" value="<?php echo $CENTER; ?>">
                                <?php if (isset($SHIFT_SELECT) && $SHIFT_SELECT != '') { ?>
                                    <input type="hidden" name="SHIFT" value="<?php echo $SHIFT_SELECT; ?>">
                                <?php } else { ?>
                                    <input type="hidden" name="SHIFT" value="<?php echo $SHIFT; ?>">
                                <?php } ?>
                                <input type="hidden" name="DATE_SHIFT" value="<?php echo $DATE_SHIFT; ?>">
                                <input type="hidden" name="DATE" value="<?php echo $DATE; ?>">
                                <input type="hidden" name="LINE_TYPE" ID="LINE_TYPE3" placeholder="LINE TYPE">
                                <input type="hidden" name="MODEL" ID="MODEL_CONFIRM2" value="<?php echo $MODEL ?>">
                                <input type="hidden" name="CONFIRM" value="CONFIRM3">
                                <input type="hidden" name="PERIOD" value="<?php echo $PERIOD ?>" placeholder="PERIOD">
                                <button type="submit" name="confirm3" id="confirm3" class="btn btn-success">CONFIRM</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- <button id="print" class="btn btn-primary" onclick="print()"><i class="fas fa-print"></i> PRINT DOCUMENT</button> -->
                <form method="POST" action="dispose.php">
                    <input type="hidden" name="LINE" value="<?php echo $CENTER; ?>">
                    <?php if (isset($SHIFT_SELECT) && $SHIFT_SELECT != '') { ?>
                        <input type="hidden" name="SHIFT" value="<?php echo $SHIFT_SELECT; ?>">
                    <?php } else { ?>
                        <input type="hidden" name="SHIFT" value="<?php echo $SHIFT; ?>">
                    <?php } ?>
                    <input type="hidden" name="DATE_SHIFT" value="<?php echo $DATE_SHIFT; ?>">
                    <input type="hidden" name="DATE" value="<?php echo $DATE; ?>">
                    <input type="hidden" name="MODEL" id="MODEL_DISPOSE" value="<?php echo $MODEL; ?>">
                    <input type="hidden" name="TYPE" ID="TYPE_DISPOSE">
                    <input type="hidden" name="PERIOD" value="<?php echo $PERIOD ?>" placeholder="PERIOD">
                    <button id="dispose" class="btn btn-danger"><i class="fa fa-times"></i>DISPOSE</button>
                </form>

                <br><br><br><br>

                <div class="container">
                    <table id="example" class="table table-striped table-bordered " style="width:100%">
                        <div style="overflow-x:auto;">
                            <thead class="thead-dark text-black">
                                <tr>
                                    <th class="text-center">PROCESS</th>
                                    <!-- <th class="text-center">MODEL</th> -->
                                    <th class="text-center">PASS</th>
                                    <th class="text-center">FAIL</th>
                                    <th class="text-center">BLANK</th>
                                    <th class="text-center">TOTAL</th>
                                    <th class="text-center">STATUS</th>
                                </tr>
                            </thead>
                        </div>
                    </table>
                </div>
            </div>
    </section>
</body>

<?php
$insert_target = "SELECT * FROM `target_shift` WHERE LINE LIKE '$CENTER'";
$objQuery = mysqli_query($con, $insert_target);
$objResult = mysqli_fetch_array($objQuery);
$TARGET1 =  $objResult['TARGET1'];
$TARGET2 = $objResult['TARGET2'];
$TARGET3 = $objResult['TARGET3'];
// $TARGET_DAY = $objResult['TARGET_TIME_DAY'];
// $TARGET_NIGHT = $objResult['TARGET_TIME_NIGHT'];
$i = 0;
$check = 0;
?>

</html>
<script>
    check = <?php echo json_encode($check); ?>;
    PROCESS = <?php echo json_encode($PROCESS); ?>;
    SHIFT = <?php echo json_encode($SHIFT); ?>;
    SHIFT_SELECT = <?php echo json_encode($SHIFT_SELECT); ?>;
    DATE = <?php echo json_encode($DATE); ?>;
    DATE_SHIFT = <?php echo json_encode($DATE_SHIFT); ?>;
    CENTER = <?php echo json_encode($CENTER); ?>;
    CONFIRM2 = <?php echo json_encode($CONFIRM2); ?>;
    CONFIRM3 = <?php echo json_encode($CONFIRM3); ?>;
    BIZ = <?php echo json_encode($BIZ); ?>;
    TYPES = <?php echo json_encode($TYPES); ?>;
    MODELS = <?php echo json_encode($MODELS); ?>;
    MODEL = <?php echo json_encode($MODEL); ?>;
    DATES = <?php echo json_encode($DATES); ?>;
    DATE_SHIFTS = <?php echo json_encode($DATE_SHIFTS); ?>;
    CHECK_PROCESS = <?php echo json_encode($CHECK_PROCESS); ?>;
    MODEL_SHOW = <?php echo json_encode($MODEL); ?>;
    PERIOD = <?php echo json_encode($PERIOD); ?>;

    TYPE = '';

    TYPE_S = '';
    // $('#nav-startup').hide();


    $(document).ready(function() {

        $('#confirm2').hide();
        $('#confirm3').hide();
        $.ajax({
            type: 'post', // the method (could be GET btw)
            url: 'model.php', // The file where my php code is
            data: {
                'LINE': CENTER, // all variables i want to pass. In this case, only one.
                'PERIOD': PERIOD
            },
            success: function(data) { // in case of success get the output, i named data
                var TYPE_CHECK = JSON.parse(data);
                $.each(TYPE_CHECK, function(index, value) {
                    $('#LINE_TYPE').append("<option value=" + value + ">" + value + "</option>");
                });
            }
        })

        $("#example").DataTable({
            paging: false,
            searching: false,
            "order": [
                [1, 'DESC']
            ],

        });
    })

    function loaddata() {
        if (TYPE == '') {
            TYPE = TYPES
        }
        data = {
            'PROCESS': PROCESS,
            'SHIFT': SHIFT_SELECT,
            'DATE': DATE,
            'DATE_SHIFT': DATE_SHIFT,
            'CENTER': CENTER,
            'TYPE': TYPE,
            'MODEL': MODEL,
            'PERIOD': PERIOD,
            'DATA': 1
        }
        console.log(data);
        $.ajax({
            type: "POST",
            url: "loaddata_center.php",
            data: data,
            dataType: 'JSON',
            success: function(result) {
                // console.log(result)
                $('#index1_tech').show();
                $('#index2_sup').show();
                $('#index3_lead').show();

                $('#index1').hide();
                $('#index2').hide();
                $('#index3').hide();

                $('#NAME1,#TAKT1,#DATE1').show();
                $('#dispose').show(); ///dispose model

                $('#index1').hide();
                $('#IMAGE1').html('<img src="http://43.72.52.159/ATTENd/IMG_opt/' + result[7] + '.JPG " width="40%">');
                $('#NAME1').html(result[18]);
                $('#TAKT1').html(result[12] + ' MIN.');
                $('#DATE1').html(result[4]);

                if (TYPE != '') {
                    document.getElementById("container").classList.add("container");
                    $('#IMAGE_SHOW1,#IMAGE_SHOW2,#IMAGE_SHOW3').hide();
                    if (result[0] - result[2] == 0) {
                        ///////PASS ALL CASE////////
                        $("#LINE_TYPE3").attr("type", "text");
                        $("#LINE_TYPE3").attr("value", TYPE);
                        $("#LINE_TYPE3").attr("type", "hidden");

                        if ((result[8] == '' || result[8] == null) && (result[9] == '' || result[9] == null)) {
                            //////////SUP. MFE CONFIRM/////////
                            $('#confirm2').show();
                            $('#confirm3').hide();

                            $('#IMAGE2').html('<img src="framework/img/avatar.png" width="40%">');
                            $('#IMAGE3').html('<img src="framework/img/avatar.png" width="40%">');
                            $('#dispose').show(); ///dispose model

                        } else if ((result[8] != '' || result[8] != null) && (result[9] == '' || result[9] == null)) {
                            //////////PRODUCTION CONFIRM/////////
                            $('#confirm2').hide();
                            $('#confirm3').show();

                            $('#IMAGE2').html('<img src="http://43.72.52.159/ATTENd/IMG_opt/' + result[8] + '.JPG" width="40%">');
                            $('#NAME2').html(result[10]);
                            $('#TAKT2').html(result[13] + ' MIN.');
                            $('#DATE2').html(result[5]);
                            $('#IMAGE3').html('<img src="framework/img/avatar.png" width="40%">');
                            $('#dispose').show(); ///dispose model

                        } else {
                            /////////ALL COMPLETE////////////
                            $('#confirm2,#confirm3').hide();

                            $('#IMAGE2').html('<img src="http://43.72.52.159/ATTENd/IMG_opt/' + result[8] + '.JPG" width="40%">');
                            $('#NAME2').html(result[10]);
                            $('#TAKT2').html(result[13] + ' MIN.');
                            $('#DATE2').html(result[5]);

                            $('#IMAGE3').html('<img src="http://43.72.52.159/ATTENd/IMG_opt/' + result[9] + '.JPG" width="40%">');
                            $('#TAKT3').html(result[14] + ' MIN.');
                            $('#DATE3').html(result[6]);
                            $('#NAME3').html(result[11]);
                            $('#print').show(); ///in condition print document
                            $('#dispose').hide(); ///ok condition hide dispose model
                        }
                    } else {
                        $('#IMAGE2').html('<br><img src="framework/img/avatar.png" width="40%">');
                        $('#TAKT2').html('');
                        $('#DATE2').html('');
                        $('#NAME2').html('');

                        $('#IMAGE3').html('<br><img src="framework/img/avatar.png" width="40%">');
                        $('#TAKT3').html('');
                        $('#DATE3').html('');
                        $('#NAME3').html('');
                    }
                    // console.log('OK');
                }

                if (parseInt(result[12]) > parseInt(result[15])) {
                    $('#TAKT1').css({
                        "color": "red",
                        "font-weight": "bold"
                    }).show();
                } else {
                    $('#TAKT1').css({
                        "color": "black"
                    }).show();
                }
                if (parseInt(result[13]) > parseInt(result[16])) {
                    $('#TAKT2').css({
                        "color": "red",
                        "font-weight": "bold"
                    }).show();
                } else {
                    $('#TAKT2').css({
                        "color": "black"
                    }).show();
                }
                if (parseInt(result[14]) > parseInt(result[17])) {
                    $('#TAKT3').css({
                        "color": "red",
                        "font-weight": "bold"
                    }).show();
                } else {
                    $('#TAKT3').css({
                        "color": "black"
                    }).show();
                }
            }
        })
    }

    function loadtabledefault() {
        console.log("loadtabledefault")
        $('#type_show').html('');
        $('#type_show').hide();
        // $('#model_show').html("/ MODEL : " + MODEL_SHOW);
        $('#index1_tech').hide();
        $('#index2_sup').hide();
        $('#index3_lead').hide();
        $('#index1').show();
        $('#index2').show();
        $('#index3').show();

        $('#back1').show();
        $('#print').hide();
        $('#dispose').hide(); ///dispose model
        $('#backtopage').hide();
        $('#backtohome').show();
        $('#back2').hide();
        // $('#nav-startup').hide();
        data = {
            // 'SHIFT': SHIFT,
            'SHIFT': SHIFT_SELECT,
            'DATE': DATE,
            'DATE_SHIFT': DATE_SHIFT,
            'CENTER': CENTER,
            'MODEL': MODEL,
            'TYPE': TYPE,
            'PERIOD': PERIOD,
            'DATA': 1
        }
        // console.log(data)
        $.ajax({
            type: "POST",
            url: "loaddatadefault_center.php",
            data: data,
            dataType: 'JSON',
            success: function(result) {
                // console.log(result)
                if (result.length > 0) {
                    let table = $("#example").DataTable({
                        "bLengthChange": false,
                        "bInfo": false,
                        "bAutoWidth": false,
                        destroy: true,
                        searching: false,
                        "columnDefs": [{
                            "orderable": false,
                            "targets": 4
                        }],
                        responsive: true,
                    });
                    table.clear()

                    result.forEach(function(table_row) {
                        // console.log(table_row)
                        var i = table.row.add([
                            "<td>" + table_row.use_TYPE + "</td>",
                            // "<td>" + table_row.use_model + "</td>",
                            "<td>" + table_row.use_PASS + "</td>",
                            "<td>" + table_row.use_FAIL + "</td>",
                            "<td>" + table_row.use_BLANK + "</td>",
                            "<td>" + table_row.use_TOTAL + "</td>",
                            "<td>" + table_row.use_TEXT + "</td>",
                        ]).draw(false);
                        table.rows(i).nodes().to$().attr('class', 'table-' + table_row.use_STATUS);
                        $(table.column(0).header()).text('TYPE');
                    });
                } else {
                    table.draw(false);
                }
            }
        });
    }

    function loaddatatable_am() {
        console.log("loaddatatable_am")
        // $('#print').show();///no condition print document
        $('#backtopage').show();
        $('#backtohome').hide();
        $('#back1').hide();
        $('#back2').show();
        // $('#nav-startup').show();
        data = {
            'PROCESS': PROCESS,
            'SHIFT': SHIFT_SELECT,
            'DATE': DATE,
            'DATE_SHIFT': DATE_SHIFT,
            'CENTER': CENTER,
            'TYPE': TYPE,
            'MODEL': MODEL,
            'PERIOD': PERIOD,
            'DATA': 1,
        }

        console.log(data)
        $.ajax({
            type: "POST",
            url: "loaddatatable_center.php",
            data: data,
            dataType: 'JSON',
            success: function(result) {
                console.log(result)
                if (result.length > 0) {
                    let table = $("#example").DataTable({
                        "bLengthChange": false,
                        "bFilter": true,
                        "bInfo": false,
                        "bAutoWidth": false,
                        "iTabIndex": 1,
                        destroy: true,
                        searching: false,
                        "ordering": false,
                        responsive: true,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search records"
                        }
                    });
                    table.clear()
                    result.forEach(function(table_row) {
                        var i = table.row.add([
                            "<td>" + table_row.use_PROCESS_NAME + "</td>",
                            "<td>" + table_row.use_TYPE + "</td>",
                            "<td>" + table_row.use_PASS + "</td>",
                            "<td>" + table_row.use_FAIL + "</td>",
                            "<td>" + table_row.use_BLANK + "</td>",
                            "<td>" + table_row.use_TOTAL + "</td>",
                            "<td>" + table_row.use_TEXT + "</td>"
                        ]).draw(false);
                        i.nodes().to$().attr('class', 'table-' + table_row.use_STATUS);
                        // i.column(0).hide(false);
                        i.column(1).visible(false);
                        $(table.column(0).header()).text('PROCESS');
                    });
                } else {
                    table.draw(false);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log("Error: ", errorMessage);
                console.log("Status: ", textStatus);
                console.log("jqXhr: ", jqXhr);
            }
        });
    }


    if (CHECK_PROCESS != '') {
        loaddatatable_ams();
        // $('#nav-startup').show();
        console.log("if")
    } else {
        loadtabledefault();
        console.log("else")
    }

    function loaddatatable_ams() {
        console.log("loaddatatable_ams")
        $('#backtopage').show();
        $('#backtohome').hide();
        $('#back1').hide();
        $('#back2').show();
        data = {
            'CENTER': CENTER,
            'PROCESS': PROCESS,
            'SHIFT': SHIFT_SELECT,
            'DATE': DATES,
            'DATE_SHIFT': DATE_SHIFTS,
            'CENTER': CENTER,
            'TYPE': TYPES,
            'MODEL': MODELS,
            'PERIOD': PERIOD,
            'DATA': 1,
        }
        // console.log(data)
        $.ajax({
            type: "POST",
            url: "loaddatatable_center.php",
            data: data,
            dataType: 'JSON',
            success: function(result) {
                if (result.length > 0) {
                    let table = $("#example").DataTable({
                        "bLengthChange": false,
                        "bFilter": true,
                        "bInfo": false,
                        "bAutoWidth": false,
                        "iTabIndex": 1,
                        destroy: true,
                        searching: false,
                        "ordering": false,
                        responsive: true,
                        language: {
                            search: "_INPUT_",
                            searchPlaceholder: "Search records"
                        }
                    });
                    table.clear()
                    result.forEach(function(table_row) {
                        // console.log(table_row);
                        var i = table.row.add([
                            "<td>" + table_row.use_PROCESS_NAME + "</td>",
                            "<td>" + table_row.use_TYPE + "</td>",
                            "<td>" + table_row.use_PASS + "</td>",
                            "<td>" + table_row.use_FAIL + "</td>",
                            "<td>" + table_row.use_BLANK + "</td>",
                            "<td>" + table_row.use_TOTAL + "</td>",
                            "<td>" + table_row.use_TEXT + "</td>",
                        ]).draw(false);
                        i.nodes().to$().attr('class', 'table-' + table_row.use_STATUS);
                        // i.column(0).hide(false);
                        i.column(1).visible(false);
                        $(table.column(0).header()).text('PROCESS');
                    });
                } else {
                    table.draw(false);
                }
            }
        });
        loaddata();
    }
    if (BIZ == 'AC') {
        function backtohome() {
            window.location.href = 'http://43.72.52.51/startup2.0/visual.php?BIZ=IM';
        }
    } else {
        function backtohome() {
            window.location.href = 'http://43.72.52.51/startup2.0/visual_center.php?BIZ=IM&CENTER=<?php echo $CENTER ?>&PERIOD=<?php echo $PERIOD ?>';
        }
    }

    function click_value(value, name) {
        TYPE = value;
        // MODEL = name;
        // console.log(TYPE)
        // console.log(MODEL)
        // $('#model_show').html("/ MODEL : " + MODEL);
        $('#LINE_TYPE').val(TYPE)
        $('#LINE_TYPE3').val(TYPE)
        $('#type_show').html("/ TYPE : " + TYPE);
        // $('#CENTER_TYPE').val(TYPE)
        // $('#MODEL_CONFIRM').val(MODEL)
        // $('#MODEL_CONFIRM2').val(MODEL)
        // $('#MODEL_DISPOSE').val(MODEL)
        $('#TYPE_DISPOSE').val(TYPE)
        loaddatatable_am();
        loaddata();
    }

    function print() {
        window.location.href = 'http://43.72.52.51/startup2.0/document/export.php?LINE=' + LINE + '&MODEL=' + MODEL + '&TYPE=' + TYPE + '&SHIFT_DATE=<?php echo $_GET['DATE_SHIFT'] ?>&SHIFT=<?php echo $_GET['SHIFT'] ?>';
    }

    function refresh() {
        $('#confirm2').hide();
        $('#confirm3').hide();
        // loadtabledefault()
        if (CHECK_PROCESS != '') {
            loadtabledefault()
        } else {
            window.location.reload(true)
        }
    }
</script>