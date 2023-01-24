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
        else{ header("Location: ". $_SERVER['HTTP_REFERER']);}
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

            console.log(model);

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
                    var txtMODEL = document.getElementById("txtMODEL");
                    var txtITEM = document.getElementById("txtITEM");

                    console.log(txtMODEL.value);
                    console.log(txtITEM.value);

                    if(txtMODEL.value!="")
                    {
                        var MODEL = document.getElementsByName("MODEL");
                        MODEL.forEach((num, index) => {
                        MODEL[index].value = txtMODEL.value;
                        });
                    }

                    if(txtITEM.value!="")
                    {
                        var ITEM = document.getElementsByName("ITEM");
                        ITEM.forEach((num, index) => {
                        ITEM[index].value = txtITEM.value;
                        });
                    }
                }
    </script>

<script>

</script>

</head>
<body>
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
                        

<input type="text" placeholder="MODEL" name="txtMODEL" id="txtMODEL">
<input type="text" placeholder="ITEM" name="txtITEM" id="txtITEM">
<input type="button" value="COPY" onClick="copy();" />
<input type="button" value="RESET" onClick="window.location.reload()">



                        <table class="table">
                            <thead class="thead thead-dark">
                                <tr>
                                    <th><input type="checkbox" onclick="toggle(this);"></th>
                                    <th>LINE</th>
                                    <th>TYPE</th>
                                    <th>MODEL</th>
                                    <th>PROCESS</th>
                                    <th class="col-lg-12">ITEM</th>
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

                                foreach ($chk as &$ID) {
                                $strSQL = "SELECT * FROM `item` WHERE ID = '$ID';";
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
                        <form method="GET" action="item_save.php">
                            <tbody>
                                <tr>
                                    <input name="BIZ" type="hidden" value="<?php echo $BIZ;?>">

                                    <td>
                                        <input type="checkbox" name="check" id="check">
                                    </td>

                                    <td>
                                        <!-- SELECT LINE -->
                                            <select name="LINE" id="LINE">
                                                    <?php
                                                        if($TYPE=='ADMIN')
                                                        {
                                                            $BIZ = $_POST['BIZ'];
                                                            require_once("connectMSSQL152.php");
                                                            $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                                            $query = sqlsrv_query($conMSSQL152, $stmt);

                                                            echo "<option disabled selected value='$LINE'>$LINE</option>";

                                                            while($result = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC))
                                                            {
                                                                $LINE_NAME = $result['LINE_NAME'];
                                                                echo "<option value=".$LINE_NAME.">$LINE_NAME</option>";
                                                            }
                                                            require_once("connectMSSQL170.php");
                                                            $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                                            $query = sqlsrv_query($conMSSQL170, $stmt);

                                                            while($result = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC))
                                                            {
                                                                $LINE_NAME = $result['LINE_NAME'];
                                                                echo "<option value=".$LINE_NAME.">$LINE_NAME</option>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if(($BIZ=='AC') OR ($BIZ=='LINE_FIT'))
                                                                {
                                                                    require_once("connectMSSQL152.php");
                                                                    $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                                                    $query = sqlsrv_query($conMSSQL152, $stmt);

                                                                    echo "<option disabled selected value='$LINE'>$LINE</option>";

                                                                    while($result = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC))
                                                                    {
                                                                        $LINE_NAME = $result['LINE_NAME'];
                                                                        echo "<option value=".$LINE_NAME.">$LINE_NAME</option>";
                                                                    }
                                                                }
                                                            else if($BIZ=='AU')
                                                                {
                                                                    require_once("connectMSSQL170.php");
                                                                    $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                                                    $query = sqlsrv_query($conMSSQL170, $stmt);

                                                                    echo "<option disabled selected value='$LINE'>$LINE</option>";

                                                                    while($result = sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC))
                                                                    {
                                                                        $LINE_NAME = $result['LINE_NAME'];
                                                                        echo "<option value=".$LINE_NAME.">$LINE_NAME</option>";
                                                                    }
                                                                }
                                                        }
                                                    ?>
                                                </select>

                                                <script type="text/javascript">
                                                    document.getElementById('LINE').value = "<?php echo $_POST['LINE'];?>";
                                                </script>
                                    </td>

                                    <td>
                                        <!-- SELECT LINE TYPE -->
                                            <select name="TYPE" id="TYPE">
                                                    <?php
                                                        if($TYPE=='ADMIN')
                                                        {
                                                            echo "<option disabled selected value='$TYPE'>$TYPE</option>";

                                                            $strSQL = "SELECT DISTINCT TYPE FROM `line_type` WHERE BIZ LIKE '%$BIZ%';";
                                                            $objQuery = mysqli_query($con,$strSQL);
                                                            while($objResult = mysqli_fetch_array($objQuery))
                                                            {
                                                                $TYPE = $objResult['TYPE'];
                                                                echo "<option value=".$TYPE.">".$TYPE."</option>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "<option disabled selected value='$TYPE'>$TYPE</option>";
                                                            
                                                            $strSQL = "SELECT TYPE FROM `line_type` WHERE BIZ LIKE '%$BIZ%';";
                                                            $objQuery = mysqli_query($con,$strSQL);
                                                            while($objResult = mysqli_fetch_array($objQuery))
                                                            {
                                                                $TYPE = $objResult['TYPE'];
                                                                echo "<option value=".$TYPE.">".$TYPE."</option>";
                                                            }
                                                        }
                                                    ?>
                                                </select>

                                                <script type="text/javascript">
                                                    document.getElementById('TYPE').value = "<?php echo $_POST['TYPE'];?>";
                                                </script>
                                    </td>

                                    <td>
                                        <!-- INPUT MODEL -->
                                            <input id="MODEL" name="MODEL"  type="text" class="text" oninput="this.value = this.value.toUpperCase()" value="<?php echo $MODEL;?>">

                                            <script type="text/javascript">
                                                document.getElementById('MODEL').value = "<?php echo $_POST['MODEL'];?>";
                                            </script>
                                    </td>

                                    <td>
                                        <!-- INPUT PROCESS -->
                                            <input name="PROCESS" type="" value="<?php echo $PROCESS;?>">
                                    </td>

                                    <td>
                                        <input class="col-lg-12" name="ITEM" type="" value="<?php echo $ITEM;?>">
                                    </td>

                                    <td>
                                        <input name="MIN" type="number" value="<?php echo $MIN;?>">
                                    </td>

                                    <td>
                                        <input name="MAX" type="number" value="<?php echo $MAX;?>">
                                    </td>

                                    <td>
                                        <input name="SPEC" type="" value="<?php echo $SPEC;?>">
                                    </td>

                                    <td>
                                        <select id="PIC" name="PIC">
                                            <option disabled selected value='<?php echo $PIC;?>'><?php echo $PIC;?></option>";
                                            <option value="MFE">MFE</option>
                                            <option value="PROD">PROD</option>
                                        </select>
                                    </td>

                                    <td>
                                        <select id="PERIOD" name="PERIOD">
                                            <option disabled selected value='<?php echo $PERIOD;?>'><?php echo $PERIOD;?></option>";
                                            <option value="SHIFT">SHIFT</option>
                                            <option value="DAY">DAY</option>
                                            <option value="WEEK">WEEK</option>
                                            <option value="MONTH">MONTH</option>
                                            <option value="YEAR">YEAR</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                                <?php
                                }
                                }
                                ?>
                        </table>
                    </div>
                        <input name="ID" type="hidden" value="<?php echo $ID;?>">
                        <button class="btn btn-dark" type="submit">ENTER</button>
                    </form>

            </div>
    </section>
    <!-- Main -->

</body>

</html>
