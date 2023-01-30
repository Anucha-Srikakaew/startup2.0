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
    <script src="framework/js/a076d05399.js"></script>

    <link href="framework/fontawesome/css/all.css" rel="stylesheet">
    <script defer src="framework/fontawesome/js/all.js"></script>
    <link href="framework/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="framework/fontawesome/css/brands.css" rel="stylesheet">
    <link href="framework/fontawesome/css/solid.css" rel="stylesheet">
    <script defer src="framework/fontawesome/js/brands.js"></script>
    <script defer src="framework/fontawesome/js/solid.js"></script>
    <script defer src="framework/fontawesome/js/fontawesome.js"></script>
    <?php
    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");

    if (isset($_GET['sub'])) {
        // print_r($_GET);
        $sub = $_GET['sub'];
        $new_value = number_format($sub);
        $new_value;

        if (empty($_GET['LINE'])) {
            $LINE = $_GET['CENTER'];
            $SHOW_TYPE_ = 'Center';
        } else {
            $LINE = $_GET['LINE'];
            $SHOW_TYPE_ = 'Line';
        }

        $MODEL = $_GET['MODEL'];
        $PROCESS = $_GET['PROCESS'];
        $ID_PROCESS = $new_value;
        $DATE =  $_GET['DATE'];
        $TYPE = $_GET['TYPE'];
        $DATE_SHIFT =  $_GET['DATE_SHIFT'];
        $SHIFT = $_GET['SHIFT'];
        $PERIOD = $_GET['PERIOD'];
        // if (isset($_GET['PERIOD'])) {
        //     $PERIOD = $_GET['PERIOD'];
        // } else {
        //     $PERIOD = '';
        // }
    } else {

        if (empty($_GET['LINE'])) {
            $LINE = $_GET['CENTER'];
            $SHOW_TYPE_ = 'Center';
        } else {
            $LINE = $_GET['LINE'];
            $SHOW_TYPE_ = 'Line';
        }

        $MODEL = $_GET['MODEL'];
        $PROCESS = $_GET['PROCESS'];
        $ID_PROCESS = $_GET['ID_PROCESS'];
        $DATE =  $_GET['DATE'];
        $DATE_SHIFT =  $_GET['DATE_SHIFT'];
        $TYPE = $_GET['TYPE'];
        $SHIFT = $_GET['SHIFT'];
        $PERIOD = $_GET['PERIOD'];
    }
    if ($PROCESS == 'NO DATA' or (empty($_GET['PROCESS']))) {
        header("Location: visual_line.php?LINE=$LINE");
    }

    if (isset($_GET['sub'])) {
        // print_r();
        $sub = $_GET['sub'];
        $new_value = number_format($sub);
        $PROCESSNEXT = $new_value;
    } else {
        $PROCESSNEXT = $ID_PROCESS;
    }

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

    $strSQL = "SELECT DISTINCT PROCESS FROM `$tbl_item` 
            WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' AND TYPE LIKE '$TYPE' AND MODEL LIKE '$MODEL' $query_shift_date ORDER BY ID ASC ";
    $objQuery = mysqli_query($con, $strSQL);

    $COUNT_NUM = 0;
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $PROCESS_SQL[] = $objResult['PROCESS'];
        $COUNT_NUM_CHECK = $COUNT_NUM++;
    }

    // print_r($PROCESS_SQL);
    // echo $PROCESS_SQL[$PROCESSNEXT];
    // $strSQL = "SELECT * FROM `$tbl_item` 
    // WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' 
    // AND PROCESS = '$PROCESS_SQL[$PROCESSNEXT]'
    // AND LastUpdate = (
    //     SELECT LastUpdate FROM `$tbl_item` WHERE `PERIOD` = '$PERIOD' AND LINE = '$LINE' 
    //     AND SHIFT_DATE LIKE '$DATE_SHIFT%' 
    //     AND SHIFT LIKE '%$SHIFT%' 
    //     AND PROCESS = '$PROCESS_SQL[$PROCESSNEXT]'
    //     AND TYPE = '$TYPE'
    //     ORDER BY LastUpdate DESC LIMIT 1) 
    // ORDER BY ID ASC";

    // $ID[] = array();
    // $PROCESS = array();
    // $JIG_NAME[] = array();
    // $PICTURE[] = array();
    // $ITEM[] = array();
    // $SPEC_DES[] = array();
    // $SPEC[] = array();
    // $VALUE1[] = array();
    // $VALUE2[] = array();
    // $JUDGEMENT[] = array();

    $strSQL = "SELECT * FROM `$tbl_item`
    WHERE `PERIOD` = '$PERIOD' 
    AND LINE = '$LINE' 
    AND MODEL LIKE '$MODEL'
    AND PROCESS = '$PROCESS_SQL[$PROCESSNEXT]'
    AND TYPE = '$TYPE'
    $query_shift_date
    ORDER BY ID ASC";
    mysqli_set_charset($con, "utf8");
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $BIZ = $objResult['BIZ'];
        $ID[] = $objResult['ID'];
        $PROCESS = $objResult['PROCESS'];
        $JIG_NAME[] = $objResult['JIG_NAME'];
        $PICTURE[] = $objResult['PICTURE'];
        $ITEM[] = $objResult['ITEM'];
        $SPEC_DES[] = $objResult['SPEC_DES'];
        $SPEC[] = $objResult['SPEC'];
        $VALUE1[] = $objResult['VALUE1'];
        $VALUE2[] = $objResult['VALUE2'];
        $JUDGEMENT[] = $objResult['JUDGEMENT'];
    }
    // }

    ?>

