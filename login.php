<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>STARTUP 2.0</title>

  <link rel="icon" href="framework/img/SMART_LOGO.png" type="image/png" sizes="16x16">

  <!-- Bootstrap core CSS -->
  <link href="framework/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="framework/css/scrolling-nav.css" rel="stylesheet">

  <!-- w3 school CSS -->
  <link rel="stylesheet" href="framework/vendor/bootstrap/css/w3.css">



  <style>
    input[type=text],
    input[type=password] {
      width: 50%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    input[type=submit] {
      width: 50%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
  </style>

  <?php
  include("event_shift.php");
  if (empty($_GET['text'])) {
    $text = 'LOGIN TO SYSTEM';
  } else {
    $text = $_GET['text'];
  }
  ?>


</head>
<?php
$BIZ = $_GET['BIZ'];
if (isset($_GET['CENTER'])) {
  $CENTER = 'CENTER';
} else {
  $CENTER = 'PRODUCTION';
}
?>

<body id="page-top">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="http://43.72.52.52/system/">SONY</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="http://43.72.52.51/startup2.0/">HOME <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item active">
          <a id="nav-startup" class="nav-link" href="http://43.72.52.51/startup2.0/visual.php?BIZ=BODY">STARTUP</a>
        </li>
      </ul>
      <div class="form-inline my-2 my-lg-0 ">
      </div>
    </div>
  </nav>

  <!-- Login form -->
  <form action="check_login.php" method="post" name="form" onSubmit="JavaScript:return fncSubmit();">

    <script language="javascript">
      function fncSubmit() {
        if (document.form.username.value == "") {
          alert('Please enter Username');
          document.form.username.focus();
          return false;
        }
        if (document.form.password.value == "") {
          alert('Please enter Password');
          document.form.password.focus();
          return false;
        }
        document.form.submit();
      }
    </script>

    <section id="login">
      <div class="container">
        <div class="row text-center">
          <div class="col-lg-12 mx-auto">
            <h1><b>SMART STARTUP CHECK</b></h1><BR><BR>
          </div>
          <div class="col-lg-12 mx-auto">
            <h4><?php echo $text; ?></h4><BR>
            <input type="text" name="username" id="username" placeholder="USERNAME" autofocus>
            <input type="hidden" name="CENTER" id="CENTER" placeholder="USERNAME" value="<?php echo $CENTER ?>">
            <br><br>
            <input type="password" name="password" id="password" placeholder="PASSWORD"><br><br>
            Not registered? Please contact to <a href="/system">System Team</a>
            <br><br>
            <input class="btn btn-dark" name="login" type="submit" value="LOGIN">
          </div>
        </div>
      </div>
    </section>
    <!-- End Login form -->

  </form>
</body>

</html>