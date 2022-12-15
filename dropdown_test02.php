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

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

    <style>
        input[type=text], input[type=password],select
        {
          width: 100%;
          padding: 3px 5px;
          margin: 2px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        } 
        input[type=button], input[type=submit], button[type=submit] 
        {
          width: 40%;
          height: 60%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        }
        input[type=number]
        {
          width: 49%;
          padding: 3px 5px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        }
    </style>

    <!-- CHECK LOGIN -->
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

        // check empty
            function fncSubmit()
                {
                    if(document.form.BIZ.value == "")
                    {
                    alert('Please fill BIZ.');
                    document.form.BIZ.focus();
                    return false;
                    } 
                    if(document.form.LINE.value == "")
                    {
                    alert('Please select LINE NAME.');
                    document.form.LINE.focus();
                    return false;
                    } 
                    if(document.form.MODEL.value == "")
                    {
                    alert('Please fill MODEL.');
                    document.form.MODEL.focus();
                    return false;
                    } 
                    if(document.form.PROCESS.value == "")
                    {
                    alert('Please fill PROCESS.');
                    document.form.PROCESS.focus();
                    return false;
                    } 
                    if(document.form.ITEM.value == "")
                    {
                    alert('Please fill ITEM.');
                    document.form.ITEM.focus();
                    return false;
                    } 
                    if(document.form.TYPE.value == "")
                    {
                    alert('Please fill LINE TYPE.');
                    document.form.TYPE.focus();
                    return false;
                    } 
                    if(document.form.SPEC.value == "")
                    {
                    alert('Please select SPEC information.');
                    document.form.SPEC.focus();
                    return false;
                    } 
                    if(document.form.SPEC.value != "")
                    {
                        if(document.form.SPEC.value == "DROPDOWN")
                        {
                            if(document.form.DROPDOWN_NAME.value == "")
                            {
                            alert('Please select DROPDOWN');
                            document.form.DROPDOWN_NAME.focus();
                            return false;
                            } 
                        } 
                        if(document.form.SPEC.value == "VALUE")
                        {
                            if(document.form.MIN.value == "")
                            {
                            alert('Please fill MIN value');
                            document.form.MIN.focus();
                            return false;
                            } 
                            if(document.form.MAX.value == "")
                            {
                            alert('Please fill MAXvalue');
                            document.form.MAX.focus();
                            return false;
                            } 
                        } 
                    } 
                    if(document.form.PIC.value == "")
                    {
                    alert('Please select PIC for this item.');
                    document.form.PIC.focus();
                    return false;
                    } 
                    document.form.submit();
                }
    </script>

