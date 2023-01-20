<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html">
    <meta charset="UTF-8">
    <title>STARTUP CHECK</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">
    <!-- <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">
    <script src="framework/js/a076d05399.js"></script>

    <script src="framework/js/jquery.min.js"></script>
    <link rel="stylesheet" href="framework/css/jquery-ui.css">
    <script src="framework/js/jquery-1.12.4.js"></script>
    <script src="framework/js/jquery-ui.js"></script>
    <script src="framework/js/sweetalert2@9"></script> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

    <link href="framework/css/scrolling-nav.css" rel="stylesheet">
    <script src="framework/js/a076d05399.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="framework/js/bootstrap-select.min.js"></script>

    <link rel="stylesheet" href="framework/css/jquery-ui.css">
    <script src="framework/js/jquery-1.12.4.js"></script>
    <script src="framework/js/jquery-ui.js"></script>
    <script src="framework/js/sweetalert2@9.js"></script>
    <script src="framework/js/jquery.dataTables.min.js"></script>
    <script src="framework/js/dataTables.bootstrap4.min.js"></script>


    <style>
        input[type=text],
        input[type=password] {
            width: 15%;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type=button],
        input[type=submit] {
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
    mysqli_set_charset($con, "utf8");

    $MEMBER_ID = $_GET['MEMBER_ID'];

    if (isset($_GET['MEMBER_ID'])) {
        $MEMBER_ID = $_GET['MEMBER_ID'];
        $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
        $objQuery = mysqli_query($con206, $strSQL);
        $objResult = mysqli_fetch_array($objQuery);

        $MEMBER_ID = $objResult['MEMBER_ID'];
        $NAME = $objResult['NAME'];
        $TYPE = $objResult['TYPE'];
        // print_r($_POST['BIZ']);
        if (isset($_POST['BIZ'])) {
            // echo "1";
            $BIZ = $_POST['BIZ'];
            if ($BIZ == 'ALL') {
                if (empty($_GET['BIZ'])) {
                    $BIZ = '';
                } else {
                    $BIZ = $_GET['BIZ'];
                }
            }
        } else {
            // echo "2";
            $BIZ = $objResult['BIZ'];
            if ($BIZ == 'ALL') {
                if (empty($_GET['BIZ'])) {
                    $BIZ = '';
                } else {
                    $BIZ = $_GET['BIZ'];
                }
            }
        }
    } else {
        if (isset($_POST['MEMBER_ID'])) {
            $MEMBER_ID = $_GET['MEMBER_ID'];
        } else {
            header("Location: login.php");
        }
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

        var model = JSON.parse(jsonData);


        $(function() {
            $("#MODEL").autocomplete({
                source: model
            });
        });

        // SELECT PAGE BY BUTTON
        function fncSubmit(strPage) {
            if (strPage == "page1") {
                document.form1.action = "item_edit.php";
            }

            if (strPage == "page2") {
                document.form1.action = "item_copy.php";
            }

            if (strPage == "page3") {
                document.form1.action = "item_delete.php";
            }

            document.form1.submit();
        }

        // CHECK ALL
        function toggle(source) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i] != source)
                    checkboxes[i].checked = source.checked;
            }
        }
    </script>


