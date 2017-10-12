<?php
include "../../../../../connect.php";	
	
	$link= db_Connection();
	$result= $link->query("SELECT * FROM tbl_alarmas ORDER BY `ID` DESC");
?>

<html>
   <head>
      <title>Info Resultados</title>
      <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
   </head>
<body>
   <div class="container">
	    <img src="../../../images/logo.png">
	    </br></br>
   
   <h1>Información de Resultados</h1>
   <a href="boton_resultados.php">Descarga de Base de Datos</a>
   <div class="table-responsive">
	   <table class="table table-striped">
			<tr>
				<td>&nbsp;Número&nbsp;</td>
				<td>&nbsp;Hora&nbsp;</td>
				<td>&nbsp;Fecha&nbsp;</td>
				<td>&nbsp;Tag&nbsp;</td>
				<td>&nbsp;Temperatura&nbsp;</td>
				<td>&nbsp;Movimiento X&nbsp;</td>
				<td>&nbsp;Movimiento Y&nbsp;</td>
				<td>&nbsp;Movimiento Z&nbsp;</td>
				<td>&nbsp;Batería&nbsp;</td>
			</tr>

	      <?php 
			  if($result!==FALSE){
			     while($row = $result->fetch_assoc()) {
			        printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></td><td> &nbsp;%s&nbsp; </td></tr>", 
			           $row["ID"], $row["Fecha"], $row["Hora"], $row["Tag_ID"], $row["Temperatura"], $row["X"], $row["Y"], $row["Z"], $row["Bateria"]);
			     }
			     $link->close();

			  }
	      ?>
	   
	   </table>	
   </div>
   
  </div>
</body>
</html>

