<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once(dirname(__FILE__) . '/SimpleXLSX.php');

$con = mysqli_connect("43.72.52.51", "root", "123456", "startup2_0");
if (isset($_FILES['excel_file'])) {

	if ($xlsx = SimpleXLSX::parse($_FILES['excel_file']['tmp_name'])) {

		$dim = $xlsx->dimension();
		$cols = $dim[0];

		foreach ($xlsx->rows() as $k => $r) {
			if ($k == 0) continue; // skip first row
			echo $sql = "INSERT INTO `item_test` VALUE('" . $r[0] . "','" . $r[1] . "','" . $r[2] . "','" . $r[3] . "','" . $r[4] . "','" . $r[5] . "','" . $r[6] . "','" . $r[7] . "','" . $r[8] . "','" . $r[9] . "','" . $r[10] . "','" . $r[11] . "','" . $r[12] . "'," . $r[13] . ");";
			// mysqli_query($con, $sql);
			echo '<br>';
		}
	} else {
		echo SimpleXLSX::parseError();
	}
}
