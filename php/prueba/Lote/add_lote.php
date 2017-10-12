<?php
   	include "../../../../../connect.php";
   	
   	$link=db_Connection();

	  $lote_id=$_POST["lote_id"];
	  $entrada_salida=$_POST["entrada_salida"];
	  $procedencia=$_POST["edad"];
	  $individuos=$_POST["individuos"];
	  $peticion="INSERT INTO tbl_lote VALUES (NULL, $lote_id, '" .$entrada_salida."', '" .$procedencia."', $individuos, NOW())";

    $link->query($peticion);

   	$link->close();

   	header("Location: ../../../html/ingreso.html");
?>


