<?php
include "../../../../../connect.php";	
	$link= db_Connection();
	$result= $link->query("SELECT * FROM tbl_vacas ORDER BY `VACAS_PK` DESC");
?>

<html>
   <head>
      <title>Info Vacas</title>
      <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
   </head>
<body>
   <div class="container">
	    <img src="../../../images/logo.png">
	    </br></br>
   
   <h1>Tabla de Registro de Vacas</h1>
   <a href="boton_vaca.php">Descarga de Base de Datos</a>
   <div class="table-responsive">
   		<table class="table table-striped">
		<tr>
			<td>&nbsp;Número&nbsp;</td>
			<td>&nbsp;Tag ID&nbsp;</td>
			<td>&nbsp;Tag ID&nbsp;</td>
			<td>&nbsp;Peso&nbsp;</td>
			<td>&nbsp;Edad&nbsp;</td>
			<td>&nbsp;Raza&nbsp;</td>
			<td>&nbsp;Llegada/Salida&nbsp;</td>
			<td>&nbsp;Fecha&nbsp;</td>
		</tr>

      <?php 
		  if($result!==FALSE){
		     while($row = $result->fetch_assoc()) {
		        printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", 
		           $row["VACAS_PK"], $row["TAG_ID"], $row["LOTE_ID"], $row["PESO"], $row["EDAD"], $row["RAZA"], $row["LLEGADA_SALIDA"], $row["FECHA"]);
		     }
		     $link->close();

		  }
      ?>
   
   </table>
   </div>
  </div>
</body>
</html>

