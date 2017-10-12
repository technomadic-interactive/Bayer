<?php
	include "../../../../../connect.php";	
	$link= db_Connection();
	$result= $link->query("SELECT * FROM tbl_seguimiento ORDER BY `SEGUIMIENTO_PK` DESC");
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
   <div class="table-responsive">
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
  </div>
</body>
</html>

