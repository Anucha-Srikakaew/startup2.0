<?php

require_once("connect.php");

////////////IP ADRESS////////////////
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $IP = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from remote address
else {
  $IP = $_SERVER['REMOTE_ADDR'];
}
echo $IP;


$username = $_POST['username'];
$password = $_POST['password'];
$CENTER = $_POST['CENTER'];

echo $strSQL = "SELECT * FROM `member` WHERE `MEMBER_ID` = '$username' AND `PASSWORD` = '$password'";
$objQuery = mysqli_query($con, $strSQL);
$objResult = mysqli_fetch_array($objQuery);

$MEMBER_ID = $objResult['MEMBER_ID'];
$NAME = $objResult['NAME'];
$TYPE = $objResult['TYPE'];

if (empty($objResult)) {
  $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`, `LastUpdate`, `STATUS`) VALUES (NULL, '$username', '$password', '$IP', 'LOGIN', CURRENT_TIMESTAMP, 'FAIL');";
  $objQuery = mysqli_query($con, $strSQL);
  echo $text = "<h4 class='text-danger font-weight-bold'>THIS USER NO AUTHORIZED</h4>";
  header("Location: login.php?text=$text");
} else {
  $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'LOGIN', CURRENT_TIMESTAMP, 'SUCCESS');";
  $objQuery = mysqli_query($con, $strSQL);
  echo $text = "<h4 class='text-success font-weight-bold'>LOGIN SUCCESS</h4>";

  if ($CENTER == 'CENTER') {
    $LINK_STARTUP = "<script>window.location='debug1.php?MEMBER_ID=$MEMBER_ID';</script>";
  } else {
    $LINK_STARTUP = "<script>window.location='startup_c.php?MEMBER_ID=$MEMBER_ID';</script>";
  }

  switch ($TYPE) {
    case "ADMIN":
      // header("Location: manage_$TYPE.php?MEMBER_ID=$MEMBER_ID");
      echo "<script>window.location='manage_$TYPE.php?MEMBER_ID=$MEMBER_ID';</script>";
      break;
    case "MANAGER":
      // header("Location: manage_$TYPE.php?MEMBER_ID=$MEMBER_ID");
      echo "<script>window.location='manage_$TYPE.php?MEMBER_ID=$MEMBER_ID';</script>";
      break;
    case "PIC":
      // header("Location:manage_$TYPE.php?MEMBER_ID=$MEMBER_ID");
      echo "<script>window.location='manage_$TYPE.php?MEMBER_ID=$MEMBER_ID';</script>";
      break;
    case "TECH":
      // header("Location: startup_c.php?MEMBER_ID=$MEMBER_ID");
      echo $LINK_STARTUP;

      break;
    case "USER":
      // header("Location: manage_$TYPE.php?MEMBER_ID=$MEMBER_ID");
      echo "<script>window.location='manage_$TYPE.php?MEMBER_ID=$MEMBER_ID';</script>";

      break;
    case "SUP.L":
      // header("Location: manage_$TYPE.php?MEMBER_ID=$MEMBER_ID");
      echo "<script>window.location='visual.php?BIZ=IM';</script>";

      break;
    case "SUP.T":
      // header("Location: manage_$TYPE.php?MEMBER_ID=$MEMBER_ID");
      echo "<script>window.location='visual.php?BIZ=IM';</script>";

      break;
    case "LEAD":
      // header("Location: manage_$TYPE.php?MEMBER_ID=$MEMBER_ID");
      echo "<script>window.location='visual.php?BIZ=IM';</script>";
      break;
  }
}
