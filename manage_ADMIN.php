<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>STARTUP CHECK</title>

    <link rel="icon" href="framework/img/logo/s_logo.png" type="image/png" sizes="16x16">

    <!-- Bootstrap core CSS -->
    <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="framework/css/scrolling-nav.css" rel="stylesheet">
    <script src="framework/js/bootstrap.min.js"></script>

    <!-- w3 school CSS -->
    <link rel="stylesheet" href="framework/css/w3.css">

    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.12.4.js"></script>
    <script src="js/jquery-ui.js"></script>

    <style>
        input[type=text], input[type=password] 
        {
          width: 100%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          box-sizing: border-box;
        } 
        input[type=button], input[type=submit] 
        {
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
            <div class="col-sm-4">
                <a href="biz.php?MEMBER_ID=<?php echo $MEMBER_ID;?>">
                    <h1 class='text-dark font-weight-bold'>BIZ</h1>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="item.php?MEMBER_ID=<?php echo $MEMBER_ID;?>">
                    <h1 class='text-dark font-weight-bold'>ITEM</h1>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="member.php?MEMBER_ID=<?php echo $MEMBER_ID;?>">
                    <h1 class='text-dark font-weight-bold'>MEMBER</h1>
                </a>
            </div>
        </div>


</body>

</html>
