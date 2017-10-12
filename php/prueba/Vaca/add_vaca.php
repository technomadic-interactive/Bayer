<?php
include "../../../../../connect.php";   	
   	$link=db_Connection();

	  $lote_id=$_POST["lote_id"];
	  $entrada_salida=$_POST["entrada_salida"];
	  $edad=$_POST["edad"];
	  $tag_id=$_POST["tag_id"];
	  $PESO=$_POST["peso"];
	  $raza=$_POST["raza"];
	  $peso=floatval($PESO);
	  $peticion="INSERT INTO tbl_vacas VALUES (NULL, '" .$tag_id."', $lote_id, $peso, $edad, '" .$raza."', '" .$entrada_salida."', NOW())";

    $link->query($peticion);

   	$link->close();

   	header("Location: ../../html/vaca_insert.html");
?>


