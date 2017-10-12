<?php

	include "../../../../../connect.php";
	
	$link=db_Connection();

	$result=mysqli_query($link, "SELECT * FROM `tbl_lote` ORDER BY `LOTE_PK` DESC");
	
	$db=mysqli_select_db($link, 'technomadic');

	$filename = "Datos_lote.xls"; // File Name
	// Download file
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Datos_lote.xls"');
	header("Pragma: no-cache");
	/*
	$user_query = mysqli_query('select name,work from info');
	// Write data to file
	$flag = false;
	while ($row = mysqli_fetch_assoc($user_query)) {
    		if (!$flag) {
       	 	// display field/column names as first row
        		echo implode("\t", array_keys($row)) . "\r\n";
        		$flag = true;
    		}
    		echo implode("\t", array_values($row)) . "\r\n";
	}*/
?>

<html>
   <head>
      <title>Monitoreo de Ganado</title>
      <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
   </head>
<body>
   <div class="container">
	    <img src="../../../images/logo.png">
	    </br></br>
   
   <h1>Variables de medición en Ganado</h1>
   <a href="boton_lote.php">Descarga de Base de Datos</a>
   <table class="table table-striped">
		<tr>
			<td>&nbsp;Número&nbsp;</td>
			<td>&nbsp;Lote ID&nbsp;</td>
			<td>&nbsp;Llegada/Salida&nbsp;</td>
			<td>&nbsp;Procedencia&nbsp;</td>
			<td>&nbsp;Individuos&nbsp;</td>
			<td>&nbsp;Fecha&nbsp;</td>
		</tr>

      <?php 
		  if($result!==FALSE){
		     while($row = $result->fetch_assoc()) {
		        printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", 
		           $row["LOTE_PK"], $row["LOTE_ID"], $row["LLEGADA_SALIDA"], $row["PROCEDENCIA"], $row["INDIVIDUOS"], $row["FECHA"]);
		     }
		     $link->close();

		  }
      ?>
   
   </table>
  </div>
</body>
</html>
