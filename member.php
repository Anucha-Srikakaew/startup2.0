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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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

    $MEMBER_ID = $_GET['MEMBER_ID'];

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
            if ($BIZ == 'ALL') {
                if (empty($_GET['BIZ'])) {
                    $BIZ = '';
                } else {
                    $BIZ = $_GET['BIZ'];
                }
            }
        } else {
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

        jsonString = jsonData.replace("\\", "");
        var model = JSON.parse(jsonString);

        // console.log(model);

        $(function() {
            $("#MODEL").autocomplete({
                source: model
            });
        });

        // SELECT PAGE BY BUTTON
        function fncSubmit(strPage) {
            if (strPage == "page1") {
                document.form1.action = "member_edit.php";
            }

            if (strPage == "page2") {
                document.form1.action = "member_copy.php";
            }

            if (strPage == "page3") {
                document.form1.action = "member_delete.php";
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

    <!-- Main -->
    <section id="main">
        <div class="row text-center">
            <div class="col-lg-12 mx-auto">
                <h1><b>STARTUP CHECK SYSTEM</b></h1>
                <p class="lead">Manage the data over all startup check project.</p><br><br>
            </div>
        </div>

        <div class="text-center">
            <form name="form" method="POST" action="member.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>">
                <!-- MEMBER ID -->
                <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">

                <select name="TYPE" id="TYPE">
                    <?php
                    echo "<option disabled selected value>TYPE</option>";

                    $strSQL = "SELECT DISTINCT TYPE FROM `member` WHERE BIZ LIKE '%$BIZ%' AND TYPE <> 'ADMIN';";
                    $objQuery = mysqli_query($con, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                        $TYPE = $objResult['TYPE'];
                        echo "<option value=" . $TYPE . ">" . $TYPE . "</option>";
                    }
                    ?>
                </select>

                <select name="SHIFT" id="SHIFT">
                    <option disabled selected value=''>SHIFT</option>
                    <option value="ALL">ALL</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                </select>

                <select name="LINE" id="LINE">
                    <?php
                    echo "<option disabled selected value>LINE</option>";

                    $strSQL = "SELECT DISTINCT LINE FROM `member` WHERE BIZ LIKE '%$BIZ%' AND TYPE <> 'ADMIN';";
                    $objQuery = mysqli_query($con, $strSQL);
                    while ($objResult = mysqli_fetch_array($objQuery)) {
                        $LINE = $objResult['LINE'];
                        echo "<option value=" . $LINE . ">" . $LINE . "</option>";
                    }
                    ?>
                </select>

                <button type="submit">ENTER</button>
            </form>
        </div>

        <a href="file/STARTUP_ITEM_TEMPLETE.csv" class="btn btn-dark" style="float : right;">
            <i class='fas fa-download' style='color:white'></i>
        </a>

        <form mehtod="post" id="export_excel">
            <label class="btn btn-success">
                <input type="file" hidden name="excel_file" id="excel_file">
                <input type="text" hidden name="table" id="table">
                <input type="text" hidden name="check_biz" id="check_biz">
                <i class='fas fa-upload' style='color:white'></i>
            </label>
        </form>

        <script>
            $(document).ready(function() {
                $('#excel_file').change(function() {
                    $('#export_excel').submit();
                });

                $('#export_excel').on('submit', function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: "export.php",
                        method: "POST",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
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
                                    html: 'เกิดข้อผิดพลาดในไฟล์ที่คุณอัปโหลดบรรทัดที่ : ' + data,
                                })
                            }
                        },
                        error: function() {
                            alert("test");
                        }
                    })
                })

                $('#export_excel').on('click', function() {
                    $.ajax({
                        url: 'export.php',
                        type: 'POST',
                        data: {
                            data: 'member'
                        },
                        success: function(data) {
                            $('#table').val('member');
                            $('#check_biz').val('<?php echo $MEMBER_ID; ?>');

                        }
                    });
                });

            })
        </script>

        <form action="page.cgi" method="POST" name="form1">
            <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">
            <!-- TABLE DATA -->
            <div class="col-lg-12 mx-auto text-left">
                <div class="row">
                    <table class="table">
                        <thead class="thead thead-dark">
                            <tr>
                                <th><input type="checkbox" onclick="toggle(this);"></th>
                                <th>MEMBER_ID</th>
                                <th>NAME</th>
                                <th>PASSWORD</th>
                                <th>TYPE</th>
                                <th>SHIFT</th>
                                <th>LINE</th>
                                <th>TOOLS <a href="member_add.php?Action=Add&MEMBER_ID=<?php echo $_GET['MEMBER_ID'];?>" class="btn btn-dark"><i class='fas fa-plus' style='color:white'></i></a><br></th>
                            </tr>
                        </thead>
                        <?php

                        require_once("connect.php");
                        date_default_timezone_set("Asia/Bangkok");


                        // CHECK GET EMPTY

                        if (empty($_POST['TYPE'])) {
                            $TYPE = '';
                        } else {
                            $TYPE = $_POST['TYPE'];
                        }

                        if (empty($_POST['SHIFT'])) {
                            $sqlSHIFT = "SHIFT LIKE '%%'";
                        } else {
                            $SHIFT = $_POST['SHIFT'];
                            $sqlSHIFT = "SHIFT = '$SHIFT'";
                        }

                        if (empty($_POST['LINE'])) {
                            $LINE = '';
                        } else {
                            $LINE = $_POST['LINE'];
                        }

                        // QUERY FILTER
                        $strSQL = "SELECT * FROM `member` 
                                    WHERE BIZ LIKE '%$BIZ%'
                                    AND TYPE LIKE '%$TYPE%'
                                    AND $sqlSHIFT
                                    AND LINE LIKE '%$LINE%'";
                        $objQuery = mysqli_query($con, $strSQL);
                        while ($objResult = mysqli_fetch_array($objQuery)) {
                            $ID = $objResult['ID'];
                            $MEMBER_ID = $objResult['MEMBER_ID'];
                            $NAME = $objResult['NAME'];
                            $PASSWORD = $objResult['PASSWORD'];
                            $TYPE = $objResult['TYPE'];
                            $SHIFT = $objResult['SHIFT'];
                            $LINE = $objResult['LINE'];
                        ?>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" name="chk[]" value="<?php echo $ID; ?>"></td>
                                    <td><a href="http://43.72.52.52/system/sttc.php?data=<? echo $MEMBER_ID;?>"><?php echo $MEMBER_ID; ?></a></td>
                                    <td><?php echo $NAME; ?></td>
                                    <td><?php echo $PASSWORD; ?></td>
                                    <td><?php echo $TYPE; ?></td>
                                    <td><?php echo $SHIFT; ?></td>
                                    <td><?php echo $LINE; ?></td>
                                    <td>
                                        <a href="member_edit.php?MEMBER_ID=<? echo $_GET['MEMBER_ID'];?>&&ID=<?php echo $ID; ?>" class="btn btn-primary">
                                            <i class='fas fa-edit' style='color:white'></i>
                                        </a>
                                        <a href="member_delete.php?MEMBER_ID=<? echo $_GET['MEMBER_ID'];?>&&ID=<?php echo $ID; ?>" class="btn btn-danger">
                                            <i class='fas fa-trash' style='color:white'></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        }
                        ?>
                    </table>
                </div>
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