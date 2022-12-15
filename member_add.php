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

    <script src="framework/js/angular.min.js"></script>
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
                    if(document.form.M_ID.value == "")
                    {
                    alert('Please fill MEMBER ID.');
                    document.form.M_ID.focus();
                    return false;
                    } 
                    if(document.form.NAME.value == "")
                    {
                    alert('Please fill MEMBER NAME.');
                    document.form.NAME.focus();
                    return false;
                    } 
                    if(document.form.PASSWORD.value == "")
                    {
                    alert('Please fill MEMBER PASSWORD.');
                    document.form.PASSWORD.focus();
                    return false;
                    } 
                    if(document.form.TYPE.value == "")
                    {
                    alert('Please select type of member.');
                    document.form.TYPE.focus();
                    return false;
                    } 
                    if(document.form.SHIFT.value == "")
                    {
                    alert('Please select shift of member.');
                    document.form.SHIFT.focus();
                    return false;
                    } 
                    if(document.form.LINE.value == "")
                    {
                    alert('Please select LINE.');
                    document.form.LINE.focus();
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
                    <p class="lead">Manage the member in startup check project.</p><br><br>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-lg-8 mx-auto">
                <form name="form" method="POST" action="member_save.php?Action=Add" onSubmit="JavaScript:return fncSubmit();">

                    <!-- MEMBER ID -->
                        <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID;?>">
                    <!-- SELECT BIZ -->
                        <input type="hidden" name="BIZ" value="<?php echo $BIZ;?>">


                        <input type="text" name="M_ID" placeholder="MEMBER ID (รหัสพนักงาน 22XXYYZZ)">
                        <input type="text" name="NAME" placeholder="NAME">
                        <input type="password" name="PASSWORD" placeholder="PASSWORD">
                    <center>

                        <select name="TYPE" id="TYPE" class="col-lg-3">
                            <?php
                                echo "<option disabled selected value>TYPE</option>";
                                
                                if($objResult['TYPE']=='ADMIN')
                                {
                                    $BIZ='';
                                }

                                echo $strSQL = "SELECT DISTINCT TYPE FROM `member` WHERE BIZ LIKE '%$BIZ%' AND TYPE <> 'ADMIN';";
                                $objQuery = mysqli_query($con,$strSQL);
                                while($objResult = mysqli_fetch_array($objQuery))
                                {
                                    $TYPE = $objResult['TYPE'];
                                    echo "<option value=".$TYPE.">".$TYPE."</option>";
                                }
                            ?>
                        </select>

                        <select name="SHIFT" id="SHIFT" class="col-lg-3">
                            <option disabled selected value=''>SHIFT</option>
                            <option value="ALL">ALL</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                        
                        <select name="LINE" id="LINE" class="col-lg-3">
                            <?php
                                echo "<option disabled selected value>LINE</option>";

                                $strSQL = "SELECT DISTINCT LINE FROM `member` WHERE BIZ LIKE '%$BIZ%' AND TYPE <> 'ADMIN';";
                                $objQuery = mysqli_query($con,$strSQL);
                                while($objResult = mysqli_fetch_array($objQuery))
                                {
                                    $LINE = $objResult['LINE'];
                                    echo "<option value=".$LINE.">".$LINE."</option>";
                                }
                            ?>
                        </select>

                        



                    
                        <br><br><br><br>
                        <button class="btn btn-dark text-center" type="submit" onSubmit="JavaScript:return fncSubmit();">ENTER</button>
                    </center>


                </form>


            </div>
        </div>

    </section>
    <!-- Main -->




</body>

</html>
