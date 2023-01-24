<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP CHECK</title>

    <link rel="icon" href="framework/img/logo/s_logo.png" type="image/png" sizes="16x16">
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">
    <script src="framework/js/a076d05399.js"></script>
    <link rel="stylesheet" href="framework/vendor/bootstrap/css/w3.css">

    <link rel="stylesheet" href="framework/css/jquery-ui.css">
    <script src="framework/js/jquery-1.12.4.js"></script>
    <script src="framework/js/jquery-ui.js"></script>
    <script src="framework/js/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

    <style>
        .animated {
            background-image: url(/css/images/logo.png);
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

    <?php
    require_once("connect.php");
    date_default_timezone_set("Asia/Bangkok");

    if (isset($_GET['MEMBER_ID'])) {
        $MEMBER_ID = $_GET['MEMBER_ID'];
        $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        $MEMBER_ID = $objResult['MEMBER_ID'];
        $NAME = $objResult['NAME'];
        $TYPE = $objResult['TYPE'];

        if (isset($_POST['BIZ'])) {
            $BIZ = $_POST['BIZ'];
        } else {
            $BIZ = $objResult['BIZ'];
        }
    } else {
        if (isset($_POST['MEMBER_ID'])) {
            $MEMBER_ID = $_POST['MEMBER_ID'];
            $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
            $objQuery = mysqli_query($con, $strSQL);
            $objResult = mysqli_fetch_array($objQuery);

            $MEMBER_ID = $objResult['MEMBER_ID'];
            $NAME = $objResult['NAME'];
            $TYPE = $objResult['TYPE'];

            if (isset($_POST['BIZ'])) {
                $BIZ = $_POST['BIZ'];
            } else {
                $BIZ = $objResult['BIZ'];
            }
        } else {
            header("Location: login.php");
        }
    }

    if (isset($_POST['chk'])) {
        $chk = $_POST['chk'];
    } else if (isset($_GET['ID'])) {
        $chk = $_GET['ID'];
        $ID = $_GET['ID'];
        $chk = explode(', ', $chk);
    } else {
        echo "<script>alert('กรุณาเลือกข้อมูลที่ต้องการแก้ไข');
        window.location.href = window.history.back();</script>";
    }
    ?>
</head>

<body ng-app="">
    <nav class="navbar navbar-expand-lg bg-dark shadow fixed-top">
        <a class="navbar-brand text-white" href="http://43.72.52.52/system/">SONY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <!-- <a class="nav-link text-white" href="http://43.72.52.51/startup2.0/">HOME <span class="sr-only">(current)</span></a> -->
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0">
                <a class="nav-link text-white" onclick="goBack()">BACK</a>
            </div>
        </div>
    </nav>
    <!-- Main -->
    <section id="main">
        <!-- <div class="row text-center">
            <div class="col-lg-12 mx-auto">
                <h1><b>STARTUP CHECK SYSTEM</b></h1>
                <p class="lead">Manage the data over all startup check project.</p><br><br>
            </div>
        </div> -->

        <?php
        $strSQL = "SELECT * FROM `item` WHERE ID = '$ID';";
        mysqli_set_charset($con, "utf8");
        $objQuery = mysqli_query($con, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);
        $BIZ = $objResult['BIZ'];
        $LINE = $objResult['LINE'];
        $TYPE = $objResult['TYPE'];
        $MODEL = $objResult['MODEL'];
        $PROCESS = $objResult['PROCESS'];
        $ITEM = $objResult['ITEM'];
        $SPEC_DES = $objResult['SPEC_DES'];
        $MIN = $objResult['MIN'];
        $MAX = $objResult['MAX'];
        $SPEC = $objResult['SPEC'];
        $PIC = $objResult['PIC'];
        $PERIOD = $objResult['PERIOD'];
        $LastUpdate = $objResult['LastUpdate'];
        ?>

        <div class="container">
            <div class="text-center">
                <p class="display-3 animated fadeInDown"><?php echo $LINE ?></p><br>
                <p class="lead animated fadeInDown"><?php echo $ITEM ?></p><br>
                <div class="row form-group">
                    <div class="col-4">
                        <b>[TYPE] </b><br>
                        <p class="animated fadeInUp"><?php echo $TYPE ?></p>
                    </div>
                    <div class="col-4">
                        <b>[MODEL] </b><br>
                        <p class="animated fadeInUp"><?php echo $MODEL ?></p>
                    </div>
                    <div class="col-4">
                        <b>[PROCESS] </b><br>
                        <p class="animated fadeInUp"><?php echo $PROCESS ?></p>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-4">
                        <b>[SPEC DES] </b><br>
                        <p class="animated fadeInUp"><?php echo $SPEC_DES ?></p>
                    </div>
                    <div class="col-4">
                        <b>[SPEC] </b><br>
                        <p class="animated fadeInUp"><?php echo $SPEC ?></p>
                    </div>
                    <div class="col-4">
                        <b>[PIC] </b><br>
                        <p class="animated fadeInUp"><?php echo $PIC ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <?php
            $sql = "SELECT * FROM `spec_hisory` WHERE `ID_ITEM` = '$ID' ORDER BY `LastUpdate` DESC";
            mysqli_set_charset($con, "utf8");
            $query = mysqli_query($con, $sql);
            $i = 0;
            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                $LastUpdate_his[] = $row["LastUpdate"];
                $min_his[] = $row["MIN"];
                $max_his[] = $row["MAX"];
                $reson[] = $row["RESON"];
                $by[] = $row["BY"];
                $i_arr[] = $i;
                $i++;
            }
            ?>
            <div class="row table-warning">
                <div class="col-4 text-center">
                    <br>
                    <b class=""><?php echo $LastUpdate; ?></b><br>
                    <p class="">[MIN] : <?php echo $MIN; ?> [MAX] : <?php echo $MAX ?></p>
                </div>

                <div class="col-8 table-success">
                    <br>
                    <p><?php echo $reson[0] ?></p>
                    <p>By : <?php echo $by[0] ?></p>
                </div>
            </div><br>
            <?php
            array_push($by, "EXCEL");
            array_push($reson, "Ferst One");
            foreach ($i_arr as $i) {
            ?>
                <div class="row">
                    <div class="col-4 text-center">
                        <br>
                        <b class=""><?php echo $LastUpdate_his[$i]; ?></b><br>
                        <p class="">[MIN] : <?php echo $min_his[$i]; ?> [MAX] : <?php echo $max_his[$i] ?></p>
                    </div>

                    <div class="col-8 table-secondary">
                        <br>
                        <p><?php echo $reson[$i + 1] ?></p>
                        <p>By : <?php echo $by[$i + 1] ?></p>
                    </div>
                </div><br>
            <?php } ?>
        </div>
    </section>
    <!-- Main -->

</body>

</html>

<script>
    function goBack() {
        window.history.back();
    }
</script>