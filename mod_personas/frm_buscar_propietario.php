
<?php
//--------------------------------Inicio de sesion------------------------

include("../inc/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

//Parametros - var - librerias
include("../lib/funciones.php");
include("../mod_sql/sql.php");

//Cargo propietarios


?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB-Buscar Persona</title>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script language='javascript' src="../js/jquery.dataTables.min.js"></script>
</head>


<body>
	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info">Buscar personas</h4>
			<div class="container">
				<form id="formBuscar" name="formBuscar" method="post" value= "buscar_propietario" action="frm_detalle_propietario.php">
				  <div class="row">
					<div class="col-md-4 col-md-offset-4">
					  <div class="panel panel-default">
						<div class="panel-body"
						  <form class="form form-signup" role="form">
						  	<h4 class="text-center"><img src="../images/icons/family.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
							<div class="form-group">
							  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
								<input name="txt_buscar_dni" type="text" id="txt_buscar_dni" class="form-control" placeholder="Ingresar DNI a buscar"/>
							  </div>
							</div>
							<input type="submit" name="Buscar_propietario" value="BUSCAR" method="post" onclick="submit()" class="btn btn-sm btn-primary btn-block">
							<?php
							if($resultadoBusqueda <> ""){
							echo "
								<div class='alert alert-danger-alt alert-dismissable'>
								<span class='glyphicon glyphicon-exclamation-sign'></span>
								<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
								×</button>$resultadoBusqueda</div>
							";
							}else{
							echo "";
							}
							?>
					</form>
						</div>
					  </div>
					</div>
				  </div>
				</form>
			</div><!-- Container 1 -->

		</div> <!-- Jumbotron -->
	</div> <!-- Container -->
</body>
</html>
