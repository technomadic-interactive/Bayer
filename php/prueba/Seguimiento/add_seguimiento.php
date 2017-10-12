<?php
  include "../../../../../connect.php";
   	
   	$link=db_Connection();

	  $tag_id=$_POST["tag_id"];
	  $tratamiento_id=$_POST["tratamiento_id"];
	  $observaciones=$_POST["observaciones"];
	  $peticion="INSERT INTO tbl_seguimiento VALUES (NULL, '" .$tag_id."', $tratamiento_id, '" .$observaciones."', NOW())";

    $link->query($peticion);

   	$link->close();

   	header("Location: ../../../html/seguimiento_insert.html");
?>


