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
    <link rel="stylesheet" href="framework/css/w3.css">

    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>


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

    <?php
        require_once("connect.php");
        date_default_timezone_set("Asia/Bangkok");

        $MEMBER_ID=$_GET['MEMBER_ID'];

        if(isset($_GET['MEMBER_ID']))
        {
            $MEMBER_ID = $_GET['MEMBER_ID'];
            $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
            $objQuery = mysqli_query($con,$strSQL);
            $objResult = mysqli_fetch_array($objQuery);
                
            $MEMBER_ID=$objResult['MEMBER_ID'];
            $NAME=$objResult['NAME'];
            $TYPE=$objResult['TYPE'];

            if(isset($_POST['BIZ'])){
                $BIZ = $_POST['BIZ'];
            }
            else{
                $BIZ=$objResult['BIZ'];
            }
        }
        else
        {
            header("Location: login.php");
        }
    ?>
    
</head>
<body>

    <!-- Main -->
    <section id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b><a href="manage_ADMIN.php?MEMBER_ID=<?php echo $MEMBER_ID;?>" class="text-dark">STARTUP CHECK SYSTEM</a></b></h1>
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
                                <th>TOOLS  <a href="biz_add.php" class="btn btn-dark"><i class='fas fa-plus' style='color:white'></i></a><br></th>
                            </tr>
                        </thead>
                        <!-- QUERY BIZ -->
                            <?php

                            require_once("connect.php");
                            date_default_timezone_set("Asia/Bangkok");

                            $strSQL = "SELECT * FROM `biz`;";
                            $objQuery = mysqli_query($con,$strSQL);
                            while($objResult = mysqli_fetch_array($objQuery))
                            {
                            $ID = $objResult['ID'];
                            $COUNTRY = $objResult['COUNTRY'];
                            $FACTORY = $objResult['FACTORY'];
                            $BIZ = $objResult['BIZ'];
                            ?>
                        <tbody>
                            <tr>
                                <td><?php echo $COUNTRY;?></td>
                                <td><?php echo $FACTORY;?></td>
                                <td><?php echo $BIZ;?></td>
                                <td>
                                    <a href="biz_edit.php?MEMBER_ID=<?php echo $_GET['MEMBER_ID'];?>&&ID=<?php echo $ID;?>" class="btn btn-primary"><i class='fas fa-edit' style='color:white'></i></a>
                                    <a href="biz_delete.php?MEMBER_ID=<?php echo $_GET['MEMBER_ID'];?>&&ID=<?php echo $ID;?>" class="btn btn-danger"><i class='fas fa-trash' style='color:white'></i></a>
                                </td>
                            </tr>
                        </tbody>
                            <?php
                            }
                            ?>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Main -->

</body>

</html>
