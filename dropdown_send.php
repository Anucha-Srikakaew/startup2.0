<?php  
 $connect = mysqli_connect("43.72.52.52", "inno", "123456*", "startup2.0");  
 $BIZ = $_POST["BIZ"];  
 $DROPDOWN_NAME = $_POST["DROPDOWN_NAME"];  
 $number = count($_POST["name"]);  
 if($number > 0)  
 {  
     for($i=0; $i<$number; $i++)  
     {  
          if(trim($_POST["name"][$i] != ''))  
          {  
               $sql = "INSERT INTO dropdown (ID,DROPDOWN_NAME,DROPDOWN_CASE,BIZ) VALUES(NULL,'$DROPDOWN_NAME','".mysqli_real_escape_string($connect, $_POST["name"][$i])."','$BIZ')";  
               mysqli_query($connect, $sql);  
          }  
     }
     if ((empty($BIZ))OR(empty($_POST["DROPDOWN_NAME"]))OR(empty($_POST["name"])))
     {
         echo "Please fill data and try again.";
     } 
     else
     {   
     echo "Data Inserted.";  
     }
 }
 else if ((empty($BIZ))&&(empty($_POST["DROPDOWN_NAME"]))&&(empty($_POST["name"])))
 {
     echo "Please fill data and try again.";
 }  
 else  
 {  
      echo "Please fill data and try again.";  
 }  
 ?> 