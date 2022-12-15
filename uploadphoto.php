<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Bangkok");
$iditem = $_POST['ID'];
$imagedata = $_POST['image'];
$check_add = $_GET['check'];
$check = $_POST['check'];
$check_succ = $_POST['checkimage'];
$imageID = $_POST['itemID'];

$now = date("H");
if ($now >= 8 && $now < 20) {
	$SHIFT = 'DAY';
} else {
	$SHIFT = 'NIGHT';
}

$time = date("h.i.s");
$date =  date("Y-m-d");
$filename = $imageID . "_" . $date . "_" . $time . "_" . $SHIFT . ".jpg";
$path = $filename;
$url = '';
if ($check_succ == "1" && isset($imagedata)) {

	$data = $_POST['image'];

	$data = str_replace("data:image/png;base64,", "", $data);

	file_put_contents("photo/$filename", base64_decode($data));
	// echo '<img  height="150px" width="150px"   src="data:image/jpeg;base64,' . base64_encode($data) . '"/>';
	echo $filename;
}
