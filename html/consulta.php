<?php
include "../../../connect.php";	
	
	$link= db_Connection();
	$result= $link->query("SELECT * FROM tbl_alarmas ORDER BY `ID` DESC");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Ingreso</title>
	<link rel="icon" href="../images/bayer.ico" type="image/ico">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../bootstrap/css/estilos.css">
</head>
<body>

  <div class="container">
	    <img src="../images/logo.png">
	    </br></br>
	    <ul class="nav nav-tabs" role="tablist">
	    	<li><a href="ingreso.html">INGRESO</a></li>
		    <li class="active"><a href="#">CONSULTA</a></li>
		    <li><a href="enfermeria.html">ENFERMERÍA</a></li> 
		    <li><a href="expediente.html">EXPEDIENTE</a></li>   
		    <li><a href="baja.html">BAJA</a></li>   
		    <li><a href="vistas.html">DESCARGAS</a></li>    
		</ul>
		<br>
    </div>
	
	<form class="form-horizontal" action="../php/prueba/Lote/add_lote.php" method="post">
	    
	    <div class="container">
			<div class="row">
				<div class="col-md-2">
					<label for="">Tag ID</label>
				</div>
				<div class="col-md-2 form-group">
					<input id="edad" name="tag_id" type="text" placeholder="" class="form-control input-md" required="">
				</div>
				<div class="col-md-2">
					<label for="">Corral</label>
				</div>
				<div class="col-md-2 form-group">
					<input id="edad" name="corral" type="text" placeholder="" class="form-control input-md" required="">
				</div>
				<div class="col-md-2">
					<label for="">Lote</label>
				</div>
				<div class="col-md-2 form-group">
					<input id="edad" name="lote" type="text" placeholder="" class="form-control input-md" required="">
				</div>
			</div>
			</div>
		</div>

		<br>

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

		

		<div class="form-group container">
			<div class="row">
				<div class="col-md-5"></div>
				<div class="col-md-1">
				    <button id="insertar" name="insertar" class="btn btn-info">Guardar</button>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-1">
				    <button id="insertar" name="insertar" class="btn btn-info">Cancelar</button>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-1">
				    <button id="insertar" name="insertar" class="btn btn-info">Nuevo</button>
				</div>
			</div>
		</div>
	</form>
	
	<script scr="../bootstrap/js/jquery.js"></script>
	<script scr="../bootstrap/js/bootstrap.min.js"></script>
</body>



</html>