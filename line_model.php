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
            if ($BIZ == 'IM') {
                $BIZ = 'IM';
            }

            if (isset($_GET["LINE_CENTER"])) {
                $CENTER = $_GET["LINE_CENTER"];
            } else {
                header('Location: http://43.72.52.51/startup2.0/line.php?MEMBER_ID=' . $MEMBER_ID . '');
            }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODEL <?php echo $_GET["LINE_CENTER"] ?></title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

    <script src="framework/js/jquery-1.12.4.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">

    <script src="framework/js/a076d05399.js"></script>

    <script src="framework/js/sweetalert2@9.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
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
                <a id="back1" class="nav-link " style="color:white;" href="http://43.72.52.51/startup2.0/line.php?MEMBER_ID=<?php echo $MEMBER_ID ?>&search_type=CENTER">BACK</a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <section>
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-12 mx-auto">
                    <h1><b><?php echo $CENTER ?></b></h1>
                    <p class="lead">Manage the data over all startup check project.</p><br><br>
                </div>
            </div>
        </div>
        <!-- Header -->

        <div class="container">
            <table class="table table-hover" id="example">
                <thead>
                    <tr class="text-center">
                        <th scope="col">#</th>
                        <th scope="col">BIZ.</th>
                        <th scope="col">MODEL</th>
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
                    $sql = "SELECT * FROM `model_center` WHERE `CENTER` LIKE '%$CENTER%' ORDER BY `MODEL` ASC";
                    $query = mysqli_query($con, $sql);
                    $i = 1;
                    while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                    ?>
                        <tr class="text-center">
                            <th scope="row"><?php echo $i ?></th>
                            <td scope="row"><?php echo $row["BIZ"] ?></td>
                            <td scope="row"><?php echo $row["MODEL"] ?></td>
                            <td scope="row"><?php echo $row["LastUpdate"] ?></td>
                            <td>
                                <!-- <a href="#" id="" class="edit">
                                    <i class='fas fa-edit' style='color:blue'></i>
                                </a> -->
                                <a href="#" id="<?php echo $row["ID"] ?>" class="delete">
                                    <i class='fas fa-trash' style='color:red'></i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
            </table>
        </div><br><br>

        <div class="container">
            <label for="add_input" class="bg-warning">ADD MODEL</label>
            <div id="add_input" class="jumbotron text-center">
                <div class="row form-group">
                    <div class="col-12">
                        <label for="model">MODEL NAME : </label>
                        <input type="text" class="text-center" id="model" name="model">
                        <input type="button" value="ADD MODEL" class="btn-primary btn-sm" id="save">
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>

<script>
    $(document).ready(function() {
        $('#example').DataTable({
            'iDisplayLength': 100
        });
    });

    $("#save").click(function() {
        var data = {
            "model": $("#model").val(),
            "center": "<?php echo $CENTER ?>",
            "biz": "<?php echo $BIZ ?>",
        }

        if (data.model !== '') {
            $.ajax({
                type: "POST",
                url: "line_model_add.php",
                data: data,
                success: function(result) {
                    if (result == "1") {
                        Swal.fire({
                            // position: 'top-end',
                            icon: 'success',
                            title: 'Add model complete',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Add model problem please contact system team.',
                            // footer: '<a href="">Why do I have this issue?</a>'
                        }).then(function() {
                            location.reload();
                        })
                    }
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: 'Please file model name.',
                // footer: '<a href="">Why do I have this issue?</a>'
            }).then(function() {
                location.reload();
            })
        }

        console.log(data)
    })

    $(".delete").click(function() {
        console.log(this.id)

        Swal.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: 'Do you want to delete the model?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            denyButtonText: 'Cancel',
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "line_model_del.php",
                    data: {
                        "id": this.id
                    },
                    success: function(result) {
                        if (result == "1") {
                            Swal.fire({
                                // position: 'top-end',
                                icon: 'success',
                                title: 'Delete model complete',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                location.reload();
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Delete model problem please contact system team.',
                                // footer: '<a href="">Why do I have this issue?</a>'
                            }).then(function() {
                                location.reload();
                            })
                        }
                    }
                });
            } else {
                Swal.fire('Changes are not deleted', '', 'info')
            }
        })
    })
</script>