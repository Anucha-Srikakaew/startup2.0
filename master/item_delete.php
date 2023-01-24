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

    <?php
        require_once("connect.php");
        date_default_timezone_set("Asia/Bangkok");

        if(isset($_GET['MEMBER_ID']))
        {
            $MEMBER_ID=$_GET['MEMBER_ID'];
            $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
            mysqli_set_charset($con, "utf8");
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
            if(isset($_POST['MEMBER_ID']))
            {
                $MEMBER_ID=$_POST['MEMBER_ID'];
                $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
                mysqli_set_charset($con, "utf8");
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
        }

        if(isset($_POST['chk'])){
            $chk = $_POST['chk'];}
            else if(isset($_GET['ID'])){
            $chk = $_GET['ID'];
            $chk = explode(', ', $chk);}
            else{ echo "<script>alert('กรุณาเลือกข้อมูลที่ต้องการลบ');
            window.location.href = window.history.back();</script>";}
    ?>

    
    <script>
        // CONFIRM FORM
            function ConfirmForm()
                {
                    var r = confirm("คุณต้องการลบข้อมูลนี้ใช่ไหม");

                    if (r == true) {
                        document.form.submit();
                    } else {
                        return false;
                    }
                }
    </script>

</head>
<body ng-app="">
    <!-- Main -->
    <section id="main">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>STARTUP CHECK SYSTEM</b></h1>
                    <p class="lead">Manage the data over all startup check project.</p><br><br>
                </div>
            </div>

            <div class="col-lg-12 mx-auto text-center">
                <div class="container">
                    <div class="row">
                        <table class="table">
                            <thead class="thead thead-dark">
                                <tr>
                                    <th>LINE</th>
                                    <th>TYPE</th>
                                    <th>MODEL</th>
                                    <th>PROCESS</th>
                                    <th>ITEM</th>
                                    <th>MIN</th>
                                    <th>MAX</th>
                                    <th>SPEC</th>
                                    <th>PIC</th>
                                    <th>PERIOD</th>
                                </tr>
                            </thead>
                            <!-- QUERY BIZ -->
                                <?php

                                require_once("connect.php");
                                date_default_timezone_set("Asia/Bangkok");

                                foreach ($chk as &$ID) 
                                {
                                    $strSQL = "SELECT * FROM `item` WHERE ID = '$ID';";
                                    mysqli_set_charset($con, "utf8");
                                    $objQuery = mysqli_query($con,$strSQL);
                                    while($objResult = mysqli_fetch_array($objQuery))
                                    {

                                    $ID = $objResult['ID'];
                                    $BIZ = $objResult['BIZ'];
                                    $LINE = $objResult['LINE'];
                                    $TYPE = $objResult['TYPE'];
                                    $MODEL = $objResult['MODEL'];
                                    $PROCESS = $objResult['PROCESS'];
                                    $ITEM = $objResult['ITEM'];
                                    $MIN = $objResult['MIN'];
                                    $MAX = $objResult['MAX'];
                                    $SPEC = $objResult['SPEC'];
                                    $PIC = $objResult['PIC'];
                                    $PERIOD = $objResult['PERIOD'];
                                ?>
                        <form method="POST" action="item_save.php?Action=Delete">
                            <tbody>
                                <tr>
                                    <input name="MEMBER_ID" type="hidden" value="<?php echo $MEMBER_ID;?>">
                                    <input name="ID[]" type="hidden" value="<?php echo $ID;?>">

                                    <td><?php echo $ID;?></td>
                                    <td><?php echo $TYPE;?></td>
                                    <td><?php echo $MODEL;?></td>
                                    <td><?php echo $PROCESS;?></td>
                                    <td><?php echo $ITEM;?></td>
                                    <td><?php echo $MIN;?></td>
                                    <td><?php echo $MAX;?></td>
                                    <td><?php echo $SPEC;?></td>                 
                                    <td><?php echo $PIC;?></td>
                                    <td><?php echo $PERIOD;?></td>
                                </tr>
                            </tbody>
                                <?php
                                    }
                                }
                                ?>
                        </table>
                    </div>
                        <a href="javascript:history.back()" class="btn btn-dark"><i class='fas fa-arrow-left' style='color:white'></i> BACK</a>
                        <button class="btn btn-danger" onClick="ConfirmForm();return false;"><i class='fas fa-trash' style='color:white'></i> DELETE</button>
                    </form>
                </div>
            </div>
    </section>
    <!-- Main -->

</body>

</html>