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
    if (empty($_POST) or $_POST == '') {
        header("Location: index.php");
    } else {
        $CONFIRM_DATA = $_POST;
        // print_r($_POST);
        $LINE = $CONFIRM_DATA['LINE'];
        if (isset($_POST['LINE_TYPE'])) {
            $LINE_TYPE = $_POST['LINE_TYPE'];
        } else {
            $LINE_TYPE = $_POST['LINE_TYPE3'];
        }
        $SHIFT = $CONFIRM_DATA['SHIFT'];
        $DATE = $CONFIRM_DATA['DATE'];
        $MODEL = $CONFIRM_DATA['MODEL'];
        $DATE_SHIFT = $CONFIRM_DATA['DATE_SHIFT'];
        $CONFIRM = $CONFIRM_DATA['CONFIRM'];

        if (isset($CONFIRM_DATA["PERIOD"])) {
            $PERIOD = $CONFIRM_DATA["PERIOD"];
        } else {
            $PERIOD = 'SHIFT';
        }
    }
    ?>

</head>

<body>

    <form action="confirm_record.php" method="POST">
        <section id="login">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-12 mx-auto">
                        <h1><b>SMART STARTUP CHECK</b></h1>
                        <p>CONFIRM TO STARTUP PRODUCTION LINE</p><br><br>
                        <input type="hidden" name="LINE" value="<?php echo $LINE; ?>">
                        <input type="hidden" name="LINE_TYPE" value="<?php echo $LINE_TYPE; ?>">
                        <input type="hidden" name="SHIFT" value="<?php echo $SHIFT; ?>">
                        <input type="hidden" name="DATE" value="<?php echo $DATE; ?>">
                        <input type="hidden" name="MODEL" value="<?php echo $MODEL; ?>">
                        <input type="hidden" name="DATE_SHIFT" value="<?php echo $DATE_SHIFT; ?>">
                        <input type="hidden" name="CONFIRM" value="<?php echo $CONFIRM; ?>">
                        <input type="hidden" name="PERIOD" value="<?php echo $PERIOD; ?>">
                        <input type="password" name="RFID" id="RFID" autofocus>
                        <br><br><br><br>
                    </div>
                    <div class="col-lg-6 mx-auto">
                        <button type="submit" class="btn btn-success">CONFIRM</button>
                    </div>
                </div>
            </div>
        </section>
    </form>

</body>

</html>