<?php

require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");
// header('Content-Type: application/json; charset=utf-8');

$charset = "SET NAMES TIS620";



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
$IP;


if (empty($_POST['MEMBER_ID'])) {
    header("Location: login.php");
} else {
    $MEMBER_ID = $_POST['MEMBER_ID'];
    $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
    mysqli_set_charset($con, "utf8");
    mysqli_query($con, $charset);
    $objQuery = mysqli_query($con, $strSQL);
    $objResult = mysqli_fetch_array($objQuery);

    $NAME = $objResult['NAME'];

    if (empty($objResult)) {
        header("Location: login.php");
    } else {
        if (empty($_POST['ID'])) {
            ///////CREATE MODE///////
            if (isset($_GET["Action"])) {
                if ($_GET["Action"] != "Add") {
                    echo "update failed";
                } else {
                    $MEMBER_ID = $objResult['MEMBER_ID'];
                    $NAME = $objResult['NAME'];
                    $TYPE = $objResult['TYPE'];

                    // print_r($_POST); 

                    $MEMBER_ID = $_POST['MEMBER_ID'];
                    $BIZ = "IM";
                    $LINE = $_POST['LINE'];
                    $MODEL = $_POST['MODEL'];
                    $PROCESS = $_POST['PROCESS'];
                    $ITEM = $_POST['ITEM'];
                    $TYPE = $_POST['TYPE'];
                    $SPEC_DES = $_POST['SPEC_DES'];
                    $SPEC = $_POST['SPEC'];
                    $PIC = $_POST['PIC'];

                    if ($SPEC == 'DROPDOWN') {
                        $MIN = $_POST['MIN'] = 'NULL';
                        $MAX = $_POST['MAX'] = 'NULL';
                        $DROPDOWN_NAME = $_POST['DROPDOWN_NAME'];

                        $strSQL = "SELECT * FROM `dropdown` WHERE ID = '$DROPDOWN_NAME'";
                        $objQuery = mysqli_query($con, $strSQL);
                        $objResult = mysqli_fetch_array($objQuery);
                        $SPEC = $objResult['DROPDOWN_NAME'];
                    } else if ($SPEC == 'VALUE') {
                        $MIN = $_POST['MIN'];
                        $MAX = $_POST['MAX'];
                    } else if (($SPEC != 'DROPDOWN') && ($SPEC != 'VALUE')) {
                        $MIN = $_POST['MIN'] = 'NULL';
                        $MAX = $_POST['MAX'] = 'NULL';
                    }

                    $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'ADD NEW ITEM', CURRENT_TIMESTAMP, 'SUCCESS');";
                    $objQuery = mysqli_query($con, $strSQL);
                    // echo "<br>";
                    $strSQL = "INSERT INTO `item` (`ID`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `PROCESS`, `ITEM`, `SPEC_DES`, `MIN`, `MAX`, `SPEC`, `PIC`,`PERIOD`) 
                        VALUES (NULL, '$BIZ', '$LINE', '$TYPE', '$MODEL', '$PROCESS', '$ITEM', '$SPEC_DES', $MIN, $MAX, '$SPEC', '$PIC', '$PERIOD');";
                    mysqli_set_charset($con, "utf8");
                    mysqli_query($con, $strSQL);

                    echo "  <script>alert('UPDATE COMPLETE');
                                window.location.href = 'http://43.72.52.206/excel_body/item/item.php?MEMBER_ID=?MEMBER_ID=" . $MEMBER_ID . "';
                            </script>";
                }
            }
        } else {
            ///////EDIT MODE///////
            if (isset($_GET["Action"])) {
                if ($_GET["Action"] == "Edit") {
                    print_r($_POST);

                    $MEMBER_ID = $_POST['MEMBER_ID'];

                    $BIZ = $_POST["BIZ"];
                    $ID = (array_keys($BIZ));
                    $BIZ = array_values($BIZ);

                    $MODEL = $_POST['MODEL'];
                    $LINE = $_POST['LINE'];
                    $TYPE = $_POST['TYPE'];
                    $PROCESS = $_POST['PROCESS'];
                    $ITEM = $_POST['ITEM'];
                    $SPEC_DES = $_POST['SPEC_DES'];
                    $MIN = $_POST['MIN'];
                    $MAX = $_POST['MAX'];
                    $SPEC = $_POST['SPEC'];
                    $PIC = $_POST['PIC'];
                    $PERIOD = $_POST['PERIOD'];
                    $CHANGE_MIN_MAX = $_POST['CHANGE_MIN_MAX'];
                    $HIS_MIN = $_POST['HIS_MIN'];
                    $HIS_MAX = $_POST['HIS_MAX'];

                    $ID_DATA = $_POST['ID_DATA'];
                    if (in_array('YES', $CHANGE_MIN_MAX)) {
                        $RESON = $_POST['RESON'];
                    } else {
                        $RESON = '';
                    }

                    $i = (array_keys($ID));
                    foreach ($i as $value) {

                        ////INDEX FOR QUERY///////
                        $newID = $ID[$value];
                        $newBIZ = $BIZ[$value];
                        $newMODEL = $MODEL[$value];
                        $newLINE = $LINE[$value];
                        $newTYPE = $TYPE[$value];
                        $newPROCESS = $PROCESS[$value];
                        $newITEM = $ITEM[$value];
                        $newSPEC_DES = $SPEC_DES[$value];
                        $newMIN = $MIN[$value];
                        $newMAX = $MAX[$value];
                        $newSPEC = $SPEC[$value];
                        $newPIC = $PIC[$value];
                        $newPERIOD = $PERIOD[$value];
                        $ID_DATA2 = $ID_DATA[$value];

                        // HISTORY
                        if ($CHANGE_MIN_MAX[$ID_DATA2] == "YES") {
                            $strSQL_His = "INSERT INTO `spec_hisory` (`ID_ITEM`, `MIN`, `MAX`, `RESON`, `BY`, `LastUpdate`) VALUES ('$ID_DATA2','$HIS_MIN[$ID_DATA2]','$HIS_MAX[$ID_DATA2]','$RESON[$ID_DATA2]','$NAME',NOW())";
                            mysqli_set_charset($con, "utf8");
                            mysqli_query($con, $strSQL_His);
                        }

                        ////QUERY DATABASE///////
                        $strSQL = "UPDATE item 
                                SET MODEL = '$newMODEL',
                                LINE = '$newLINE',
                                TYPE = '$newTYPE',
                                PROCESS = '$newPROCESS',
                                ITEM = '$newITEM',
                                SPEC_DES = '$newSPEC_DES',
                                MIN = '$newMIN',
                                MAX = '$newMAX',
                                SPEC = '$newSPEC',
                                PIC = '$newPIC',
                                PERIOD = '$newPERIOD',
                                LastUpdate = NOW()
                                WHERE ID = '$newID';";
                        mysqli_set_charset($con, "utf8");
                        mysqli_query($con, $strSQL);
                        $objQuery = mysqli_query($con, $strSQL);


                        $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                            VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'EDIT ITEM $newID', CURRENT_TIMESTAMP, 'SUCCESS');";
                        mysqli_set_charset($con, "utf8");
                        mysqli_query($con, $strSQL);
                        $objQuery = mysqli_query($con, $strSQL);


                        echo "  <script>alert('UPDATE COMPLETE');
                                            window.location.href = 'http://43.72.52.52/excel_body/item/item.php?MEMBER_ID=" . $MEMBER_ID . "';
                                        </script>";
                    }
                }
                ///////DELETE MODE///////

                if ($_GET["Action"] == "Delete") {
                    // echo "Delete<br>";

                    $MEMBER_ID = $_POST['MEMBER_ID'];
                    $_POST['ID'];
                    foreach ($_POST['ID'] as &$ID) {
                        ////QUERY DATABASE///////
                        $strSQL = "DELETE FROM `item` WHERE `item`.`ID` = '$ID'";
                        mysqli_set_charset($con, "utf8");
                        mysqli_query($con, $strSQL);
                        $objQuery = mysqli_query($con, $strSQL) or die("Error Query [" . $strSQL . "]");

                        $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                                VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'DELETE ITEM $ID', CURRENT_TIMESTAMP, 'SUCCESS');";
                        mysqli_set_charset($con, "utf8");
                        mysqli_query($con, $strSQL);
                        $objQuery = mysqli_query($con, $strSQL);

                        echo "  <script>alert('DELETE COMPLETE');
                                            window.location.href = 'http://43.72.52.52/excel_body/item/item.php?MEMBER_ID=" . $MEMBER_ID . "';
                                        </script>";
                    }
                }

                ///////COPY MODE///////

                if ($_GET["Action"] == "Copy") {
                    // echo "Copy<br>";

                    $MEMBER_ID = $_POST['MEMBER_ID'];

                    $BIZ = "IM";
                    $ID = (array_keys($BIZ));
                    $BIZ = array_values($BIZ);

                    $MODEL = $_POST['MODEL'];
                    $LINE = $_POST['LINE'];
                    $TYPE = $_POST['TYPE'];
                    $PROCESS = $_POST['PROCESS'];
                    $ITEM = $_POST['ITEM'];
                    $MIN = $_POST['MIN'];
                    $MAX = $_POST['MAX'];
                    $SPEC = $_POST['SPEC'];
                    $PIC = $_POST['PIC'];
                    $PERIOD = $_POST['PERIOD'];

                    $i = (array_keys($ID));
                    foreach ($i as &$value) {

                        ////INDEX FOR QUERY///////
                        $newID = $ID[$value];
                        $newBIZ = $BIZ[$value];
                        $newMODEL = $MODEL[$value];
                        $newLINE = $LINE[$value];
                        $newTYPE = $TYPE[$value];
                        $newPROCESS = $PROCESS[$value];
                        $newITEM = $ITEM[$value];
                        $newMIN = $MIN[$value];
                        $newMAX = $MAX[$value];
                        $newSPEC = $SPEC[$value];
                        $newPIC = $PIC[$value];
                        $newPERIOD = $PERIOD[$value];
                        echo "<br>";

                        ////QUERY DATABASE///////
                        $strSQL = "INSERT INTO `item` 
                                (`ID`, `BIZ`, `LINE`, `TYPE`, `MODEL`, `PROCESS`, `ITEM`, `MIN`, `MAX`, `SPEC`, `PIC`, `PERIOD`, `LastUpdate`) 
                                VALUES 
                                (NULL, '$newBIZ', '$newLINE', '$newTYPE', '$newMODEL','$newPROCESS', '$newITEM', '$newMIN', '$newMAX', '$newSPEC', '$newPIC', '$newPERIOD', 'CURRENT_TIMESTAMP');";
                        mysqli_set_charset($con, "utf8");
                        mysqli_query($con, $strSQL);
                        $objQuery = mysqli_query($con, $strSQL) or die("Error Query [" . $strSQL . "]");

                        $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                                VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'ADD ITEM $ID', CURRENT_TIMESTAMP, 'SUCCESS');";
                        mysqli_set_charset($con, "utf8");
                        mysqli_query($con, $strSQL);
                        $objQuery = mysqli_query($con, $strSQL);

                        echo "  <script>alert('UPDATE COMPLETE');
                                            window.location.href = 'http://43.72.52.52/excel_body/item/item.php?MEMBER_ID=?MEMBER_ID=" . $MEMBER_ID . "';
                                        </script>";
                    }
                } else {
                    $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                        VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'EDIT ITEM $newID', CURRENT_TIMESTAMP, 'SUCCESS');";
                    mysqli_set_charset($con, "utf8");
                    mysqli_query($con, $strSQL);
                    $objQuery = mysqli_query($con, $strSQL);
                }
            }
        }
    }
}
