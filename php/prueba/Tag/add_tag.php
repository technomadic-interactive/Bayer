<?php
	include "../../../../../connect.php";   	
   	$link=db_Connection();

	  $tag_id=$_POST["tag_id"];
	  $activo=$_POST["activado"];
	  $peticion="INSERT INTO tbl_tag VALUES (NULL, '" .$tag_id."', '" .$activo."', NOW())";

    $link->query($peticion);

   	$link->close();

   	header("Location: ../../../html/tag_insert.html");
?>


