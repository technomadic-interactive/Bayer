<?php
include "../../../../../connect.php";	
	$link= db_Connection();
	$result= $link->query("SELECT * FROM tbl_tag ORDER BY `ID` DESC");
?>

<html>
   <head>
      <title>Info Tag</title>
      <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
   </head>
<body>
   <div class="container">
	    <img src="../../../images/logo.png">
	    </br></br>
   
   <h1>Tabla de Registo de Tags</h1>
   <a href="boton_tag.php">Descarga de Base de Datos</a>
   <div class="table-responsive">
   		<table class="table table-striped">
		<tr>
			<td>&nbsp;Número&nbsp;</td>
			<td>&nbsp;Tag ID&nbsp;</td>
			<td>&nbsp;Estado de Tag&nbsp;</td>
			<td>&nbsp;Fecha&nbsp;</td>
		</tr>

      <?php 
		  if($result!==FALSE){
		     while($row = $result->fetch_assoc()) {
		        printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", 
		           $row["ID"], $row["TAG_ID"], $row["ACTIVO"], $row["FECHA"]);
		     }
		     $link->close();

		  }
      ?>
   
   </table>
   </div>
  </div>
</body>
</html>

