<?php
include "../../../../../connect.php";   	
   	$link=db_Connection();

	  $tratamiento_id=$_POST["tratamiento_id"];
	  $nombre=$_POST["nombre"];
	  $descripcion=$_POST["descripcion"];
	  $peticion="INSERT INTO tbl_tratamientos VALUES ($tratamiento_id, '" .$nombre."', '" .$descripcion."')";

    $link->query($peticion);

   	$link->close();

   	header("Location: ../../../html/tratamientos_insert.html");
?>


