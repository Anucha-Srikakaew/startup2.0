<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TIME</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">
    <!-- <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">
    <script src="framework/js/a076d05399.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="framework/js/sweetalert2@9.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

    <style>
        /* input[type=text], */
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

</head>

<body>

    <!-- Navbar -->
    <nav class="fixed-top navbar navbar-expand-lg navbar-dark" style="background-color: black;" id="navbar">
        <a class="navbar-brand" href="http://43.72.52.52/system/" style="color: white;">SYSTEM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <!-- <a class="nav-link" href="http://43.72.52.52/startup2.0/">HOME <span class="sr-only">(current)</span></a> -->
                </li>
            </ul>
        </div>
        <form class="form-inline">
            <button style="background-color: black;" class="btn my-2 my-sm-0 text-light" type="button" onclick="window.location.href='manage_PIC.php?MEMBER_ID=<?php echo $MEMBER_ID ?>'">BACK</button>
        </form>
    </nav>

    <?php
    $target_table = $_GET["target_table"];
    if ($target_table == "target_shift") {
        $class_btn_shift = "btn-dark";
        $class_btn_day = "btn-outline-dark";
        $class_btn_week = "btn-outline-dark";
    } else if ($target_table == "target_day") {
        $class_btn_shift = "btn-outline-dark";
        $class_btn_day = "btn-dark";
        $class_btn_week = "btn-outline-dark";
    }
    ?>

    <!-- Main -->
    <section id="main">
        <form action="start_cutoff.php" method="get">
            <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID ?>">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>STARTUP CHECK SYSTEM</b></h1>
                    <p class="lead">Manage the data over all startup check project.</p>
                    <br><u id="clock" name="clock"></u><br><br>
                    <!-- <div class="row text-center container">
                        <div class="col-6 text-center">
                            <button type="submit" class="btn <?php echo $class_btn_shift ?> form-control" id="button_shift" name="target_table" value="target_shift"><i class='fas fa-sun'></i>&nbsp; &nbsp;SHIFTLY</button>
                        </div>
                        <div class="col-6 text-center">
                            <button type="submit" class="btn <?php echo $class_btn_day ?> form-control" id="button_day" name="target_table" value="target_day"><i class="fas fa-calendar-day"></i>&nbsp; &nbsp; DAILY</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </form>
        <br>
        <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID; ?>">

        <div class="container-fluid row">
            <div class="col-12">
                <?php if ($target_table == "target_shift") { ?>
                    <table class="table table-striped table-bordered table-hover" id="example">
                        <thead class="thead thead-dark">
                            <tr class="text-center">
                                <th>LINE</th>
                                <th>TECHNICIAN(MIN.)</th>
                                <th>MFE(MIN.)</th>
                                <th>PRODUCTION(MIN.)</th>
                                <th>START TIME DAY</th>
                                <th>TARGET TIME DAY</th>
                                <th>START TIME NIGHT</th>
                                <th>TARGET TIME NIGHT</th>
                                <th>SHIFT DATE</th>
                                <th>TOOLS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("connect.php");
                            date_default_timezone_set("Asia/Bangkok");
                            // QUERY FILTER
                            $strSQL = "SELECT * FROM `target_shift` ORDER BY `LINE` ASC";
                            $objQuery = mysqli_query($con, $strSQL);
                            while ($objResult = mysqli_fetch_array($objQuery)) {
                                $ID = $objResult['ID'];
                                $LINE = $objResult['LINE'];
                                $TARGET1 = $objResult['TARGET1'];
                                $TARGET2 = $objResult['TARGET2'];
                                $TARGET3 = $objResult['TARGET3'];
                                $START_TIME_DAY = $objResult['START_TIME_SHIFT_DAY'];
                                $TARGET_TIME_DAY = $objResult['TARGET_TIME_SHIFT_DAY'];
                                $START_TIME_NIGHT = $objResult['START_TIME_SHIFT_NIGHT'];
                                $TARGET_TIME_NIGHT = $objResult['TARGET_TIME_SHIFT_NIGHT'];
                                $SHIFT_DATE = $objResult['SHIFT_DATE'];
                            ?>
                                <tr align="center" class="TrTable">
                                    <th><?php echo $LINE; ?></th>
                                    <td><?php echo $TARGET1; ?></td>
                                    <td><?php echo $TARGET2; ?></td>
                                    <td><?php echo $TARGET3; ?></td>
                                    <td class="table-warning"><?php echo $START_TIME_DAY; ?></td>
                                    <td class="table-warning"><?php echo $TARGET_TIME_DAY; ?></td>
                                    <td class="table-success"><?php echo $START_TIME_NIGHT; ?></td>
                                    <td class="table-success"><?php echo $TARGET_TIME_NIGHT; ?></td>
                                    <td><?php echo $SHIFT_DATE; ?></td>
                                    <td class="ButtonEdit_shift" id="<?php echo $ID ?>">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                            <i class='fas fa-edit' style='color:white'></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Modal shift -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <input type="hidden" name="id" id="id_data_shift" class="text-center form-control">
                            <input type="hidden" name="MEMBER_ID" id="MEMBER_ID" class="text-center form-control" value="<?php echo $MEMBER_ID ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="line"></h5>
                                    <h5 class="modal-title" id="header_date_shift"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET1 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target1" id="target1" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET2 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target2" id="target2" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET3 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target3" id="target3" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-12">
                                                <label for="shift_date">SHIFT DATE</label>
                                                <input type="date" name="shift_date" id="shift_date" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                <label for="TimeStartDay">SART DAY</label>
                                                <input type="time" name="TimeStartDay" id="TimeStartDay" class="text-center form-control">
                                            </div>
                                            <div class="col-6">
                                                <label for="TimeTargetDay">CUT OFF DAY</label>
                                                <input type="time" name="TimeTargetDay" id="TimeTargetDay" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                <label for="TimeStartNight">START NIGHT</label>
                                                <input type="time" name="TimeStartNight" id="TimeStartNight" class="text-center form-control">
                                            </div>
                                            <div class="col-6">
                                                <label for="TimeTargetNight">CUT OFF NIGHT</label>
                                                <input type="time" name="TimeTargetNight" id="TimeTargetNight" class="text-center form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" data-dismiss="modal" id="save_shift" name="save_shift">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else if ($target_table == "target_day") { ?>
                    <table class="table table-striped table-bordered table-hover" id="example">
                        <thead class="thead thead-dark">
                            <tr class="text-center">
                                <!-- <th>ID</th> -->
                                <th>LINE</th>
                                <th>TECHNICIAN(MIN.)</th>
                                <th>MFE(MIN.)</th>
                                <th>PRODUCTION(MIN.)</th>
                                <th>START TIME</th>
                                <th>TARGET TIME</th>
                                <th>TOOLS
                                    <a type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal_day_add"><i class='fas fa-plus'></i></a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("connect.php");
                            date_default_timezone_set("Asia/Bangkok");
                            // QUERY FILTER
                            $strSQL = "SELECT * FROM `target_day` ORDER BY `LINE` ASC";
                            $objQuery = mysqli_query($con, $strSQL);
                            while ($objResult = mysqli_fetch_array($objQuery)) {
                                $ID = $objResult['ID'];
                                $LINE = $objResult['LINE'];
                                $TARGET1 = $objResult['TARGET1'];
                                $TARGET2 = $objResult['TARGET2'];
                                $TARGET3 = $objResult['TARGET3'];
                                $START_TIME_DAY = $objResult['START_TIME_DAY'];
                                $TARGET_TIME_DAY = $objResult['TARGET_TIME_DAY'];
                            ?>
                                <tr align="center" class="TrTable">
                                    <th><?php echo $LINE; ?></th>
                                    <td><?php echo $TARGET1; ?></td>
                                    <td><?php echo $TARGET2; ?></td>
                                    <td><?php echo $TARGET3; ?></td>
                                    <td class="table-warning"><?php echo $START_TIME_DAY; ?></td>
                                    <td class="table-success"><?php echo $TARGET_TIME_DAY; ?></td>
                                    <td class="ButtonEdit_day" id="<?php echo $ID ?>">
                                        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_day">
                                            <i class='fas fa-edit' style='color:white'></i>
                                        </a>
                                        <!-- <a type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_day_delete">
                                            <i class='fas fa-trash' style='color:white'></i>
                                        </a> -->
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Modal add day-->
                    <div class="modal fade" id="modal_day_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <h5 class="modal-title display-4 text-center" id="exampleModalLongTitle">Add period</h5>
                                <div class="modal-body">
                                    <div class="row form-group">
                                        <div class="col-6">
                                            <input type="text" class="form-control text-center" placeholder="LINE">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control text-center" placeholder="TYPE">
                                        </div>
                                    </div>
                                    <div class="text-center form-group">
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET1 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target1" id="target1" class="text-center form-control" value="30">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET2 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target2" id="target2" class="text-center form-control" value="20">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET3 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target3" id="target3" class="text-center form-control" value="20">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                <label for="start_time">START TIME</label>
                                                <input type="time" name="start_time" id="start_time" class="text-center form-control" value="20:00">
                                            </div>
                                            <div class="col-6">
                                                <label for="target_time">TARGET TIME</label>
                                                <input type="time" name="target_time" id="target_time" class="text-center form-control" value="20:00">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal day -->
                    <div class="modal fade" id="modal_day" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <input type="hidden" name="id" id="id_data_day" class="text-center form-control">
                            <input type="hidden" name="MEMBER_ID" id="MEMBER_ID" class="text-center form-control" value="<?php echo $MEMBER_ID ?>">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="line"></h5>
                                    <h5 class="modal-title" id="type"></h5>
                                    <h5 class="modal-title" id="header_date_shift"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET1 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target1" id="target1" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET2 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target2" id="target2" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                TARGET3 :
                                            </div>
                                            <div class="col-6">
                                                <input type="text" name="target3" id="target3" class="text-center form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-6">
                                                <label for="start_time">START TIME</label>
                                                <input type="time" name="start_time" id="start_time" class="text-center form-control">
                                            </div>
                                            <div class="col-6">
                                                <label for="target_time">TARGET TIME</label>
                                                <input type="time" name="target_time" id="target_time" class="text-center form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <!-- <button type="submit" class="btn btn-primary" id="save_shift" name="save_shift">Save changes</button> -->
                                        <button type="submit" class="btn btn-primary" data-dismiss="modal" id="save_day" name="save_day">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end -->

                        <!-- end Modal add day -->
                    <?php } ?>
                    </div>
            </div>
            <!-- END TABLE -->
    </section>
    <!-- Main -->

</body>

</html>

<script>
    $(document).ready(function() {
        $(".ButtonEdit_shift").click(function() {
            var data = table.row(this).data();
            console.log(data)
            console.log(data[4])
            console.log(data[6])
            $("#line").html(data[0]);
            $("#target1").val(data[1]);
            $("#target2").val(data[2]);
            $("#target3").val(data[3]);
            $("#shift_date").val(data[8]);

            $("#TimeStartDay").attr({
                // "min": data[7],
                // "max": data[5],
                "value": data[4]
            });

            $("#TimeTargetDay").attr({
                // "min": data[4],
                // "max": data[6],
                "value": data[5]
            });

            $("#TimeStartNight").attr({
                // "min": data[5],
                // "max": data[7],
                "value": data[6]
            });

            $("#TimeTargetNight").attr({
                // "min": data[6],
                // "max": data[4],
                "value": data[7]
            });

            $("#header_date_shift").html("_" + data[8]);
            $("#id_data_shift").val(this.id);
        })

        $(".ButtonEdit_day").click(function() {
            var data = table.row(this).data();
            console.log(data)
            $("#line").html(data[0]);
            $("#type").html("[" + data[1] + "]");
            $("#target1").val(data[2]);
            $("#target2").val(data[3]);
            $("#target3").val(data[4]);

            $("#start_time").val(data[5]);
            // $("#start_date").val(data[5]);
            $("#target_time").val(data[6]);
            // $("#target_date").val(data[7]);
            $("#id_data_day").val(this.id);
        })

        $("#save_shift").click(function() {
            var data = {
                "target1": $("#target1").val(),
                "target2": $("#target2").val(),
                "target3": $("#target3").val(),
                "TimeStartDay": $("#TimeStartDay").val(),
                "TimeTargetDay": $("#TimeTargetDay").val(),
                "TimeStartNight": $("#TimeStartNight").val(),
                "TimeTargetNight": $("#TimeTargetNight").val(),
                "shift_date": $("#shift_date").val(),
                "id": $("#id_data_shift").val()
            };

            $.ajax({
                type: "POST",
                url: "start_cutoff_save_shift.php",
                data: data,
                // dataType: 'JSON',
                success: function(result) {
                    if (result == 'ok') {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function() {
                            reload()
                        })
                    } else {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'error',
                            title: 'Your have problem in save',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function() {
                            reload()
                        })
                    }
                }
            });
        })

        $("#save_day").click(function() {
            var data = {
                "target1": $("#target1").val(),
                "target2": $("#target2").val(),
                "target3": $("#target3").val(),
                "start_time": $("#start_time").val(),
                // "start_date": $("#start_date").val(),
                "target_time": $("#target_time").val(),
                // "target_date": $("#target_date").val(),
                "id": $("#id_data_day").val()
            };

            $.ajax({
                type: "POST",
                url: "start_cutoff_save_day.php",
                data: data,
                // dataType: 'JSON',
                success: function(result) {
                    if (result == 'ok') {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function() {
                            reload()
                        })
                    } else {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'error',
                            title: 'Your have problem in save',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(function() {
                            // reload()
                        })
                    }
                }
            });
        })

        var table = $('#example').DataTable({
            paging: false,
            responsive: true,
            // "searching": false
        });

        window.addEventListener('scroll', (e) => {
            const nav = document.querySelector('.navbar');
            if (window.pageYOffset > 0) {
                nav.classList.add("shadow");
            } else {
                nav.classList.remove("shadow");
            }
        });
    });

    function goBack() {
        window.history.back();
    }

    function toJSONLocal(date) {
        var local = new Date(date);
        local.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        return local.toJSON().slice(0, 10);
    }

    function reload() {
        location.reload();
    }

    function getDateTime() {
        var now = new Date();
        var year = now.getFullYear();
        var month = now.getMonth() + 1;
        var day = now.getDate();
        var hour = now.getHours("H");
        var minute = now.getMinutes();
        var second = now.getSeconds();
        if (month.toString().length == 1) {
            month = '0' + month;
        }
        if (day.toString().length == 1) {
            day = '0' + day;
        }
        if (hour.toString().length == 1) {
            hour = '0' + hour;
        }
        if (minute.toString().length == 1) {
            minute = '0' + minute;
        }
        if (second.toString().length == 1) {
            second = '0' + second;
        }
        // var dateTime = hour + ':' + minute + ':' + second; 
        var dateTime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
        return dateTime;
    }
    // example usage: realtime clock
    setInterval(function() {
        currentTime = getDateTime();
        document.getElementById("clock").innerHTML = currentTime;
        // console.log(currentTime);
    }, 1000);
</script>