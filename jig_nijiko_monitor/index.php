<?php include("connect.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jig/Nejiko</title>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    $now = date("H");
    // get date 
    $date = date("Y-m-d");
    if (isset($_GET["date"])) {
        $date = $_GET["date"];
    }

    // get shift 
    $shift = "DAY";
    if (isset($_GET["shift"])) {
        $shift = $_GET["shift"];
    }

    // get line
    $line = "LINE";
    $line_val = "";
    if (isset($_GET["line"])) {
        if ($_GET["line"] != "") {
            $line = $_GET["line"];
            $line_val = $_GET["line"];
        }
    }

    // get model
    $model = "MODEL";
    $model_val = "";
    if (isset($_GET["model"])) {
        if ($_GET["model"] != "") {
            $model = $_GET["model"];
            $model_val = $_GET["model"];
        }
    }

    $day = "";
    $night = "";
    if ($shift == "DAY") {
        $day = "selected";
    } else {
        $night = "selected";
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="http://43.72.52.52/system/img/sony/sony%20logo%20white.png" alt="" width="80" height="15">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Monitor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="edit.php">Upload</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <a id="clock" name="clock"></a>
                </span>
            </div>
        </div>
    </nav>
    <br><br>

    <div class="container">
        <div class="text-center">
            <h1>JIG/NIJIKO</h1>
            <p class="lead">Monitor jig/nejiko check maching with process in production.</p>
            <br>
            <form action="" method="get">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <input type="date" name="date" class="form-control text-center shadow border border-light" value="<?php echo $date ?>">
                        </div>
                        <div class="col">
                            <select name="shift" class="form-control text-center shadow border border-light">
                                <option value="DAY" <?php echo $day ?>>DAY</option>
                                <option value="NIGHT" <?php echo $night ?>>NIGHT</option>
                            </select>
                        </div>
                        <div class="col">
                            <select name="line" class="form-control text-center shadow border border-light">
                                <?php if ($line_val == "") { ?>
                                    <option value="" selected>ALL LINE</option>
                                <?php } else { ?>
                                    <option value="" selected>ALL LINE</option>
                                    <option value="<?php echo $line ?>" selected><?php echo $line ?></option>
                                <?php } ?>

                                <?php
                                $sql = "SELECT DISTINCT `LINENAME` FROM `tbl_jig_register` WHERE `LINENAME` != '$line_val' ORDER BY `LINENAME`";
                                $query = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                                    <option value="<?php echo $row["LINENAME"]; ?>"><?php echo $row["LINENAME"]; ?></option>
                                <?php } ?>

                                <?php
                                $sql = "SELECT DISTINCT `tbl_nejiko_register`.`LINENAME` AS `LINENAME` FROM `tbl_jig_register`,`tbl_nejiko_register` WHERE `tbl_nejiko_register`.`LINENAME` != '$line_val' AND `tbl_jig_register`.`LINENAME` != `tbl_nejiko_register`.`LINENAME` ORDER BY `LINENAME`";
                                $query = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                                    <option value="<?php echo $row["LINENAME"]; ?>"><?php echo $row["LINENAME"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <select name="model" class="form-control text-center shadow border border-light">
                                <?php if ($model_val == "") { ?>
                                    <option value="" selected>ALL MODEL</option>
                                <?php } else { ?>
                                    <option value="" selected>ALL MODEL</option>
                                    <option value="<?php echo $model ?>" selected><?php echo $model ?></option>
                                <?php } ?>
                                <?php
                                $sql = "SELECT DISTINCT `MODEL` FROM `tbl_jig_register` WHERE `MODEL` != '$model_val' ORDER BY `MODEL`";
                                $query = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                                    <option value="<?php echo $row["MODEL"]; ?>"><?php echo $row["MODEL"]; ?></option>
                                <?php } ?>

                                <?php
                                $sql = "SELECT DISTINCT `tbl_nejiko_register`.`MODEL` AS `MODEL` FROM `tbl_jig_register`,`tbl_nejiko_register` WHERE `tbl_nejiko_register`.`MODEL` != '$model_val' AND `tbl_jig_register`.`MODEL` != `tbl_nejiko_register`.`MODEL` ORDER BY `MODEL`";
                                $query = mysqli_query($con, $sql);
                                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { ?>
                                    <option value="<?php echo $row["MODEL"]; ?>"><?php echo $row["MODEL"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="submit" class="btn btn-primary form-control text-center shadow border border-light" value="SEARCH">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br><br>

    <?php
    if ($shift == "DAY") {
        $query_period = "`LastUpdate` BETWEEN '$date 08:00:00' AND '$date 19:59:59'";
    } else {
        $date1 = $date;
        $date2 = date("Y-m-d", strtotime("+1 days", strtotime($date)));

        $query_period = "`LastUpdate` BETWEEN '$date1 20:00:00' AND '$date2 07:59:59'";
    }

    $sql = "SELECT COUNT(`ID`) AS TOTAL FROM `tbl_jig_nijiko_result` WHERE `LINENAME` LIKE '%$line_val%' AND MODEL LIKE '%$model_val%' AND `TYPE` = 'JIG' AND $query_period";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $total_result_jig = $row["TOTAL"];

    $sql = "SELECT COUNT(`ID`) AS TOTAL FROM `tbl_jig_nijiko_result` WHERE `LINENAME` LIKE '%$line_val%' AND MODEL LIKE '%$model_val%' AND `TYPE` = 'NEJIKO' AND $query_period";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $total_result_nejiko = $row["TOTAL"];

    $sql = "SELECT COUNT(*) AS TOTAL 
            FROM (SELECT COUNT(`TYPE`) AS COUNT_TYPE 
                  FROM (SELECT `PROCESSID`, `TYPE` FROM `tbl_jig_nijiko_result` WHERE `LINENAME` LIKE '%$line_val%' AND MODEL LIKE '%$model_val%' AND $query_period GROUP BY `PROCESSID`, `TYPE`) AS TBL GROUP BY PROCESSID) AS TBL2 WHERE TBL2.COUNT_TYPE > 1";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $total_result_process = $row["TOTAL"];

    $sql = "SELECT COUNT(`ID`) AS TOTAL FROM `tbl_jig_register` WHERE `LINENAME` LIKE '%$line_val%' AND `MODEL` LIKE '%$model_val%'";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $total_register_jig = $row["TOTAL"];

    $sql = "SELECT COUNT(`ID`) AS TOTAL FROM `tbl_nejiko_register` WHERE `LINENAME` LIKE '%$line_val%' AND `MODEL` LIKE '%$model_val%'";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    $total_register_nejiko = $row["TOTAL"];
    ?>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4 item-center">
            <div class="col">
                <div class="card h-100 shadow border border-light">
                    <div class="card-body text-center">
                        <h4 class="card-title"><b>JIG</b></h4>
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-text"><?php echo $total_result_jig; ?></h3>
                                <b>CHECKED</b>
                            </div>
                            <div class="col-6">
                                <h3 class="card-text"><?php echo $total_register_jig ?></h3>
                                <b>TOTAL</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow border border-light">
                    <div class="card-body text-center">
                        <h4 class="card-title"><b>NIJIKO</b></h4>
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-text"><?php echo $total_result_nejiko; ?></h3>
                                <b>CHECKED</b>
                            </div>
                            <div class="col-6">
                                <h3 class="card-text"><?php echo $total_register_nejiko ?></h3>
                                <b>TOTAL</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col">
                <div class="card h-100 shadow border border-light">
                    <div class="card-body text-center">
                        <h5 class="card-title"><b>PROCESS</b></h5>
                        <div class="row">
                            <div class="col-6">
                                <b>CHECKED</b><br>
                                <p class="card-text"><?php echo $total_result_process; ?></p>
                            </div>
                            <div class="col-6">
                                <b>TOTAL</b><br>
                                <p class="card-text">100</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <br><br>

        <table id="example" style="width:100%" class="table table-bordered shadow border border-light table-striped table-hover">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Date Time</th>
                    <th>Machine</th>
                    <th>Line</th>
                    <th>Model</th>
                    <th>Process Name</th>
                    <!-- <th>Name Check</th> -->
                    <th>Id Check</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT `ID`, `LastUpdate`, `TYPE`, `LINENAME`, `MODEL`, `PROCESSID`, `IDCHECK`, `RESULT` 
                FROM `tbl_jig_nijiko_result` WHERE `LINENAME` LIKE '%$line_val%' AND `MODEL` LIKE '%$model_val%' AND $query_period";
                $query = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    $LastUpdate = $row["LastUpdate"];
                    $TYPE = $row["TYPE"];
                    $LINENAME = $row["LINENAME"];
                    $MODEL = $row["MODEL"];
                    $PROCESSID = $row["PROCESSID"];
                    $IDCHECK = $row["IDCHECK"];
                ?>
                    <tr class="text-center">
                        <td><?php echo $LastUpdate ?></td>
                        <td><?php echo $TYPE ?></td>
                        <td><?php echo $LINENAME ?></td>
                        <td><?php echo $MODEL ?></td>
                        <td><?php echo $PROCESSID ?></td>
                        <td><?php echo $IDCHECK ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            paging: false
        });
    });

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
    // example usage: realtime clock
    setInterval(function() {
        currentTime = getDateTime();
        document.getElementById("clock").innerHTML = currentTime;
    }, 1000);
</script>