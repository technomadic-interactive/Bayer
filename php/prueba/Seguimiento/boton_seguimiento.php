<?php

	include "../../../../../connect.php";	
	$link=db_Connection();

	$result=mysqli_query($link, "SELECT * FROM `tbl_seguimiento` ORDER BY `SEGUIMIENTO_PK` DESC");
	
	$db=mysqli_select_db($link, 'technomadic');

	$filename = "Datos_seguimiento.xls"; // File Name
	// Download file
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Datos_seguimiento.xls"');
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
      <title>Info Seguimiento</title>
      <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
   </head>
<body>
   <div class="container">
	    <img src="../../../images/logo.png">
	    </br></br>
   
   <h1>Tabla de Seguimiento</h1>
   <a href="boton_seguimiento.php">Descarga de Base de Datos</a>
   <table class="table table-striped">
		<tr>
			<td>&nbsp;Número&nbsp;</td>
			<td>&nbsp;Tag ID&nbsp;</td>
			<td>&nbsp;Tratamiento ID&nbsp;</td>
			<td>&nbsp;Observaciones&nbsp;</td>
			<td>&nbsp;Fecha&nbsp;</td>
		</tr>

      <?php 
		  if($result!==FALSE){
		     while($row = $result->fetch_assoc()) {
		        printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", 
		           $row["SEGUIMIENTO_PK"], $row["TAG_ID"], $row["TRATAMIENTO_ID"], $row["OBSERVACIONES"], $row["FECHA"]);
		     }
		     $link->close();

		  }
      ?>
   
   </table>
  </div>
</body>
</html>
