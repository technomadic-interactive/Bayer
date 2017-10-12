<?php
include "../../../../../connect.php";	
	$link= db_Connection();
	$result= $link->query("SELECT * FROM tbl_tratamientos ORDER BY `NOMBRE` DESC");
?>

<html>
   <head>
      <title>Info Tratamientos</title>
      <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
   </head>
<body>
   <div class="container">
	    <img src="../../../images/logo.png">
	    </br></br>
   
   <h1>Tabla de Seguimiento</h1>
   <a href="boton_tratamiento.php">Descarga de Base de Datos</a>
   <div class="table-responsive">
   		<table class="table table-striped">
		<tr>
			<td>&nbsp;ID&nbsp;</td>
			<td>&nbsp;Tratamiento&nbsp;</td>
			<td>&nbsp;Descripción&nbsp;</td>
		</tr>

      <?php 
		  if($result!==FALSE){
		     while($row = $result->fetch_assoc()) {
		        printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", 
		           $row["TRATAMIENTO_ID"], $row["NOMBRE"], $row["DESCRIPCION"]);
		     }
		     $link->close();

		  }
      ?>
   
   </table>
   </div>
  </div>
</body>
</html>

