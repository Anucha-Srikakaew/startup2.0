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
        else{ echo "<script>alert('กรุณาเลือกข้อมูลที่ต้องการแก้ไข');
        window.location.href = window.history.back();</script>";}
    ?>

    
    <script>
        // get model by biz
            var url = "c_model.php?BIZ=<?php echo $BIZ;?>";
            var jsonData = $.ajax({
                url: url,
                dataType: "json",
                async: false
                }).responseText;

            jsonString = jsonData.replace("\\","");
            var model = JSON.parse(jsonString);

            // console.log(model);

            $( function() {
                $( "#MODEL" ).autocomplete({
                source: model
                });
            } );
            $( function() {
                $( "#txtMODEL" ).autocomplete({
                source: model
                });
            } );

        // CHECK ALL
            function toggle(source) {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i] != source)
                        checkboxes[i].checked = source.checked;
                }
            }
            
        // SYNC DATA
            function copy()
                {
                    var txtTYPE = document.getElementById("txtTYPE");
                    var txtSHIFT = document.getElementById("txtSHIFT");


                    console.log(txtTYPE);

                        if(txtTYPE.value!="")
                        {
                            var TYPE = document.getElementsByName("TYPE[]");
                            TYPE.forEach((num, index) => {
                            TYPE[index].value = txtTYPE.value;
                            });
                        }

                        if(txtSHIFT.value!="")
                        {
                            var SHIFT = document.getElementsByName("SHIFT[]");
                            SHIFT.forEach((num, index) => {
                            SHIFT[index].value = txtSHIFT.value;
                            });
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
                    <div class="row">

            <form>
                <select ng-model="myVar">
                    <option option disabled value>SELECT INPUT
                    <option value="TYPE">TYPE
                    <option value="SHIFT">SHIFT
                </select>
            </form>

            <div ng-switch="myVar">
                <div ng-switch-when="TYPE">
                    <select name="txtTYPE" id="txtTYPE">
                        <?php
                            echo "<option disabled selected value>TYPE</option>";

                            $strSQL = "SELECT DISTINCT TYPE FROM `member` WHERE BIZ LIKE '%$BIZ%' AND TYPE <> 'ADMIN';";
                            $objQuery = mysqli_query($con,$strSQL);
                            while($objResult = mysqli_fetch_array($objQuery))
                            {
                                $TYPE = $objResult['TYPE'];
                                echo "<option value=".$TYPE.">".$TYPE."</option>";
                            }
                        ?>
                    </select>
                    <input type="hidden" name="txtSHIFT" id="txtSHIFT">
                </div>

                <div ng-switch-when="SHIFT">
                    <select name="txtSHIFT" id="txtSHIFT">
                        <option disabled selected value>SHIFT</option>
                        <option value="ALL">ALL</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                    <input type="hidden" name="txtTYPE" id="txtTYPE">
                </div>


            </div>
<input type="button" value="COPY" onClick="copy();" />
<input type="button" value="RESET" onClick="window.location.reload()">
                        <table class="table">
                            <thead class="thead thead-dark">
                                <tr>
                                    <th>MEMBER_ID</th>
                                    <th>NAME</th>
                                    <th>PASSWORD</th>
                                    <th>TYPE</th>
                                    <th>SHIFT</th>
                                    <th>LINE</th>
                                </tr>
                            </thead>
                            <!-- QUERY BIZ -->
                                <?php

                                require_once("connect.php");
                                date_default_timezone_set("Asia/Bangkok");

                                foreach ($chk as &$ID) 
                                {
                                $strSQL = "SELECT * FROM `member` WHERE ID = '$ID';";
                                $objQuery = mysqli_query($con,$strSQL);
                                while($objResult = mysqli_fetch_array($objQuery))
                                {

                                    $ID = $objResult['ID'];
                                    $M_ID = $objResult['MEMBER_ID'];
                                    $NAME = $objResult['NAME'];
                                    $PASSWORD = $objResult['PASSWORD'];
                                    $TYPE = $objResult['TYPE'];
                                    $SHIFT = $objResult['SHIFT'];
                                    $LINE = $objResult['LINE'];

                                ?>
                        <form method="POST" action="member_save.php?Action=Edit">
                            <tbody>
                                <tr>
                                    <input name="MEMBER_ID" type="hidden" value="<?php echo $MEMBER_ID;?>">
                                    <td>
                                        <input name="M_ID[]" value="<?php echo $M_ID;?>">
                                    </td>
                                    <td>
                                        <input name="NAME[]" value="<?php echo $NAME;?>">
                                    </td>
                                    <td>
                                        <input name="PASSWORD[]" type="text" value="<?php echo $PASSWORD;?>">
                                    </td>
                                    <td>
                                        <select name="TYPE[]" id="TYPE">
                                            <?php
                                                echo '<option disable value='.$TYPE.'>'.$TYPE.'</option>';

                                                $strSQL = "SELECT DISTINCT TYPE FROM `member` WHERE BIZ LIKE '%$BIZ%' AND TYPE <> 'ADMIN';";
                                                $objQuery = mysqli_query($con,$strSQL);
                                                while($objResult = mysqli_fetch_array($objQuery))
                                                {
                                                    $TYPE = $objResult['TYPE'];
                                                    echo "<option value=".$TYPE.">".$TYPE."</option>";
                                                }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="SHIFT[]" id="SHIFT">
                                            <option disable value="<?php echo $SHIFT;?>"><?php echo $SHIFT;?></option>
                                            <option value="ALL">ALL</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                        </select>
                                    </td>
                                    <td>
                                    <input name="LINE[]" value="<?php echo $LINE;?>" readonly="readonly">
                                    </td>
                                </tr>
                            </tbody>
                                <?php
                                }
                                echo '<input name="ID[]" type="hidden" value="'.$ID.'">';
                                }
                                ?>
                        </table>
                    </div>
                        <button class="btn btn-dark" type="submit">EDIT</button>
                    </form>

            </div>
    </section>
    <!-- Main -->

</body>

</html>
