<?php

require_once("connect.php");
date_default_timezone_set("Asia/Bangkok");


    ////////////IP ADRESS////////////////
        //whether ip is from share internet
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
            $IP = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
            $IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
            $IP = $_SERVER['REMOTE_ADDR'];
        }
        $IP;


if(empty($_POST['MEMBER_ID']))
{
    header("Location: login.php");
}
else
{
    $MEMBER_ID = $_POST['MEMBER_ID'];
    $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
    $objQuery = mysqli_query($con,$strSQL);
    $objResult = mysqli_fetch_array($objQuery);

    if(empty($objResult))
    {
        header("Location: login.php");
    }
    else
    {
        if(empty($_POST['ID']))
        {
            ///////CREATE MODE///////
                if(isset($_GET["Action"]))
                {
                    if($_GET["Action"] == "Add")
                    {
                            ////INDEX FOR QUERY///////
                            $MEMBER_ID = $_POST['MEMBER_ID'];
                            $BIZ = $_POST['BIZ'];
                            $M_ID = $_POST['M_ID'];
                            $NAME = $_POST['NAME'];
                            $PASSWORD = $_POST['PASSWORD'];
                            $TYPE = $_POST['TYPE'];
                            $SHIFT = $_POST['SHIFT'];
                            $LINE = $_POST['LINE'];

                        if(($objResult['TYPE']=='PIC') OR ($objResult['TYPE']=='ADMIN'))
                        {
                            ////QUERY DATABASE///////
                                $strSQL = "INSERT INTO `member` (`ID`, `MEMBER_ID`, `NAME`, `PASSWORD`, `TYPE`, `SHIFT`, `LINE`, `BIZ`) 
                                VALUES (NULL, '$M_ID', '$NAME', '$PASSWORD', '$TYPE', '$SHIFT', '$LINE', '$BIZ');";
                                $strSQL;echo "<br>";
                                $objQuery = mysqli_query($con,$strSQL) or die ("Error Query [".$strSQL."]");

                                $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
                                $objQuery = mysqli_query($con,$strSQL);
                                $objResult = mysqli_fetch_array($objQuery);
                                $NAME = $objResult['NAME'];

                                $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                                VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'ADD NEW MEMBER $M_ID', CURRENT_TIMESTAMP, 'SUCCESS');";
                                $objQuery = mysqli_query($con,$strSQL);

                                echo "  <script>alert('CREATE NEW MEMBER COMPLETE');
                                            window.location.href = 'member.php?MEMBER_ID=$MEMBER_ID';
                                        </script>";
                        }
                        else
                        {
                            $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                            VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'FAIL SAVE MEMBER (NO AUTHOR)', CURRENT_TIMESTAMP, 'FAIL');";
                            $objQuery = mysqli_query($con,$strSQL);

                            echo "  <script>alert('You have no authorization for this action');
                                        window.location.href = 'member.php?MEMBER_ID=$MEMBER_ID';
                                    </script>";
                        }
                    }
                    else
                    {
                        echo "update failed";
                    }
                }
        }
        else
        {
            ///////EDIT MODE///////

                if(isset($_GET["Action"]))
                {
                    if($_GET["Action"] == "Edit")
                    {
                        $MEMBER_ID = $_POST['MEMBER_ID'];
                        $ID = $_POST['ID'];

                        $M_ID = $_POST['M_ID'];
                        $M_ID = array_values($M_ID);

                        $NAME = $_POST['NAME'];
                        $PASSWORD = $_POST['PASSWORD'];
                        $TYPE = $_POST['TYPE'];
                        $SHIFT = $_POST['SHIFT'];
                        $LINE = $_POST['LINE'];

                        $i = (array_keys($M_ID));
                        foreach ($i as &$value) {

                            ////INDEX FOR QUERY///////
                                $newID = $ID[$value];

                                $newM_ID = $M_ID[$value];
                                $newNAME = $NAME[$value];
                                $newPASSWORD = $PASSWORD[$value];
                                $newTYPE = $TYPE[$value];
                                $newSHIFT = $SHIFT[$value];
                                $newLINE = $LINE[$value];


                            ////QUERY DATABASE///////
                                $strSQL = "UPDATE member 
                                SET MEMBER_ID = '$newM_ID',
                                NAME = '$newNAME',
                                PASSWORD = '$newPASSWORD',
                                TYPE = '$newTYPE',
                                SHIFT = '$newSHIFT',
                                LINE = '$newLINE'
                                WHERE ID = '$newID';";
                                $strSQL;echo "<br>";
                                $objQuery = mysqli_query($con,$strSQL) or die ("Error Query [".$strSQL."]");

                                $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
                                $objQuery = mysqli_query($con,$strSQL);
                                $objResult = mysqli_fetch_array($objQuery);
                                $NAME = $objResult['NAME'];
        

                                $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                                VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'COPY MEMBER $newM_ID', CURRENT_TIMESTAMP, 'SUCCESS');";
                                $objQuery = mysqli_query($con,$strSQL);

                                echo "  <script>alert('UPDATE COMPLETE');
                                            window.location.href = 'member.php?MEMBER_ID=".$MEMBER_ID."';
                                        </script>";
                        }

                    }
            ///////DELETE MODE///////

                    if($_GET["Action"] == "Delete")
                    {
                        // echo "Delete<br>";

                        $MEMBER_ID = $_POST['MEMBER_ID'];
                        $_POST['ID'];


                        foreach ($_POST['ID'] as &$ID) 
                        {
                            ////QUERY DATABASE///////
                                $strSQL = "DELETE FROM `member` WHERE `member`.`id` = '$ID'";
                                $strSQL;echo "<br>";
                                $objQuery = mysqli_query($con,$strSQL) or die ("Error Query [".$strSQL."]");

                                $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
                                $objQuery = mysqli_query($con,$strSQL);
                                $objResult = mysqli_fetch_array($objQuery);
                                $NAME = $objResult['NAME'];

                                $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                                VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'DELETE MEMBER $ID', CURRENT_TIMESTAMP, 'SUCCESS');";
                                $objQuery = mysqli_query($con,$strSQL);
                             
                                echo "  <script>alert('DELETE COMPLETE');
                                            window.location.href = 'member.php?MEMBER_ID=".$MEMBER_ID."';
                                        </script>";
                        }

                    }

            ///////COPY MODE///////

                    if($_GET["Action"] == "Copy")
                    {
                        echo "copy<br>";
                        ////INDEX FOR QUERY///////
                        $MEMBER_ID = $_POST['MEMBER_ID'];

                        $BIZ = $_POST['BIZ'];
                        $ID = $_POST['ID'];
                        $M_ID = $_POST['M_ID'];
                        $NAME = $_POST['NAME'];
                        $PASSWORD = $_POST['PASSWORD'];
                        $TYPE = $_POST['TYPE'];
                        $SHIFT = $_POST['SHIFT'];
                        $LINE = $_POST['LINE'];

                        if($_POST['BIZ']=='')
                        {
                            $BIZ='';
                        }

                        $i = (array_keys($ID));

                        foreach ($i as &$value) 
                        {
                            echo $newM_ID = $M_ID[$value];
                            echo $newNAME = $NAME[$value];
                            echo $newPASSWORD = $PASSWORD[$value];
                            echo $newTYPE = $TYPE[$value];
                            echo $newSHIFT = $SHIFT[$value];
                            echo $newLINE = $LINE[$value];
                            echo "<br>";

                            ////QUERY DATABASE///////
                                $strSQL = "INSERT INTO `member` 
                                (`ID`, `MEMBER_ID`, `NAME`, `PASSWORD`, `TYPE`, `SHIFT`, `LINE`, `BIZ`) 
                                VALUES 
                                (NULL, '$newM_ID', '$newNAME', '$newPASSWORD', '$newTYPE','$newSHIFT', '$newLINE', '$BIZ');";
                                $strSQL;echo "<br>";
                                $objQuery = mysqli_query($con,$strSQL) or die ("Error Query [".$strSQL."]");

                                $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
                                $objQuery = mysqli_query($con,$strSQL);
                                $objResult = mysqli_fetch_array($objQuery);
                                $NAME = $objResult['NAME'];
        

                                $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                                VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'COPY MEMBER $newM_ID', CURRENT_TIMESTAMP, 'SUCCESS');";
                                $objQuery = mysqli_query($con,$strSQL);

                                echo "  <script>alert('UPDATE COMPLETE');
                                            window.location.href = 'member.php?MEMBER_ID=".$MEMBER_ID."';
                                        </script>";
                        }
                    }

            ///////FAILED CASE///////
                    else
                    {
                        $strSQL = "SELECT * FROM `member` WHERE MEMBER_ID = '$MEMBER_ID'";
                        $objQuery = mysqli_query($con,$strSQL);
                        $objResult = mysqli_fetch_array($objQuery);
                        $NAME = $objResult['NAME'];

                        $strSQL = "INSERT INTO `login` (`ID`, `MEMBER_ID`, `NAME`, `IP`, `USAGE`,`LastUpdate`, `STATUS`) 
                        VALUES (NULL, '$MEMBER_ID', '$NAME', '$IP', 'FAILS SAVE', CURRENT_TIMESTAMP, 'FAILS');";
                        $objQuery = mysqli_query($con,$strSQL);
                    }
                }
        }
    
    }
}





?>

