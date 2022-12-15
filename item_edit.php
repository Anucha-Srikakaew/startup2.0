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
        $chk = explode(', ', $chk);
    } else {
        echo "<script>alert('กรุณาเลือกข้อมูลที่ต้องการแก้ไข');
        window.location.href = window.history.back();</script>";
    }
    ?>


    <script>
        // get model by biz
        var url = "c_model.php?BIZ=<?php echo $BIZ; ?>";
        var jsonData = $.ajax({
            url: url,
            dataType: "json",
            async: false
        }).responseText;

        jsonString = jsonData.replace("\\", "");
        var model = JSON.parse(jsonString);

        // console.log(model);

        $(function() {
            $("#MODEL").autocomplete({
                source: model
            });
        });
        $(function() {
            $("#txtMODEL").autocomplete({
                source: model
            });
        });

        // CHECK ALL
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }

        // SYNC DATA
        function copy() {
            var txtMODEL = document.getElementById("txtMODEL");
            var txtLINE = document.getElementById("txtLINE");
            var txtPROCESS = document.getElementById("txtPROCESS");
            var txtPIC = document.getElementById("txtPIC");
            var txtPERIOD = document.getElementById("txtPERIOD");


            console.log(txtMODEL);

            if (txtMODEL.value != "") {
                var MODEL = document.getElementsByName("MODEL[]");
                MODEL.forEach((num, index) => {
                    MODEL[index].value = txtMODEL.value;
                });
            }

            if (txtLINE.value != "") {
                var LINE = document.getElementsByName("LINE[]");
                LINE.forEach((num, index) => {
                    LINE[index].value = txtLINE.value;
                });
            }

            if (txtPROCESS.value != "") {
                var PROCESS = document.getElementsByName("PROCESS[]");
                PROCESS.forEach((num, index) => {
                    PROCESS[index].value = txtPROCESS.value;
                });
            }

            if (txtPIC.value != "") {
                var PIC = document.getElementsByName("PIC[]");
                PIC.forEach((num, index) => {
                    PIC[index].value = txtPIC.value;
                });
            }

            if (txtPERIOD.value != "") {
                var PERIOD = document.getElementsByName("PERIOD[]");
                PERIOD.forEach((num, index) => {
                    PERIOD[index].value = txtPERIOD.value;
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
                    <select ng-model="myVar" class="form-control">
                        <option option disabled value>SELECT INPUT
                        <option value="MODEL">MODEL
                        <option value="LINE">LINE
                        <option value="PROCESS">PROCESS
                        <option value="PIC">PIC
                        <option value="PERIOD">PERIOD
                    </select>
                </form>

                <div ng-switch="myVar">
                    <div ng-switch-when="MODEL">
                        <input type="text" placeholder="MODEL" name="txtMODEL" id="txtMODEL" class="form-control">
                        <input type="hidden" placeholder="MODEL" name="txtPROCESS" id="txtPROCESS">
                        <input type="hidden" name="txtLINE" id="txtLINE">
                        <input type="hidden" name="txtPERIOD" id="txtPERIOD">
                        <input type="hidden" name="txtPIC" id="txtPIC">
                    </div>
                    <div ng-switch-when="LINE">
                        <select name="txtLINE" id="txtLINE" class="form-control">
                            <?php
                            if ($TYPE == 'ADMIN') {
                                $BIZ = $_POST['BIZ'];
                                require_once("connectMSSQL152.php");
                                $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                $query = sqlsrv_query($conMSSQL152, $stmt);

                                echo "<option value=" . $LINE_NAME . ">$LINE_NAME</option>";

                                while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                    $LINE_NAME = $result['LINE_NAME'];
                                    echo "<option value=" . $LINE_NAME . ">$LINE_NAME</option>";
                                }
                                require_once("connectMSSQL170.php");
                                $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                $query = sqlsrv_query($conMSSQL170, $stmt);

                                while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                    $LINE_NAME = $result['LINE_NAME'];
                                    echo "<option value=" . $LINE_NAME . ">$LINE_NAME</option>";
                                }
                            } else {
                                if (($BIZ == 'AC') or ($BIZ == 'LINE_FIT')) {
                                    require_once("connectMSSQL152.php");
                                    $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                    $query = sqlsrv_query($conMSSQL152, $stmt);

                                    echo "<option value='$LINE'>$LINE</option>";

                                    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                        $LINE_NAME = $result['LINE_NAME'];
                                        echo "<option value=" . $LINE_NAME . ">$LINE_NAME</option>";
                                    }
                                } else if ($BIZ == 'AU') {
                                    require_once("connectMSSQL170.php");
                                    $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                                    $query = sqlsrv_query($conMSSQL170, $stmt);

                                    echo "<option value='$LINE'>$LINE</option>";

                                    while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                        $LINE_NAME = $result['LINE_NAME'];
                                        echo "<option value=" . $LINE_NAME . ">$LINE_NAME</option>";
                                    }
                                } else if ($BIZ == 'IM') {
                                    if ($BIZ == 'IM') {
                                        $BIZ = "IM";
                                    }

                                    $serverName = "43.72.52.154";
                                    $userName = "sa";
                                    $userPassword = "P@ssw0rd";
                                    $dbName = "SWALLOW";

                                    $objConnect = mssql_connect($serverName, $userName, $userPassword) or die("Error Connect to Database");
                                    $objDB = mssql_select_db($dbName);
                                    $strSQL = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE CATEGORY LIKE '%$BIZ%' ORDER BY LINE_NAME";
                                    $objQuery = mssql_query($strSQL) or die("Error Query [" . $strSQL . "]");

                                    echo "<option disabled selected value=''>LINE</option>";

                                    while ($objResult = mssql_fetch_array($objQuery)) {
                                        $LINE_NAME = $objResult['LINE_NAME'];
                                        $LINE_NAME_VALUE = str_replace(' ', '%%', $objResult['LINE_NAME']);

                                        echo "<option value=" . $LINE_NAME_VALUE . ">$LINE_NAME</option>";
                                    }
                                    $BIZ = "IM";
                                }
                            }
                            ?>
                            <input type="hidden" placeholder="MODEL" name="txtMODEL" id="txtMODEL">
                            <input type="hidden" placeholder="MODEL" name="txtPROCESS" id="txtPROCESS">
                        </select>
                        <input type="hidden" name="txtLINE" id="txtLINE">
                        <input type="hidden" name="txtPERIOD" id="txtPERIOD">
                        <input type="hidden" name="txtPIC" id="txtPIC">
                    </div>

                    <div ng-switch-when="PROCESS">
                        <input class="form-control" id="txtPROCESS" name="txtPROCESS" type="text" class="text" placeholder="PROCESS" oninput="this.value = this.value.toUpperCase()">
                        <input type="hidden" name="txtMODEL" id="txtMODEL">
                        <input type="hidden" name="txtLINE" id="txtLINE">
                        <input type="hidden" name="txtPERIOD" id="txtPERIOD">
                        <input type="hidden" name="txtPIC" id="txtPIC">
                    </div>

                    <div ng-switch-when="PIC">
                        <select id="txtPIC" name="txtPIC" class="form-control">
                            <option disabled selected value>PIC
                            <option value="MFE">MFE</option>
                            <option value="PROD">PROD</option>
                        </select>
                        <input type="hidden" name="txtMODEL" id="txtMODEL">
                        <input type="hidden" name="txtLINE" id="txtLINE">
                        <input type="hidden" name="txtPROCESS" id="txtPROCESS">
                        <input type="hidden" name="txtPERIOD" id="txtPERIOD">
                    </div>

                    <div ng-switch-when="PERIOD">
                        <select id="txtPERIOD" name="txtPERIOD" class="form-control">
                            <option disabled selected value>PERIOD
                            <option value="SHIFT">SHIFT</option>
                            <option value="DAY">DAY</option>
                            <option value="WEEK">WEEK</option>
                            <option value="MONTH">MONTH</option>
                            <option value="YEAR">YEAR</option>
                        </select>
                        <input type="hidden" name="txtMODEL" id="txtMODEL">
                        <input type="hidden" name="txtLINE" id="txtLINE">
                        <input type="hidden" name="txtPIC" id="txtPIC">
                        <input type="hidden" placeholder="MODEL" name="txtPROCESS" id="txtPROCESS">
                    </div>
                </div>
                <input type="button" value="COPY" onClick="copy();">
                <input type="button" value="RESET" onClick="window.location.reload()">

                <table class="table table-hover table-bordered">
                    <thead class="thead thead-dark">
                        <tr>
                            <th class="col-lg-1">LINE</th>
                            <th class="col-lg-1">TYPE</th>
                            <th class="col-lg-1">DEAWING</th>
                            <th class="col-lg-1">MODEL</th>
                            <th class="col-lg-1">PROCESS</th>
                            <th class="col-lg-1">JIG NAME</th>
                            <th class="col-lg-1">PICTURE</th>
                            <th>ITEM</th>
                            <th class="col-lg-1">SPEC_DES</th>
                            <th class="col-lg-1">MIN</th>
                            <th class="col-lg-1">MAX</th>
                            <th class="col-lg-1">SPEC</th>
                            <th class="col-lg-1">PIC</th>
                            <th class="col-lg-1">PERIOD</th>
                            <th class="col-lg-1">RESON</th>
                        </tr>
                    </thead>
                    <!-- QUERY BIZ -->
                    <?php

                    require_once("connect.php");
                    date_default_timezone_set("Asia/Bangkok");

                    foreach ($chk as &$ID) {
                        $strSQL = "SELECT * FROM `item` WHERE ID = '$ID';";
                        mysqli_set_charset($con, "utf8");
                        $objQuery = mysqli_query($con, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {

                            $ID = $objResult['ID'];
                            $BIZ = $objResult['BIZ'];
                            $LINE = $objResult['LINE'];
                            $TYPE = $objResult['TYPE'];
                            $DRAWING = $objResult['DRAWING'];
                            $MODEL = $objResult['MODEL'];
                            $PROCESS = $objResult['PROCESS'];
                            $JIG_NAME = $objResult['JIG_NAME'];
                            $PICTURE = $objResult['PICTURE'];
                            $ITEM = $objResult['ITEM'];
                            $SPEC_DES = $objResult['SPEC_DES'];
                            $MIN = $objResult['MIN'];
                            $MAX = $objResult['MAX'];
                            $SPEC = $objResult['SPEC'];
                            $PIC = $objResult['PIC'];
                            $PERIOD = $objResult['PERIOD'];
                    ?>
                            <form method="POST" action="item_save.php?Action=Edit">
                                <tbody>
                                    <tr>
                                        <input name="MEMBER_ID" type="hidden" value="<?php echo $MEMBER_ID; ?>">


                                        <td>
                                            <!-- SELECT LINE -->
                                            <select name="LINE[]" id="LINE" class="text-center form-control">
                                                <option value='<?php echo $LINE ?>'><?php echo $LINE ?></option>
                                                <?php
                                                if ($BIZ == 'IM') {
                                                    $BIZ = "IM";
                                                }

                                                $serverName = "43.72.52.154";
                                                $userName = "sa";
                                                $userPassword = "P@ssw0rd";
                                                $dbName = "SWALLOW";

                                                $objConnect = mssql_connect($serverName, $userName, $userPassword) or die("Error Connect to Database");
                                                $objDB = mssql_select_db($dbName);
                                                $strSQL = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE CATEGORY LIKE '%$BIZ%' ORDER BY LINE_NAME";
                                                $objQuery = mssql_query($strSQL) or die("Error Query [" . $strSQL . "]");


                                                while ($objResult = mssql_fetch_array($objQuery)) {
                                                    $LINE_NAME = $objResult['LINE_NAME'];
                                                    $LINE_NAME_VALUE = str_replace(' ', '%%', $objResult['LINE_NAME']);

                                                    echo "<option value='" . $LINE_NAME_VALUE . "'>$LINE_NAME</option>";
                                                }
                                                $BIZ = "IM";
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <!-- SELECT LINE TYPE -->
                                            <select name="TYPE[]" id="TYPE" class="form-control">
                                                <?php
                                                if ($TYPE == 'ADMIN') {
                                                    echo "<option value='$TYPE'>$TYPE</option>";

                                                    $strSQL = "SELECT DISTINCT TYPE FROM `line_type` WHERE BIZ LIKE '%$BIZ%';";
                                                    $objQuery = mysqli_query($con, $strSQL);
                                                    while ($objResult = mysqli_fetch_array($objQuery)) {
                                                        $TYPE = $objResult['TYPE'];
                                                        echo "<option value=" . $TYPE . ">" . $TYPE . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value='$TYPE'>$TYPE</option>";

                                                    $strSQL = "SELECT TYPE FROM `line_type` WHERE BIZ LIKE '%$BIZ%';";
                                                    $objQuery = mysqli_query($con, $strSQL);
                                                    while ($objResult = mysqli_fetch_array($objQuery)) {
                                                        $TYPE = $objResult['TYPE'];
                                                        echo "<option value=" . $TYPE . ">" . $TYPE . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <!-- SELECT LINE DRAWING -->
                                            <input class="form-control" name="DRAWING[]" type="text" value="<?php echo $DRAWING; ?>">
                                        </td>

                                        <td>
                                            <!-- INPUT MODEL -->
                                            <input class="form-control" id="MODEL" name="MODEL[]" type="text" class="text" oninput="this.value = this.value.toUpperCase()" value="<?php echo $MODEL; ?>">

                                            <script type="text/javascript">
                                                document.getElementById('MODEL').value = "<?php echo $_POST['MODEL']; ?>";
                                            </script>
                                        </td>

                                        <td>
                                            <!-- INPUT PROCESS -->
                                            <input class="form-control" name="PROCESS[]" type="text" value="<?php echo $PROCESS; ?>">
                                        </td>

                                        <td>
                                            <!-- INPUT JIG_NAME -->
                                            <textarea class="form-control" name="JIG_NAME[]"><?php echo $JIG_NAME; ?></textarea>
                                        </td>

                                        <td>
                                            <!-- INPUT PICTURE -->
                                            <img src="http://43.72.52.52/excel_body/item/photo/<?php echo $PICTURE ?>" alt="" width="100%" class="img"><br>
                                            <input class="form-control" name="PICTURE[]" type="file" value="<?php echo $PICTURE; ?>">
                                        </td>

                                        <td>
                                            <textarea class="form-control" name="ITEM[]"><?php echo $ITEM; ?></textarea>
                                        </td>

                                        <td>
                                            <input class="form-control" name="SPEC_DES[]" type="text" value="<?php echo $SPEC_DES; ?>">
                                        </td>

                                        <td>
                                            <input class="form-control min" name="MIN[]" id="<?php echo $ID ?>" type="number" step="any" value="<?php echo $MIN; ?>">
                                            <input class="form-control" name="HIS_MIN[<?php echo $ID ?>]" id="<?php echo $ID ?>" type="hidden" step="any" value="<?php echo $MIN; ?>">
                                        </td>

                                        <td>
                                            <input class="form-control max" name="MAX[]" id="<?php echo $ID ?>" type="number" step="any" value="<?php echo $MAX; ?>">
                                            <input class="form-control" name="HIS_MAX[<?php echo $ID ?>]" id="<?php echo $ID ?>" type="hidden" step="any" value="<?php echo $MAX; ?>">
                                        </td>

                                        <td>
                                            <!-- SELECT LINE TYPE -->
                                            <select name="SPEC[]" id="SPEC" class="form-control">
                                                <?php
                                                if ($TYPE == 'ADMIN') {
                                                    echo "<option value='$TYPE'>$TYPE</option>";

                                                    $strSQL = "SELECT DISTINCT SPEC FROM `SPEC` WHERE BIZ LIKE '%$BIZ%'";
                                                    $objQuery = mysqli_query($con, $strSQL);
                                                    while ($objResult = mysqli_fetch_array($objQuery)) {
                                                        $SPEC = $objResult['SPEC'];
                                                        echo "<option value=" . $SPEC . ">" . $SPEC . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value='$SPEC'>$SPEC</option>";

                                                    $strSQL = "SELECT DISTINCT SPEC FROM `SPEC` WHERE BIZ LIKE '%$BIZ%'";
                                                    $objQuery = mysqli_query($con, $strSQL);
                                                    while ($objResult = mysqli_fetch_array($objQuery)) {
                                                        $SPEC = $objResult['SPEC'];
                                                        echo "<option value=" . $SPEC . ">" . $SPEC . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>


                                        <td>
                                            <select name="PIC[]" id="PIC" class="form-control">
                                                <option value='<?php echo $PIC; ?>'><?php echo $PIC; ?></option>";
                                                <option value="MFE">MFE</option>
                                                <option value="PROD">PROD</option>
                                            </select>
                                        </td>

                                        <td>
                                            <select name="PERIOD[]" id="PERIOD" class="form-control">
                                                <option value='<?php echo $PERIOD; ?>'><?php echo $PERIOD; ?></option>";
                                                <option value="SHIFT">SHIFT</option>
                                                <option value="DAY">DAY</option>
                                                <option value="WEEK">WEEK</option>
                                                <option value="MONTH">MONTH</option>
                                                <option value="YEAR">YEAR</option>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea id="RESON<?php echo $ID ?>" name="RESON[<?php echo $ID ?>]" class="form-control" disabled></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                        <?php

                        }
                        echo '<input name="BIZ[' . $ID . ']" type="hidden" value="' . $BIZ . '">';
                        echo '<input name="CHANGE_MIN_MAX[' . $ID . ']" id="CHANGE_MIN_MAX' . $ID . '" type="hidden" value="NO">';
                        echo '<input name="ID_DATA[]" type="hidden" value="' . $ID . '">';
                    }
                        ?>
                </table>
            </div>
            <input name="ID" type="hidden" value="<?php echo $ID; ?>">

            <button class="btn btn-dark" type="submit">EDIT</button>
            </form>

        </div>
    </section>
    <!-- Main -->

</body>

</html>

<script>
    $(document).ready(function() {
        $(".min").change(function() {
            document.getElementById("RESON" + this.id + "").removeAttribute("disabled", "");
            document.getElementById("RESON" + this.id + "").required = true;
            document.getElementById("CHANGE_MIN_MAX" + this.id + "").value = 'YES';
        })
        $(".max").change(function() {
            document.getElementById("RESON" + this.id + "").removeAttribute("disabled", "");
            document.getElementById("RESON" + this.id + "").required = true;
            document.getElementById("CHANGE_MIN_MAX" + this.id + "").value = 'YES';
        })
    })
</script>