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

    <link rel="stylesheet" href="framework/css/jquery-ui.css">
    <script src="framework/js/jquery-1.12.4.js"></script>
    <script src="framework/js/jquery-ui.js"></script>


    <style>
        input[type=text], input[type=password] 
        {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        } 
        input[type=button], input[type=submit] 
        {
          width: 40%;
          height: 60%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        }
    </style>

</head>
<body>

    <!-- Main -->
    <section id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>STARTUP CHECK SYSTEM</b></h1>
                    <p class="lead">Manage the data over all startup check project.</p><br><br>
                </div>
            </div>

            <div class="col-lg-12 mx-auto text-center">
                <div class="row">
                    <table class="table">
                        <thead class="thead thead-dark">
                            <tr>
                                <th>COUNTRY</th>
                                <th>FACTORY</th>
                                <th>BIZ</th>
                            </tr>
                        </thead>
                        <!-- QUERY BIZ -->
                            <?php

                            require_once("connect.php");
                            date_default_timezone_set("Asia/Bangkok");

                            $ID=$_GET['ID'];

                            $strSQL = "SELECT * FROM `biz` WHERE ID='$ID';";
                            $objQuery = mysqli_query($con,$strSQL);
                            while($objResult = mysqli_fetch_array($objQuery))
                            {
                            $ID = $objResult['ID'];
                            $COUNTRY = $objResult['COUNTRY'];
                            $FACTORY = $objResult['FACTORY'];
                            $BIZ = $objResult['BIZ'];
                            ?>
                    <form method="GET" action="biz_save.php">
                        <tbody>
                            <tr>
                                <td><input name="COUNTRY" type="text" value="<?php echo $COUNTRY;?>"></td>
                                <td><input name="FACTORY" type="text" value="<?php echo $FACTORY;?>"></td>
                                <td><input name="BIZ" type="text" value="<?php echo $BIZ;?>"></td>
                            </tr>
                        </tbody>
                            <?php
                            }
                            ?>
                    </table>
                </div>
                        <input name="ID" type="hidden" value="<?php echo $ID;?>">
                        <input name="MEMBER_ID" type="hidden" value="<?php echo $_GET['MEMBER_ID'];?>">
                        <button class="btn btn-dark" type="submit">ENTER</button>
                    </form>

            </div>
        </div>
    </section>
    <!-- Main -->

</body>

</html>