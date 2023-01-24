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

    <?php
    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");

    // print_r($_GET);
    $LINE = $_GET['LINE'];
    $PROCESS = $_GET['PROCESS'];

    if ($PROCESS == 'NO DATA' or (empty($_GET['PROCESS']))) {
        header("Location: visual_line.php?LINE=$LINE");
    }

    $strSQL = "SELECT * FROM `startup_item` 
    WHERE LINE = '$LINE' AND PROCESS = '$PROCESS' 
    AND LastUpdate = (SELECT LastUpdate FROM `startup_item` WHERE LINE = '$LINE' AND PROCESS = '$PROCESS' ORDER BY LastUpdate DESC LIMIT 1) 
    ORDER BY ID ASC";
    $objQuery = mysqli_query($con, $strSQL);
    while ($objResult = mysqli_fetch_array($objQuery)) {
        $ID[] = $objResult['ID'];
        $PROCESS = $objResult['PROCESS'];
        $ITEM[] = $objResult['ITEM'];
        $SPEC_DES[] = $objResult['SPEC_DES'];
        $SPEC[] = $objResult['SPEC'];
        $VALUE1[] = $objResult['VALUE1'];
        $VALUE2[] = $objResult['VALUE2'];
        $JUDGEMENT[] = $objResult['JUDGEMENT'];
    }
    ?>

</head>

<body>


    <div class="row text-center">
        <div class="col-lg-12 mx-auto">
            <img src="" width="15%"><br><br>
            <h1><b>SMART STARTUP CHECK</b></h1>
            <h3><?php echo $PROCESS; ?></h3>
            <br><br>

            <div class="container">
                <table class="table table-striped table-bordered thead-light">
                    <div style="overflow-x:auto;">
                        <thead class="thead-dark text-black">
                            <tr>
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
                                    $SHOW_VALUE1 = '  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter' . $i . '">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>WATCH
                                                </button>';
                                } else {
                                    $SHOW_VALUE1 = $VALUE1[$i];
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
                                <tr class="table-<?php echo $STATUS; ?> ">
                                    <td align="left"><?php echo $ITEM[$i]; ?></td>
                                    <td align="left"><?php echo $SPEC_DES[$i]; ?></td>
                                    <td align="left"><?php echo $SHOW_VALUE1; ?></td>
                                    <td align="left"><?php echo $VALUE2[$i]; ?></td>
                                </tr>


                            <?php
                                $i++;
                            }
                            ?>
                    </div>
                </table>
            </div>
            <!-- 
            <div class="container">
                <table class="table table-striped table-bordered thead-light">
                    <div style="overflow-x:auto;">
                        <thead class="thead-dark text-black">
                            <tr>
                                <th>ITEM</th>
                                <th>SPEC</th>
                                <th class="text-center" colspan="2">VALUE</th>
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
                            ?>
                                <tr class="<?php echo $STATUS; ?> text-left">
                                    <td align="left"><?php echo $ITEM[$i]; ?></td>
                                    <td align="left"><?php echo $SPEC_DES[$i]; ?></td>
                                    <td width="15%" align="left"><?php echo $VALUE1[$i]; ?></td>
                                    <td width="15%" align="left"><?php echo $VALUE2[$i]; ?></td>
                                </tr>
                            <?php
                                $i++;
                            }
                            ?>
                    </div>
                </table>
            </div> -->

        </div>
    </div>

</body>

</html>