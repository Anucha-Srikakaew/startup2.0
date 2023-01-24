<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP CHECK</title>

    <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">


    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">


    <style>
        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
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
    $MEMBER_ID = $_GET['MEMBER_ID'];
    ?>


</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
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
                <a id="back1" class="nav-link " style="color:white;" href="#" onclick="backtohome()">LOGOUT</a>
            </div>
        </div>
    </nav><br>

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
    </section>
    <!-- Header -->

    <div class="row text-center">
        <div class="col-sm-6">
            <!-- <h1 class='text-dark font-weight-bold'>ITEM</h1>
            <p class="lead">
                <a href="http://43.72.52.206/excel_body/item/item.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>">Production</a> || 
                <a href="http://43.72.52.206/excel_body/center/item.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>">Center</a>
            </p> -->
            <a href="http://43.72.52.206/excel_body/item/item.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>">
                <h1 class='text-dark font-weight-bold'>ITEM</h1>
            </a>
        </div>
        <div class="col-sm-6">
            <a href="member.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>">
                <h1 class='text-dark font-weight-bold'>MEMBER</h1>
            </a>
        </div>
    </div>
    <br><br><br><br>
    <div class="row text-center">
        <div class="col-sm-6">
            <a href="line.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>">
                <h1 class='text-dark font-weight-bold'>LINE NAME</h1>
            </a>
        </div>
        <div class="col-sm-6">
            <a href="start_cutoff.php?MEMBER_ID=<?php echo $MEMBER_ID; ?>&target_table=target_shift">
                <h1 class='text-dark font-weight-bold'>START&CUT OFF TIME</h1>
            </a>
        </div>
    </div>


</body>

</html>