</head>

<body>

    <div id="test"></div>
    <?php if (isset($sub)) { ?>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
                        <a class="nav-link" href="http://43.72.52.51/startup2.0/login.php">LOGIN</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="http://43.72.52.51/startup2.0/visual.php?BIZ=<?php echo $BIZ; ?>&LINE=<?php echo $LINE; ?>">STARTUP</a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <a class="nav-link" style="color:white;" href="#" onclick="backtoprocess()">BACK</a>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <br>
        <br>
        <div class="row text-center" id="SHOW_TABLE">
            <div class="col-lg-12 mx-auto">
                <img src="" width="15%"><br><br>
                <h1><b>SMART STARTUP CHECK</b></h1>
                <h3>PROCESS : <?php echo $PROCESS_SQL[$PROCESSNEXT]; ?></h3>
                <h5 class="text-danger">Line : <?php echo $LINE; ?>/ Model: <?php echo $MODEL ?>/ Type : <?php echo $TYPE ?>/ Shift Date : <?php echo $DATE ?></h5>
                <br><br>

                <div class="container">
                    <table id="example" class="table table-striped table-bordered " style="width:100%">
                        <div style="overflow-x:auto;">
                            <thead class="thead-dark text-black">
                                <tr>
                                    <?php
                                    // if (!in_array('', $PICTURE)) {
                                    //     echo '<th class="text-center col-lg-2">PICTURE</th>';
                                    // } else {
                                    //     // echo 'false';
                                    // }
                                    ?>
                                    <th class="text-center col-lg-2">PICTURE</th>
                                    <th class="text-center">ITEM</th>
                                    <th class="text-center">SPEC</th>
                                    <th class="text-center" width="15%">INITIAL</th>
                                    <th class="text-center" width="15%">ADJUST</th>
                                </tr>
                                <?php
                                $i = 0;
                                foreach ($ID as $row) {
                                    if ($JUDGEMENT[$i] == 'PASS') {
                                        $STATUS = 'success';
                                    } else if ($JUDGEMENT[$i] == 'FAIL') {
                                        $STATUS = 'danger';
                                    } else {
                                        $STATUS = 'warning';
                                    }
                                    if (($SPEC[$i] == 'PHOTO') && ((!empty($VALUE1)))) {
                                        // echo 'CHECK' . $i;
                                        $SHOW_VALUE1 = '  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter' . $i . '" >
                                                    <i class="fa fa-eye" aria-hidden="true"></i> WATCH
                                                </button>';

                                        if (empty($VALUE1[$i])) {
                                            $SHOW_VALUE1 = '';
                                        }

                                ?>
                                        <div class="modal fade" id="exampleModalCenter<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog " role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle" value="">FILE NAME : <?php echo $VALUE1[$i]; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="photo/<?php echo $VALUE1[$i]; ?>" width="100%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                        $SHOW_VALUE1 = $VALUE1[$i];
                                    }

                                    ?>
                                    <tr class="table-<?php echo $STATUS; ?> ">
                                        <?php
                                        if ($PICTURE[$i] != '') {
                                            // echo 'sdfsdfsd';
                                            echo '<td class="text-center"><img src="http://43.72.52.239/STARTUP_photo_body/photo_By_item/photo/' . $PICTURE[$i] . '" alt="" width="100%" class="img"><br>' . $JIG_NAME[$i] . '</td>';
                                        } else {
                                            echo '<td class="text-center"><img src="http://43.72.52.51/startup2.0/framework/img/SMART_LOGO.png" alt="" width="30%" class="img"><br>STARTUP2.0</td>';
                                        }
                                        ?>
                                        <td align="left"><?php echo $ITEM[$i]; ?></td>
                                        <td align="left"><?php echo $SPEC_DES[$i]; ?></td>
                                        <td align="left"><?php echo $SHOW_VALUE1; ?></td>
                                        <td align="left"><?php echo $VALUE2[$i]; ?></td>
                                    </tr>


                                <?php
                                    $i++;
                                }
                                ?>
                            </thead>
                        </div>
                    </table>
                </div>
                <a href="#" id="left_all" onclick="" class="btn btn-dark"><i class='fas fa-angle-double-left' style='color:white'></i></a>
                <?php if ($PROCESSNEXT > 0) { ?>
                    <a href="#" id="left_one" onclick="" class="btn btn-dark"><i class='fas fa-angle-left' style='color:white'></i></a>
                <?php } else { ?>
                    <a href="#" onclick="" class="btn btn-dark"><i class='fas fa-angle-left' style='color:white'></i></a>
                <?php } ?>
                <a href="#" onclick="backtohome()" class="btn btn-dark"><i class='fas fa-home' style='color:white'></i></a>
                <?php if ($PROCESSNEXT < $COUNT_NUM_CHECK) { ?>
                    <a href="#" id="right_one" onclick="" class="btn btn-dark"><i class='fas fa-angle-right' style='color:white'></i></a>
                <?php } else { ?>
                    <a href="#" onclick="" class="btn btn-dark"><i class='fas fa-angle-right' style='color:white'></i></a>
                <?php } ?>
                <a href="#" id="right_all" onclick="" class="btn btn-dark"><i class='fas fa-angle-double-right' style='color:white'></i></a>

            </div>
        </div>
    <?php } else { ?>
        <!-- Navbar -->
        <nav id="nav-df" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
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
                        <a class="nav-link" href="http://43.72.52.51/startup2.0/login.php?BIZ=<?php echo $BIZ ?>">LOGIN</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="http://43.72.52.51/startup2.0/visual.php?BIZ=<?php echo $BIZ; ?>&LINE=<?php echo $LINE; ?>">STARTUP</a>
                    </li>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                    <a class="nav-link" style="color:white;" href="#" onclick="backtoprocess()">BACK</a>
                </div>
            </div>
        </nav>
        <br>
        <br>
        <!-- End Navbar -->
        <div class="row text-center" id="testdiv">
            <div class="col-lg-12 mx-auto">
                <img src="" width="15%"><br><br>
                <h1><b>SMART STARTUP CHECK</b></h1>
                <h3>PROCESS : <?php echo $PROCESS_SQL[$PROCESSNEXT]; ?></h3>
                <h5 class="text-danger">Line : <?php echo $LINE; ?>/ Model: <?php echo $MODEL ?>/ Type : <?php echo $TYPE ?>/ Shift Date : <?php echo $DATE ?></h5>
                <br><br>

                <div class="container">
                    <table id="example" class="table table-striped table-bordered " style="width:100%">
                        <div style="overflow-x:auto;">
                            <thead class="thead-dark text-black">
                                <tr>
                                    <th class="text-center col-lg-2">PICTURE</th>
                                    <?php
                                    // if (!in_array('', $PICTURE)) {
                                    //     echo '<th class="text-center col-lg-2">PICTURE</th>';
                                    // } else {
                                    //     // echo 'false';
                                    // }
                                    ?>
                                    <th class="text-center">ITEM</th>
                                    <th class="text-center">SPEC</th>
                                    <th class="text-center" width="15%">INITIAL VALUE</th>
                                    <th class="text-center" width="15%">ADJUST VALUE</th>
                                    <th class="text-center" width="15%">JUDGEMENT</th>
                                </tr>
                                <?php
                                $i = 0;
                                foreach ($ID as $row) {
                                    if ($JUDGEMENT[$i] == 'PASS') {
                                        $STATUS = 'success';
                                    } else if ($JUDGEMENT[$i] == 'FAIL') {
                                        $STATUS = 'danger';
                                    } else {
                                        $STATUS = 'warning';
                                    }
                                    if (($SPEC[$i] == 'PHOTO') && ((!empty($VALUE1)))) {
                                        // echo 'CHECK' . $i;
                                        $SHOW_VALUE1 = '  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter' . $i . '" >
                                                    <i class="fa fa-eye" aria-hidden="true"></i> WATCH
                                                </button>';

                                        if (empty($VALUE1[$i])) {
                                            $SHOW_VALUE1 = '';
                                        }
                                ?>
                                        <div class="modal fade" id="exampleModalCenter<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle" value="">FILE NAME : <?php echo $VALUE1[$i]; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <img src="photo/<?php echo $VALUE1[$i]; ?>" width="100%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                        $SHOW_VALUE1 = $VALUE1[$i];
                                    }

                                    ?>
                                    <tr class="table-<?php echo $STATUS; ?> ">
                                        <?php
                                        if ($PICTURE[$i] != '') {
                                            echo '<td class="text-center"><img src="http://43.72.52.239/STARTUP_photo_body/photo_By_item/photo/' . $PICTURE[$i] . '" alt="" width="100%" class="img"><br>' . $JIG_NAME[$i] . '</td>';
                                        } else {
                                            echo '<td class="text-center"><img src="http://43.72.52.51/startup2.0/framework/img/SMART_LOGO.png" alt="" width="30%" class="img"><br>STARTUP2.0</td>';
                                        }
                                        ?>
                                        <td align="left"><?php echo $ITEM[$i]; ?></td>
                                        <td align="left"><?php echo $SPEC_DES[$i]; ?></td>
                                        <td align="left"><?php echo $SHOW_VALUE1; ?></td>
                                        <td align="left"><?php echo $VALUE2[$i]; ?></td>
                                        <td align="center"><b><?php echo $JUDGEMENT[$i]; ?></b></td>
                                    </tr>


                                <?php
                                    $i++;
                                }
                                ?>
                            </thead>
                        </div>
                    </table>
                </div>
                <a href="#" id="left_all" onclick="" class="btn btn-dark"><i class='fas fa-angle-double-left' style='color:white'></i></a>
                <?php if ($PROCESSNEXT > 0) { ?>
                    <a href="#" id="left_one" onclick="" class="btn btn-dark"><i class='fas fa-angle-left' style='color:white'></i></a>
                <?php } else { ?>
                    <a href="#" onclick="" class="btn btn-dark"><i class='fas fa-angle-left' style='color:white'></i></a>
                <?php } ?>
                <a href="#" onclick="backtohome()" class="btn btn-dark"><i class='fas fa-home' style='color:white'></i></a>
                <?php if ($PROCESSNEXT < $COUNT_NUM_CHECK) { ?>
                    <a href="#" id="right_one" onclick="" class="btn btn-dark"><i class='fas fa-angle-right' style='color:white'></i></a>
                <?php } else { ?>
                    <a href="#" onclick="" class="btn btn-dark"><i class='fas fa-angle-right' style='color:white'></i></a>
                <?php } ?>
                <a href="#" id="right_all" onclick="" class="btn btn-dark"><i class='fas fa-angle-double-right' style='color:white'></i></a>
            </div>
        </div>
    <?php } ?>
