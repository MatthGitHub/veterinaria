<?php
//--------------------------------Inicio de sesion------------------------
include("../inc/sesion.php");
include("../mod_sql/sql.php");
include("../lib/funciones.php");

if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="index.php";
	header("location:mensaje_ok.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

if(isset($_GET['process'])){

	if(!empty($_POST['buscar_propietario'])){

		$stmt = sql_buscar_propietario($_POST['buscar_propietario']);

		if(mysql_num_rows($stmt) > 0){
			$nombre = mysql_result($stmt,0,'nombre');
			$apellido = mysql_result($stmt,0,'apellido');
			$documento = mysql_result($stmt,0,'documento');
		}else{
			header("Location: frm_reporte_por_propietario.php?errordat");
			exit();
		}
	}else{
		header("Location: frm_reporte_por_propietario.php?errordb");
		exit();
	}
}

$stmtP = sql_buscar_personas();

//Si hay resultados...
if (mysql_num_rows($stmtP) > 0){

while($fila = mysql_fetch_assoc($stmtP)){
		 // se recoge la información según la vamos a pasar a la variable de javascript
				 $texto .= '"'.$fila['documento'].'",';
	}

}else{
		$texto = "NO HAY RESULTADOS EN LA BBDD";
}



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="../image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Reporte por propietario</title>

    <!-- Bootstrap -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
		<script language='javascript' src="../js/jquery-1.12.3.js"></script>
		<script language='javascript' src="../js/jquery-ui.js"></script>
		<link href="../css/bootstrap.css" rel="stylesheet">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
		<script>
		$( function() {
			// Variable que recoge el resultado de la consulta sobre la tabla Provincias, Jquery trabajará sobre este resultado para dinamizar el funcionamiento.
			var availableTags = [<?php echo $texto ?>];
			$("#buscar_propietario").autocomplete({
				source: availableTags
			});

	});




		</script>
  </head>
  <body>

        <div class="container">
          <br>
          <?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">

		<h4 class="text-center bg-info">Reporte por propietario</h4>
		<div class="container">
				<form id="formBuscar" name="formBuscar" method="post" action="frm_reporte_por_propietario.php?process">
				  <div class="row">
					<div class="col-md-4 col-md-offset-4">
					  <div class="panel panel-default">
						<div class="panel-body"
						  <form class="form form-signup" role="form">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
											<input name="buscar_propietario" type="text" id="buscar_propietario" class="form-control" placeholder="Ingrese Documento a buscar..."/>
										</span>
								</div>
							</div>
							<input type="submit" name="Buscar_usuario" value="Buscar" method="post" onclick="submit()" class="btn btn-sm btn-primary btn-block">

					</form>
						</div>
						<?php
						if(isset($_GET['success'])){
						echo "
						<div class='alert alert-success-alt alert-dismissable'>
										<span class='glyphicon glyphicon-ok'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
											×</button>Listo! Usuario modificado satisfactoriamente.</div>";
						}else{
						echo "";
						}
						?>
						<?php
						if(isset($_GET['errordat'])){
						echo "
						<div class='alert alert-warning-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
											×</button>La persona con DNI ingresado no existe</div>
						";
						}else{
						echo "";
						}
						?>
						<?php
						if(isset($_GET['errordb'])){
						echo "
						<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
											×</button>Error, no ha introducido todos los datos.</div>
						";
						}else{
						echo "";
						}
						?>
					  </div>
					</div>
				  </div>
				</form>
			</div><!-- Container 1 -->

			<?php if(isset($_GET['process'])){ ?>
			<div class="container">
				<form name="form1" method="post" action="reporte_por_propietario.php">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<div class="panel panel-default">
							<div class="panel-body">
								<form class="form form-signup" role="form">

								<h4 class="text-center"><img src="../images/icons/propietario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-keyboard-o fw" aria-hidden="true"></i></span>
										<input name="nombre" type="text" class="form-control"  id="nombre" value="<?php echo $nombre; ?>" readonly />
									</div>
								</div>

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-keyboard-o fw" aria-hidden="true"></i></span>
										<input name="apellido" type="text" class="form-control"  id="apellido" value="<?php echo $apellido; ?>" readonly/>
									</div>
								</div>

								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-keyboard-o fw" aria-hidden="true"></i></span>
										<input name="documento" type="text" class="form-control"  id="documento" value="<?php echo $documento; ?>" readonly />
									</div>
								</div>

								<input type="submit" name="Submit" value="Reporte"  class="btn btn-sm btn-primary btn-block">

						  </form>
						</div>

						<?php
						if(isset($_GET['success'])){
						echo "
						<div class='alert alert-success-alt alert-dismissable'>
										<span class='glyphicon glyphicon-ok'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
											×</button>Listo! Usuario modificado satisfactoriamente.</div>";
						}else{
						echo "";
						}
						?>
						<?php
						if(isset($_GET['errordat'])){
						echo "
						<div class='alert alert-warning-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
											×</button>El nombre de usuario ya esta en uso o no ha introducido todos los datos</div>
						";
						}else{
						echo "";
						}
						?>
						<?php
						if(isset($_GET['errordb'])){
						echo "
						<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
											×</button>Error, no ha introducido todos los datos.</div>
						";
						}else{
						echo "";
						}
						?>
					</div>
				</div>

			</div><!-- /container 2 -->
		</form>
	</div>
<?php } ?>
</div>
<div class="panel-footer">
	<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
</div>
    </div> <!-- /container -->
  </body>
</html>