</head>
<body ng-app="">

    <!-- Main -->
    <section id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>STARTUP CHECK SYSTEM</b></h1>
                    <p class="lead">Manage the data over all startup check project.</p><br><br>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-lg-8 mx-auto">
                <form name="form" method="POST" action="item_save.php" onSubmit="JavaScript:return fncSubmit();">

                                        <!-- MEMBER ID -->
                                            <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID;?>">

                                        <!-- SELECT BIZ -->
                                            <select name="BIZ" id="BIZ" onchange="this.form.submit()">
                                                <?php
                                                    if($TYPE=='ADMIN')
                                                    {
                                                        echo "<option disabled selected value>BIZ</option>";

                                                        $strSQL = "SELECT DISTINCT BIZ FROM `biz`;";
                                                        $objQuery = mysqli_query($con,$strSQL);
                                                        while($objResult = mysqli_fetch_array($objQuery))
                                                        {
                                                            $BIZ = $objResult['BIZ'];
                                                            echo "<option value=".$BIZ.">".$BIZ."</option>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo "<option disabled selected value=".$BIZ.">$BIZ</option>";
                                                    }
                                                ?>
                                            </select>

                                            <script type="text/javascript">
                                                document.getElementById('BIZ').value = "<?php echo $_POST['BIZ'];?>";
                                            </script>

                                        <!-- SELECT LINE -->
                                            <select name="LINE" id="LINE">
                                                <?php
                                                    if($TYPE=='ADMIN')
                                                    {
                                                        $BIZ = $_POST['BIZ'];
                                                        require_once("connectMSSQL152.php");
                                                        $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                                        $query = sqlsrv_query($conMSSQL152, $stmt);

                                                        echo "<option disabled selected value>LINE</option>";

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

                                                                echo "<option disabled selected value>LINE</option>";

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

                                                                echo "<option disabled selected value>LINE</option>";

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

                                        <!-- INPUT MODEL -->
                                            <input id="MODEL" name="MODEL"  type="text" class="text" placeholder="MODEL" oninput="this.value = this.value.toUpperCase()">

                                            <script type="text/javascript">
                                                document.getElementById('MODEL').value = "<?php echo $_POST['MODEL'];?>";
                                            </script>

                                        <!-- INPUT PROCESS  -->
                                            <input id="PROCESS"  name="PROCESS"  type="text" class="text" placeholder="PROCESS"  oninput="this.value = this.value.toUpperCase()">

                                            <script type="text/javascript">
                                                document.getElementById('PROCESS').value = "<?php echo $_POST['PROCESS'];?>";
                                            </script>

                                            <input id="ITEM"  name="ITEM"  type="text" class="text" placeholder="ITEM (สามารถใส่ภาษาไทยได้)"  oninput="this.value = this.value.toUpperCase()">

                                            <script type="text/javascript">
                                                document.getElementById('ITEM').value = "<?php echo $_POST['ITEM'];?>";
                                            </script>
                                            
                                        <!-- SELECT LINE TYPE -->
                                            <select name="TYPE" id="TYPE">
                                                    <?php
                                                        if($TYPE=='ADMIN')
                                                        {
                                                            echo "<option disabled selected value>TYPE</option>";

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
                                                            echo "<option disabled selected value>TYPE</option>";
                                                            
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

                                        <!-- SELECT SPEC -->
                                            <select name="SPEC" id="SPEC" onSubmit="JavaScript:return fncSubmit();" ng-model="SPEC">
                                                <?php
                                                        echo "<option disabled selected value=''>SPEC</option>";
                                                        
                                                        $strSQL = "SELECT DISTINCT SPEC FROM `SPEC` WHERE BIZ = '$BIZ'";
                                                        $objQuery = mysqli_query($con,$strSQL);
                                                        while($objResult = mysqli_fetch_array($objQuery))
                                                        {
                                                            $SPEC = $objResult['SPEC'];
                                                            echo "<option value=".$SPEC.">".$SPEC."</option>";
                                                        }
                                                ?>
                                            </select>

                                            <!-- INPUT SPEC VALUE  -->
                                                <div ng-switch="SPEC">
                                                    <div ng-switch-when="VALUE">
                                                                <input id="MIN"  name="MIN"  type="NUMBER" class="text" placeholder="MIN">
                                                                <input id="MAX"  name="MAX"  type="NUMBER" class="text" placeholder="MAX">

                                                                <script type="text/javascript">
                                                                    document.getElementById('MIN').value = "<?php echo $_POST['MIN'];?>";
                                                                    document.getElementById('MAX').value = "<?php echo $_POST['MAX'];?>";
                                                                </script>
                                                        </thead>
                                                    </div>

                                            <!-- INPUT SPEC DROPDOWN -->
                                                    <div ng-switch-when="DROPDOWN">
                                                        <select name="DROPDOWN_NAME" id="DROPDOWN_NAME">
                                                            <?php
                                                                    echo "<option disabled selected value=''>DROPDOWN_NAME</option>";

                                                                    $strSQL = "SELECT DISTINCT DROPDOWN_NAME,ID FROM `dropdown` WHERE BIZ LIKE '%$BIZ%' GROUP BY DROPDOWN_NAME";
                                                                    $objQuery = mysqli_query($con,$strSQL);
                                                                    while($objResult = mysqli_fetch_array($objQuery))
                                                                    {
                                                                        $DROPDOWN_NAME = $objResult['DROPDOWN_NAME'];
                                                                        $DROPDOWN_ID = $objResult['ID'];
                                                                        echo "<option value=".$DROPDOWN_ID.">".$DROPDOWN_NAME."</option>";
                                                                    }
                                                            ?>
                                                        </select>
                                                            <a target="_blank" rel="noopener noreferrer" href="http://43.72.52.52/startup2.0/AC/dropdown_create.php?BIZ=<?php echo $BIZ;?>">
                                                            <button type="button" name="add" id="add" class="btn btn-dark btn-sm" style="float: right;"><i class="fa fa-plus"></i> CREATE NEW DROPDOWN</button>
                                                        </a>
                                                        <script type="text/javascript">
                                                            document.getElementById('DROPDOWN_NAME').value = "<?php echo $_POST['DROPDOWN_NAME'];?>";
                                                        </script>
                                                    </div>
                                                </div>

                                        <!-- SELECT PIC -->
                                            <select name="PIC" id="PIC" onchange="this.form.submit()">
                                                <option disabled selected value=''>PIC</option>
                                                <option value="MFE">MFE</option>;
                                                <option value="PROD">PROD</option>;
                                            </select>

                                            <script type="text/javascript">
                                                document.getElementById('PIC').value = "<?php echo $_POST['PIC'];?>";
                                            </script>
                    
                    <center>
                        <button class="btn btn-dark text-center" type="submit" onSubmit="JavaScript:return fncSubmit();">ENTER</button>
                    </center>


                </form>


            </div>
        </div>

    </section>
    <!-- Main -->




</body>

</html>
