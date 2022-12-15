<?php
include("connect.php");
// $MEMBER_ID = $_GET["MEMBER_ID"];
if (isset($_GET["MEMBER_ID"])) {
    $MEMBER_ID = $_GET["MEMBER_ID"];
    $sql_member = 'SELECT * FROM `member` WHERE `MEMBER_ID` = "' . $MEMBER_ID . '"';
    $query_member = mysqli_query($con, $sql_member);
    $row_member = mysqli_fetch_array($query_member);
    if (isset($row_member)) {
        if ($row_member["TYPE"] == 'PIC') {
            // status OK
            $BIZ = $row_member["BIZ"];
            if ($BIZ == 'BODY') {
                $BIZ = 'IM';
            }

            // if (isset($_GET["LINE_CENTER"])) {
            //     $CENTER = $_GET["LINE_CENTER"];
            // } else {
            //     header('Location: http://43.72.52.51/startup2.0/line.php?MEMBER_ID=' . $MEMBER_ID . '');
            // }
        } else {
            header('Location: http://43.72.52.51/startup2.0/login.php');
        }
    } else {
        header('Location: http://43.72.52.51/startup2.0/login.php');
    }
} else {
    header('Location: http://43.72.52.51/startup2.0/login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=!, initial-scale=1.0">
    <title>STARTUP LINE</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

    <script src="framework/js/jquery-1.12.4.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">

    <script src="framework/js/a076d05399.js"></script>

    <script src="framework/js/sweetalert2@9.js"></script>

    <style>
        table {
            text-align: left;
            position: relative;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.25rem;
        }

        tr.red th {
            background: red;
            color: white;
        }

        tr.green th {
            background: green;
            color: white;
        }

        tr.purple th {
            background: purple;
            color: white;
        }

        th {
            background: white;
            position: sticky;
            top: 0;
            box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body>

    <?php
    include("connect.php");
    $MEMBER_ID = $_GET["MEMBER_ID"];

    if (isset($_GET["search_type"])) {
        $show_type = $_GET["search_type"];
    } else {
        $show_type = '';
    }
    ?>

    <!-- Navbar -->
    <nav class="fixed-top navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="http://43.72.52.52/system/">SONY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="http://43.72.52.51/startup2.0/">HOME <span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <div class="form-inline my-2 my-lg-0 ">
                <a id="back1" class="nav-link " style="color:white;" href="http://43.72.52.51/startup2.0/manage_PIC.php?MEMBER_ID=<?php echo $MEMBER_ID ?>">BACK</a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section id="main">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b>STARTUP CHECK SYSTEM</b></h1>
                    <p class="lead">Manage the data over all startup check project.</p><br><br>
                </div>
            </div>
        </div>
        <!-- Header -->

        <div class="container">
            <form action="" method="get" id="form_search">
                <input type="hidden" name="MEMBER_ID" value="<?php echo $MEMBER_ID ?>">
                <label for="search_type">SHOW TYPE :</label>
                <select class="text-center" name="search_type" id="search_type">
                    <?php if ($show_type == "PRODUCTION") {
                        echo '<option value="PRODUCTION">PRODUCTION</option>';
                        echo '<option value="">ALL</option>';
                        echo '<option value="CENTER">CENTER</option>';
                    } else if ($show_type == "CENTER") {
                        echo '<option value="CENTER">CENTER</option>';
                        echo '<option value="">ALL</option>';
                        echo '<option value="PRODUCTION">PRODUCTION</option>';
                    } else {
                        echo '<option value="">ALL</option>';
                        echo '<option value="CENTER">CENTER</option>';
                        echo '<option value="PRODUCTION">PRODUCTION</option>';
                    } ?>
                </select>
            </form>
        </div>

        <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">BIZ.</th>
                        <th scope="col">LINE NAME</th>
                        <th scope="col">TYPE</th>
                        <th scope="col">LastUpdate</th>
                        <th scope="col">
                            TOOL
                            <a href="#add_input" id="add_line">
                                <i class='fas fa-plus' style='color:black'></i>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `startup_line` WHERE `TYPE` LIKE '%$show_type%' ORDER BY `LINE` ASC";
                    $query = mysqli_query($con, $sql);
                    $i = 1;
                    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    ?>
                        <tr class="text-center">
                            <th scope="row"><?php echo $i ?></th>
                            <td><?php echo $row["BIZ"] ?></td>
                            <td>
                                <?php
                                if ($row["TYPE"] == "CENTER") {
                                    echo '<a href="line_model.php?LINE_CENTER=' . $row["LINE"] . '&MEMBER_ID=' . $MEMBER_ID . '">' . $row["LINE"] . '</a>';
                                } else {
                                    echo $row["LINE"];
                                }
                                ?>
                            </td>
                            <td>
                                <select class="form-control text-center type" id="<?php echo $row["ID"] ?>">
                                    <?php if ($row["TYPE"] == "PRODUCTION") {
                                        echo '<option value="PRODUCTION">PRODUCTION</option>';
                                        echo '<option value="CENTER">CENTER</option>';
                                    } else if ($row["TYPE"] == "CENTER") {
                                        echo '<option value="CENTER">CENTER</option>';
                                        echo '<option value="PRODUCTION">PRODUCTION</option>';
                                    } ?>
                                    <!-- <option value="CENTER">CENTER</option> -->
                                </select>
                            </td>
                            <td><?php echo $row["LastUpdate"] ?></td>
                            <td>
                                <!-- <a href="#" id="" class="edit">
                                    <i class='fas fa-edit' style='color:blue'></i>
                                </a> -->
                                &nbsp; &nbsp;
                                <a href="#" id="<?php echo $row["ID"] ?>" class="delete">
                                    <i class='fas fa-trash' style='color:red'></i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div><br>

        <div class="container">
            <label for="add_input" class="bg-warning">NEW LINE</label>
            <div id="add_input" class="jumbotron text-center">
                <div class="row form-group">
                    <div class="col-3">
                        <label for="biz">BUSINESS</label>
                        <input type="text" class="form-control text-center" id="biz" name="biz" value="IM">
                    </div>
                    <div class="col-3">
                        <label for="line">LINE NAME</label>
                        <input placeholder="LINE NAME" type="text" class="form-control text-center" id="line" name="line">
                    </div>
                    <div class="col-3">
                        <label for="type">TYPE</label>
                        <!-- <input type="text" class="form-control text-center" id="type" name="type"> -->
                        <select class="form-control text-center" name="type" id="type">
                            <option value="PRODUCTION">PRODUCTION</option>
                            <option value="CENTER">CENTER</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="LastUpdate">LastUpdate</label>
                        <input type="text" class="form-control text-center" id="LastUpdate" name="LastUpdate">
                    </div>
                </div>
                <div class="row text-center form-group">
                    <div class="col-12">
                        <input type="button" value="SAVE" class="btn btn-primary" id="save">
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
<script>
    $("#search_type").change(function() {
        // document.getElementById("form_search").submit();
        $("#form_search").submit();
    })
    $(".type").change(function() {
        var id = this.id;
        console.log(this.id)
        console.log(this.value)
        $.ajax({
            type: "POST",
            url: "line_update.php",
            data: {
                'id': id,
                'type': this.value
            },
            success: function(result) {
                // console.log(result)
                if (result == "1") {
                    Swal.fire({
                        // position: 'top-end',
                        icon: 'success',
                        title: 'Change type complete',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        reload()
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Change type problem please contact system team.',
                        // footer: '<a href="">Why do I have this issue?</a>'
                    }).then(function() {
                        reload()
                    })
                }
            }
        });
    })
    $(".delete").click(function() {
        var id = this.id;
        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: 'Do you want to delete the line?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: 'Cancel',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "line_delete.php",
                    data: {
                        'id': id
                    },
                    success: function(result) {
                        if (result == "success") {
                            Swal.fire({
                                // position: 'top-end',
                                icon: 'success',
                                title: 'Dlete line complete',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                reload()
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Delete line problem please contact system team.',
                                // footer: '<a href="">Why do I have this issue?</a>'
                            }).then(function() {
                                reload()
                            })
                        }
                    }
                });
            } else {
                Swal.fire('Changes are not deleted', '', 'info')
            }
        })
    })

    $("#save").click(function() {
        var data = {
            'biz': document.getElementById("biz").value,
            'line': document.getElementById("line").value,
            'type': document.getElementById("type").value,
            'LastUpdate': document.getElementById("LastUpdate").value
        }
        console.log(data);
        if (data["line"] == '') {
            Swal.fire(
                'Save problem!?',
                'Please input line name.',
                'question'
            )
        } else {
            $.ajax({
                type: "POST",
                url: "line_save.php",
                data: data,
                // dataType: 'JSON',
                success: function(result) {
                    if (result == "success") {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: 'Save line complete',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            reload()
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Save line problem please contact system team.',
                            // footer: '<a href="">Why do I have this issue?</a>'
                        }).then(function() {
                            reload()
                        })
                    }
                }
            });
        }
    })

    $("#add_line").click(function() {
        $("#add_input").show()
        console.log("dasadasdas")
    })

    // defult time
    setInterval(function() {
        currentTime = getDateTime();
        document.getElementById("LastUpdate").value = currentTime;
    }, 1000);

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
        var dateTime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
        return dateTime;
    }

    function reload() {
        location.reload();
    }
</script>