<?php include("connect.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jig/Nejiko</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
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
                        <a class="nav-link" href="index.php">Monitor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="edit.php">Upload</a>
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
            <h1>JIG/NEJIKO DATA</h1>
            <p class="lead">Upload data for check jig/nejiko.</p>
        </div>
    </div><br><br>

    <div class="container-fluid">

        <div class="row">
            <div class="col">
                <h5 for="btn_file_jig">JIG UPLOAD</h5>
                <button type="button" class="btn btn-outline-success" id="btn_file_jig">
                    <input type="file" id="jig_file" name="tbl_jig_register">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                        <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2z" />
                    </svg>
                </button>
                <br><br>
                <table id="example1" style="width:100%" class="table table-bordered shadow border border-light table-striped table-hover">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>Line</th>
                            <th>Model</th>
                            <th>Process id</th>
                            <th>Jig name</th>
                            <th>Jig id</th>
                            <th>Tool</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT `ID`, `LINENAME`, `MODEL`, `PROCESSNAME`, `PROCESSID`, `JIGNAME`, `JIGID`, `DATETIME` FROM `tbl_jig_register` WHERE 1";
                        $query = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                            $LINENAME = $row["LINENAME"];
                            $MODEL = $row["MODEL"];
                            $PROCESSID = $row["PROCESSID"];
                            $JIGNAME = $row["JIGNAME"];
                            $JIGID = $row["JIGID"];
                            $ID = $row["ID"];
                        ?>
                            <tr class="text-center">
                                <td><?php echo $LINENAME ?></td>
                                <td><?php echo $MODEL ?></td>
                                <td><?php echo $PROCESSID ?></td>
                                <td><?php echo $JIGNAME ?></td>
                                <td><?php echo $JIGID ?></td>
                                <td><button class="btn btn-sm btn-outline-danger" name="tbl_jig_register" id="<?php echo $ID ?>" onclick="delete_db(this.name, this.id)">Delete</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h5 for="btn_file_nejiko">NIJIKO UPLOAD</h5>
                <button type="button" class="btn btn-outline-success" id="btn_file_nejiko">
                    <input type="file" id="nejiko_file" name="tbl_nejiko_register">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                        <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2z" />
                    </svg>
                </button>
                <br><br>
                <table id="example2" style="width:100%" class="table table-bordered shadow border border-light table-striped table-hover">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>Line</th>
                            <th>Model</th>
                            <th>Process id</th>
                            <th>Nejiko name</th>
                            <th>Nejiko id</th>
                            <th>Tool</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT `ID`, `LINENAME`, `MODEL`, `PROCESSNAME`, `PROCESSID`, `NEJIKONAME`, `NEJIKOID`, `DATETIME` FROM `tbl_nejiko_register` WHERE 1";
                        $query = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                            $LINENAME = $row["LINENAME"];
                            $MODEL = $row["MODEL"];
                            $PROCESSID = $row["PROCESSID"];
                            $NEJIKONAME = $row["NEJIKONAME"];
                            $NEJIKOID = $row["NEJIKOID"];
                            $ID = $row["ID"];

                            $sql2 = "SELECT `ID`, `LINENAME`, `MODEL`, `PROCESSNAME`, `PROCESSID`, `JIGNAME`, `JIGID`, `DATETIME`
                            FROM `tbl_jig_register` WHERE `LINENAME` = '$LINENAME' AND `MODEL` = '$MODEL' AND `PROCESSID` = '$PROCESSID'";
                            $query2 = mysqli_query($con, $sql2);
                            $row2 = mysqli_fetch_array($query2, MYSQLI_ASSOC);
                            $JIGID = $row2["JIGID"];
                        ?>
                            <tr class="text-center">
                                <td><?php echo $LINENAME ?></td>
                                <td><?php echo $MODEL ?></td>
                                <td><?php echo $PROCESSID ?></td>
                                <td><?php echo $NEJIKONAME ?></td>
                                <td><?php echo $NEJIKOID ?></td>
                                <td><button class="btn btn-sm btn-outline-danger" name="tbl_nejiko_register" id="<?php echo $ID ?>" onclick="delete_db(this.name, this.id)">Delete</button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
    $('#example1').DataTable();
    $('#example2').DataTable();

        $("#jig_file").change(function() {
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            formData.append('table', this.name);

            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(data) {
                    // console.log(data);
                    // alert(data);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.reload();
                    })
                }
            })
        })

        $("#nejiko_file").change(function() {
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            formData.append('table', this.name);

            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false, // tell jQuery not to set contentType
                success: function(data) {
                    // console.log(data);
                    // alert(data);

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: data,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.reload();
                    })
                }
            })
        })
    })

    function delete_db(table, id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete.php',
                    type: 'POST',
                    data: {
                        "table": table,
                        "id": id,
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            timer: 1000
                        }).then(function() {
                            window.location.reload();
                        })
                    }
                })
            }
        })
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
        var dateTime = year + '-' + month + '-' + day + ' ' + hour + ':' + minute + ':' + second;
        return dateTime;
    }
    // example usage: realtime clock
    setInterval(function() {
        currentTime = getDateTime();
        document.getElementById("clock").innerHTML = currentTime;
    }, 1000);
</script>