</body>

</html>
<script>
    ID_PROCESS = <?php echo $ID_PROCESS; ?>;
    COUNT_NUM_CHECK = <?php echo $COUNT_NUM_CHECK; ?>;
    LINE = <?php echo json_encode($LINE); ?>;
    PROCESS = <?php echo json_encode($PROCESS); ?>;
    MODEL = <?php echo json_encode($MODEL); ?>;
    TYPE = <?php echo json_encode($TYPE); ?>;
    DATE = <?php echo json_encode($DATE); ?>;
    DATE_SHIFT = <?php echo json_encode($DATE_SHIFT); ?>;
    SHIFT = <?php echo json_encode($SHIFT); ?>;
    $(document).ready(function() {
        $('#right_one').on('click', function() {
            ID_TEST = ID_PROCESS + 1;
            ID_SQL = ID_TEST;
            ID_CHECK = 'sub=' + ID_SQL;
            console.log(ID_SQL)

            $.get("visual_item.php?LINE=" + LINE + "&PROCESS=" + PROCESS + "&MODEL=" + MODEL + "&TYPE=" + TYPE + "&DATE_SHIFT=" + DATE_SHIFT + "&DATE=" + DATE + "&SHIFT=" + SHIFT + "&PERIOD=<?php echo $PERIOD ?>", ID_CHECK, processResponse);
            $('#testdiv,#nav-df').hide();
        })
        $('#left_one').on('click', function() {
            ID_TEST = ID_PROCESS - 1;
            ID_SQL = ID_TEST;
            ID_CHECK = 'sub=' + ID_SQL;
            console.log(ID_SQL)

            $.get("visual_item.php?LINE=" + LINE + "&PROCESS=" + PROCESS + "&MODEL=" + MODEL + "&TYPE=" + TYPE + "&DATE_SHIFT=" + DATE_SHIFT + "&DATE=" + DATE + "&SHIFT=" + SHIFT + "&PERIOD=<?php echo $PERIOD ?>", ID_CHECK, processResponse);
            $('#testdiv,#nav-df').hide();
        })
        $('#left_all').on('click', function() {
            ID_TEST = 0;
            ID_SQL = ID_TEST;
            ID_CHECK = 'sub=' + ID_SQL;
            console.log(ID_SQL)

            $.get("visual_item.php?LINE=" + LINE + "&PROCESS=" + PROCESS + "&MODEL=" + MODEL + "&TYPE=" + TYPE + "&DATE_SHIFT=" + DATE_SHIFT + "&DATE=" + DATE + "&SHIFT=" + SHIFT + "&PERIOD=<?php echo $PERIOD ?>", ID_CHECK, processResponse);
            $('#testdiv,#nav-df').hide();
        })
        $('#right_all').on('click', function() {
            ID_TEST = COUNT_NUM_CHECK;
            ID_SQL = ID_TEST;
            ID_CHECK = 'sub=' + ID_SQL;
            console.log(ID_SQL)

            $.get("visual_item.php?LINE=" + LINE + "&PROCESS=" + PROCESS + "&MODEL=" + MODEL + "&TYPE=" + TYPE + "&DATE_SHIFT=" + DATE_SHIFT + "&DATE=" + DATE + "&SHIFT=" + SHIFT + "&PERIOD=<?php echo $PERIOD ?>", ID_CHECK, processResponse);
            $('#testdiv,#nav-df').hide();
        })
    })

    function processResponse(data) {
        $('#test').html(data);
    }

    function backtoprocess() {
        history.back()
        // console.log("<?php echo $DATE_SHIFT; ?>");
        // window.location.href = 'visual_line.php?LINE=<?php echo $LINE; ?>&DATE=<?php echo $DATE; ?>
        // &SHIFT=<?php echo $SHIFT; ?>&DATE_SHIFT=<?php echo $DATE_SHIFT; ?>&BIZ=<?php echo $BIZ; ?>
        // &PERIOD=<?php echo $PERIOD ?>&CHECK_PROCESS=YES&MODEL=<?php echo $MODEL; ?>&TYPE=<?php echo $TYPE; ?>&END_DATE=<?php echo $END_DATE; ?>';

    }

    function backtohome() {
        window.location.href = 'http://43.72.52.51/startup2.0/visual.php?BIZ=IM';
    }
</script>