</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark">
        <a class="navbar-brand text-white" href="http://43.72.52.52/system/">SONY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link text-white" href="http://43.72.52.51/startup2.0/">HOME <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="http://43.72.52.51/startup2.0/login.php">LOGIN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="http://43.72.52.51/startup2.0/visual.php?BIZ=<?php echo $BIZ; ?>">STARTUP</a>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0">
                <a class="nav-link text-white" href="http://43.72.52.51/startup2.0/manage_PIC.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>" onclick="">BACK</a>
            </div>
        </div>
    </nav>
    <!-- Main -->
    <section id="main">
        <div class="row text-center">
            <div class="col-lg-12 mx-auto">
                <h1><b>STARTUP CHECK SYSTEM</b></h1>
                <p class="lead">Manage the data over all startup check project.</p><br><br>
            </div>
        </div>


        <div class="text-center">
            <form name="form" method="POST" action="item.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>">
                <!-- MEMBER ID -->
                <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">
                <!-- SELECT BIZ -->
                <select name="BIZ" id="BIZ" onchange="this.form.submit()" class="selectpicker" data-live-search="true">
                    <?php
                    if ($TYPE == 'ADMIN') {
                        $BIZ = '';
                        if (empty($BIZ)) {
                            echo "<option disabled selected value>BIZ</option>";
                            $strSQL = "SELECT DISTINCT BIZ FROM `biz`;";
                            $objQuery = mysqli_query($con, $strSQL);
                            while ($objResult = mysqli_fetch_array($objQuery)) {
                                $BIZ = $objResult['BIZ'];
                                echo "<option value=" . $BIZ . ">" . $BIZ . "</option>";
                            }
                        } else {
                            $strSQL = "SELECT DISTINCT BIZ FROM `biz`;";
                            $objQuery = mysqli_query($con, $strSQL);
                            while ($objResult = mysqli_fetch_array($objQuery)) {
                                $BIZ = $objResult['BIZ'];
                                echo "<option value=" . $BIZ . ">" . $BIZ . "</option>";
                            }
                        }
                    } else {
                        echo "<option value=" . $BIZ . ">$BIZ</option>";
                    }
                    ?>
                </select>

                <!-- SELECT LINE -->
                <select name="LINE[]" id="LINE" class="selectpicker" multiple data-live-search="true">
                    <?php
                    // echo $BIZ;
                    ?>
                    <?php
                    if ($TYPE == 'ADMIN') {
                        $BIZ = $_POST['BIZ'];
                        require_once("connectMSSQL152.php");
                        $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                        $query = sqlsrv_query($conMSSQL152, $stmt);

                        echo "<option disabled selected value>LINE</option>";

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

                            echo "<option disabled selected value>LINE</option>";

                            while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                $LINE_NAME = $result['LINE_NAME'];
                                $LINE_NAME_VALUE = str_replace(' ', '%%', $objResult['LINE_NAME']);
                                echo "<option value=" . $LINE_NAME . ">$LINE_NAME</option>";
                            }
                        } else if ($BIZ == 'AU') {
                            require_once("connectMSSQL170.php");
                            $stmt = "SELECT [LINE_NAME] FROM [SWALLOW].[dbo].[TBL_LINE_MASTER] WHERE [CATEGORY] LIKE '%$BIZ%' ORDER BY [LINE_NAME]";
                            $query = sqlsrv_query($conMSSQL170, $stmt);

                            echo "<option disabled selected value>LINE</option>";

                            while ($result = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                $LINE_NAME = $result['LINE_NAME'];
                                $LINE_NAME_VALUE = str_replace(' ', '%%', $objResult['LINE_NAME']);
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
                </select>

                <!-- INPUT MODEL -->
                <input id="MODEL" name="MODEL" type="text" class="form-control" placeholder="MODEL" oninput="this.value = this.value.toUpperCase()">

                <!-- INPUT PROCESS  -->
                <select name="PROCESS[]" id="PROCESS" class="selectpicker" multiple data-live-search="true">
                    <?php
                    echo "<option disabled selected value=''>PROCESS</option>";

                    $strSQL = "SELECT DISTINCT PROCESS FROM `ITEM` WHERE BIZ LIKE '%$BIZ%'";
                    $objQuery = mysqli_query($con, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                        $PROCESS = $objResult['PROCESS'];
                        $PROCESS_VALUE = str_replace(' ', '%%', $objResult['PROCESS']);
                        echo "<option value=" . $PROCESS_VALUE . ">" . $PROCESS . "</option>";
                    }
                    ?>
                </select>

                <!-- SELECT LINE TYPE -->
                <select name="TYPE[]" id="TYPE" class="selectpicker" multiple data-live-search="true">
                    <?php
                    if ($TYPE == 'ADMIN') {
                        echo "<option disabled selected value>TYPE</option>";

                        $strSQL = "SELECT DISTINCT TYPE FROM `line_type` WHERE BIZ LIKE '%$BIZ%';";
                        $objQuery = mysqli_query($con, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {
                            $TYPE = $objResult['TYPE'];
                            $TYPE_VALUE = str_replace(' ', '%%', $objResult['TYPE']);
                            echo "<option value=" . $TYPE_VALUE . ">" . $TYPE . "</option>";
                        }
                    } else {
                        echo "<option disabled selected value>TYPE</option>";

                        $strSQL = "SELECT DISTINCT TYPE FROM `item` WHERE BIZ LIKE '%$BIZ%';";
                        $objQuery = mysqli_query($con, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {
                            $TYPE = $objResult['TYPE'];
                            $TYPE_VALUE = str_replace(' ', '%%', $objResult['TYPE']);
                            echo "<option value=" . $TYPE_VALUE . ">" . $TYPE . "</option>";
                        }
                    }
                    ?>
                </select>

                <!-- SELECT SPEC -->
                <select name="SPEC[]" id="SPEC" class="selectpicker" multiple data-live-search="true">
                    <?php
                    echo "<option disabled selected value=''>SPEC</option>";

                    $strSQL = "SELECT DISTINCT SPEC FROM `item` WHERE BIZ = '$BIZ'";
                    $objQuery = mysqli_query($con, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                        $SPEC = $objResult['SPEC'];
                        $SPEC_VALUE = str_replace(' ', '%%', $objResult['SPEC']);
                        echo "<option value=" . $SPEC_VALUE . ">" . $SPEC . "</option>";
                    }
                    ?>
                </select>

                <!-- SELECT PIC -->
                <select name="PIC[]" id="PIC" class="selectpicker" multiple data-live-search="true">
                    <option disabled selected value=''>PIC</option>
                    <option value="MFE">MFE</option>;
                    <option value="PROD">PROD</option>;
                </select>

                <button class="btn-primary" type="submit">ENTER</button>
            </form>
        </div>

        <a href="file/STARTUP_ITEM_TEMPLETE.csv" class="btn btn-dark mx-3" style="float : right;">
            <i class='fas fa-download' style='color:white'></i>
        </a>

        <!-- <form mehtod="post" id="export_excel">
            <label class="btn btn-success">
                <input type="file" hidden name="excel_file" id="excel_file">
                <input type="text" hidden name="table" id="table">
                <input type="text" hidden name="check_biz" id="check_biz">
                <i class='fas fa-upload' style='color:white'></i>
            </label>
        </form> -->
        <!-- <iframe id="demo" width="45" height="40" class="mx-3" frameBorder="0" scrolling="no" src="http://43.72.52.52/anako/excel_body/test/index.php?MEMBER_ID=<?php echo $_GET['MEMBER_ID'] ?>"></iframe> -->
        <a class="text-dark" href="http://43.72.52.52/excel_body/test/index.php?MEMBER_ID=<?php echo $_GET['MEMBER_ID'] ?>"><i class='fas fa-upload btn btn-success'></i></a>


        <script type="text/javascript">
            $(document).ready(function() {

                $('#excel_file').change(function() {
                    $('#export_excel').submit();

                });


                $('#export_excel').on('submit', function(event) {
                    event.preventDefault();
                    console.log(new FormData(this));
                    $.ajax({
                        url: "export.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            $('#result').html(data);
                            $('#excel_file').val('');
                            if (data == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'อัพโหลดข้อมูลเสร็จสิ้น',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    html: 'เกิดข้อผิดพลาดในไฟล์ที่คุณอัปโหลดบรรทัดที่' + data,
                                })
                            }
                        },
                        error: function() {
                            alert("Error Upload condition.");
                        }
                    })
                })

                $('#export_excel').on('click', function() {
                    $.ajax({
                        url: 'export.php',
                        type: 'POST',
                        data: {
                            data: 'item_test'
                        },
                        success: function(data) {
                            $('#table').val('item');
                            $('#check_biz').val('<?php echo $MEMBER_ID; ?>');

                        }
                    });
                });


            });
        </script>



        <form action="page.cgi" method="POST" name="form1">
            <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">
            <!-- TABLE DATA -->
            <div class="col-lg-12 mx-auto text-center">
                <table class="table table-striped table-bordered" style="width:100%" id="datatables">
                    <thead class="thead thead-dark">
                        <tr>
                            <th><input type="checkbox" onclick="toggle(this);"></th>
                            <th>LINE</th>
                            <th>TYPE</th>
                            <th>MODEL</th>
                            <th>PROCESS</th>
                            <th>ITEM</th>
                            <th>SPEC DES</th>
                            <th>MIN</th>
                            <th>MAX</th>
                            <th>SPEC</th>
                            <th>PIC</th>
                            <th>TOOLS <a href="item_add.php?Action=Add&MEMBER_ID=<? echo $_GET['MEMBER_ID']; ?>" class="btn btn-dark" style="margin-left:5px"><i class='fas fa-plus' style='color:white'></i></a><br></th>
                        </tr>
                    </thead>
                    <?php

                    require_once("connect.php");
                    date_default_timezone_set("Asia/Bangkok");
                    // print_r($_POST);

                    // CHECK GET EMPTY

                    if (empty($_POST['LINE'])) {
                        $LINE = '';
                    } else {
                        // $LINE[] = $_POST['LINE'];
                        $LINE = implode("','", $_POST['LINE']);
                    }
                    if (empty($_POST['MODEL'])) {
                        $MODEL = '';
                    } else {
                        $MODEL = $_POST['MODEL'];
                    }
                    if (empty($_POST['PROCESS'])) {
                        $PROCESS = '';
                    } else {
                        // $PROCESS = $_POST['PROCESS'];
                        $PROCESS = implode("','", $_POST['PROCESS']);
                    }
                    if (empty($_POST['TYPE'])) {
                        $TYPE = '';
                    } else {
                        // $TYPE = $_POST['TYPE'];
                        $TYPE = implode("','", $_POST['TYPE']);
                    }
                    if (empty($_POST['SPEC'])) {
                        $SPEC = '';
                    } else {
                        $SPEC = implode("','", $_POST['SPEC']);
                    }
                    if (empty($_POST['PIC'])) {
                        $PIC = '';
                    } else {
                        $PIC = implode("','", $_POST['PIC']);
                    }
                    ?>
                    <!-- <tbody>
                                <tr>
                                    <td><input type="checkbox" name="chk[]" value="<?php echo $ID; ?>"></td>
                                    <td><?php echo $LINE; ?></td>
                                    <td><?php echo $TYPE; ?></td>
                                    <td><?php echo $MODEL; ?></td>
                                    <td><?php echo $PROCESS; ?></td>
                                    <td>
                                        <div>
                                            <?php echo $ITEM; ?>
                                        </div>
                                    </td>
                                    <td><?php echo $SPEC_DES; ?></td>
                                    <td><?php echo $MIN; ?></td>
                                    <td><?php echo $MAX; ?></td>
                                    <td><?php echo $SPEC; ?></td>
                                    <td><?php echo $PIC; ?></td>
                                    <td>
                                        <a href="item_edit.php?MEMBER_ID=<? echo $_GET['MEMBER_ID']; ?>&&ID=<?php echo $ID; ?>&LINE=<?php echo $LINE; ?>" class="btn btn-primary">
                                            <i class='fas fa-edit' style='color:white'></i>
                                        </a>
                                        <a href="item_delete.php?MEMBER_ID=<? echo $_GET['MEMBER_ID']; ?>&&ID=<?php echo $ID; ?>" class="btn btn-danger">
                                            <i class='fas fa-trash' style='color:white'></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody> -->

                    <?php
                    // }
                    ?>
                </table>
            </div>
            <!-- END TABLE -->

            <div class="col-lg-12 mx-auto text-center">

                <label class="btn btn-primary">
                    <i class='fas fa-edit' style='color:white' onClick="JavaScript:fncSubmit('page1')"></i>
                </label>

                <label class="btn btn-warning">
                    <i class='fas fa-copy' style='color:white' onClick="JavaScript:fncSubmit('page2')"></i>
                </label>

                <label class="btn btn-danger">
                    <i class='fas fa-trash' style='color:white' onClick="JavaScript:fncSubmit('page3')"></i>
                </label>

            </div>

        </form>
        </div>
    </section>
    <!-- Main -->

</body>

</html>

<script>
    BIZ = <?php echo json_encode($BIZ); ?>;
    LINE = <?php echo json_encode($LINE); ?>;
    MODEL = <?php echo json_encode($MODEL); ?>;
    PROCESS = <?php echo json_encode($PROCESS); ?>;
    TYPE = <?php echo json_encode($TYPE); ?>;
    SPEC = <?php echo json_encode($SPEC); ?>;
    PIC = <?php echo json_encode($PIC); ?>;
    MEMBER_ID = <?php echo json_encode($MEMBER_ID); ?>;
    console.log(LINE)

    $(document).ready(function() {
        loadtabledefault();
        $('#datatables').DataTable({
            "bLengthChange": false,
            "bInfo": false,
            "bAutoWidth": false,
            destroy: true,
            searching: false,
            "columnDefs": [{
                "orderable": true,
            }],
            responsive: true,
        });
    });

    function loadtabledefault() {
        data = {
            'BIZ': BIZ,
            'LINE': LINE,
            'MODEL': MODEL,
            'PROCESS': PROCESS,
            'TYPE': TYPE,
            'SPEC': SPEC,
            'PIC': PIC,
            'MEMBER_ID': MEMBER_ID
        }
        // console.log(data)
        $.ajax({
            type: "POST",
            url: "query_item.php",
            data: data,
            dataType: 'JSON',
            success: function(result) {
                console.log(data)
                if (result.length > 0) {
                    let table = $("#datatables").DataTable({
                        "bLengthChange": false,
                        "bInfo": false,
                        "bAutoWidth": false,
                        destroy: true,
                        searching: false,
                        "columnDefs": [{
                            "orderable": false,
                            "targets": 4
                        }],
                        responsive: true,
                    });
                    table.clear()

                    result.forEach(function(table_row) {
                        var i = table.row.add([
                            "<td>" + table_row.use_ID + "</td>",
                            "<td>" + table_row.use_LINE + "</td>",
                            "<td>" + table_row.use_TYPE + "</td>",
                            "<td>" + table_row.use_MODEL + "</td>",
                            "<td>" + table_row.use_PROCESS + "</td>",
                            "<td>" + table_row.use_ITEM + "</td>",
                            "<td>" + table_row.use_SPEC_DES + "</td>",
                            "<td>" + table_row.use_MIN + "</td>",
                            "<td>" + table_row.use_MAX + "</td>",
                            "<td>" + table_row.use_SPEC + "</td>",
                            "<td>" + table_row.use_PIC + "</td>",
                            "<td>" + table_row.use_TOOL + "</td>",
                        ]).draw(false);
                    });
                } else {
                    //do nothings
                }
                // console.log(result)
            }
        });
    }
</script>