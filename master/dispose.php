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
    if (empty($_POST)) {
        header("Location: index.php");
    } else {
        $LINE = $_POST['LINE'];
        $MODEL = $_POST['MODEL'];
        $SHIFT = $_POST['SHIFT'];
        $TYPE = $_POST['TYPE'];
        $SHIF_DATE = $_POST['DATE_SHIFT'];
        $DATE = $_POST['DATE'];
        if (isset($_POST['PERIOD'])) {
            $PERIOD = $_POST['PERIOD'];
        } else {
            $PERIOD = 'SHIFT';
        }
    }
    ?>

    <script>
        alert("Please re-check before dispose \nกรุณาตวรจสอบข้อมูลก่อนลบ");
    </script>

</head>

<body>

    <form action="dispose_record.php" method="POST" onsubmit="return check()">
        <section id="login">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-12 mx-auto">
                        <h1><b>SMART STARTUP CHECK</b></h1>
                        <p>CONFIRM TO DISPOSE YOUR STARTUP</p><br><br>

                        LINE : <b><?php echo $LINE; ?></b> / MODEL : <b><?php echo $MODEL; ?></b> / TYPE : <b><?php echo $TYPE; ?></b><br>
                        SHIF_DATE : <b><?php echo $SHIF_DATE; ?></b> SHIF :<b><?php echo $SHIFT; ?></b><br><br>

                        <br>
                        <input type="hidden" name="LINE" placeholder="LINE" value="<?php echo $LINE; ?>">
                        <input type="hidden" name="TYPE" placeholder="TYPE" value="<?php echo $TYPE; ?>">
                        <input type="hidden" name="SHIFT" placeholder="SHIFT" value="<?php echo $SHIFT; ?>">
                        <input type="hidden" name="MODEL" placeholder="MODEL" value="<?php echo $MODEL; ?>">
                        <input type="hidden" name="DATE_SHIFT" placeholder="DATE_SHIFT" value="<?php echo $SHIF_DATE; ?>"><br>
                        <input type="hidden" name="DATE" placeholder="DATE" value="<?php echo $DATE; ?>"><br>
                        <input type="hidden" name="PERIOD" value="<?php echo $PERIOD ?>" placeholder="PERIOD">
                        <input type="password" name="RFID" placeholder="RFID" id="RFID" autofocus>
                        <br><br><br><br>
                    </div>
                    <div class="col-lg-6 mx-auto">
                        <button type="submit" class="btn btn-danger"><i class="fa fa-times"></i> DISPOSE</button>
                    </div>
                </div>
            </div>
        </section>
    </form>

</body>

</html>