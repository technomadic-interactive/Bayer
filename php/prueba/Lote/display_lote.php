<?php
include "../../../../../connect.php";
	
	$link= db_Connection();
	$result= $link->query("SELECT * FROM tbl_lote ORDER BY `LOTE_PK` DESC");
?>

<html>
   	<head>
      	<title>Info Lotes</title>
      	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
   	</head>
	<body>
   		<div class="container">
			<img src="../../../images/logo.png">
	    	</br></br>
   
  	 		<h1>Tabla de Registro de Lotes</h1>
   			<a href="boton_lote.php">Descarga de Base de Datos</a>
   			<div class="table-responsive">
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
  		</div>
	</body>
</html>

