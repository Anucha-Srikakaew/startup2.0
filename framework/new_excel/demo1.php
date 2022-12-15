<?php

include('Excel/reader.php');
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('SET CHARACTER SET UTF8');
$data->read($_FILES["excel_file"]);


$arr = array();
$s = 0;


// $con = mysqli_connect("43.72.52.56", "root", "123456*", "startup2.0");
for ($x = 2; $x <= count($data->sheets[$s]["cells"]); $x++) {

	for ($i = 1; $i <= 14; $i++) {
		$arr[$i] =  $data->sheets[$s]["cells"][$x][$i];
	}
	$sql = "INSERT INTO `item_test` VALUE('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',%s);";
	$v = vsprintf($sql, $arr);
	echo $v;
	echo  '<br/>';
	// mysqli_query($con, $v);
}
// mysqli_close();