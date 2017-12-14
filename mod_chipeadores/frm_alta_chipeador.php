
<?php
include("../inc/sesion.php");
include("../lib/funciones.php");
include("../mod_sql/sql.php");
//--------------------------------Inicio de sesion------------------------
include("../lib/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

if(isset($_POST['txt_nombre'])){
	$txt_nombre = $_POST['txt_nombre'];

	if(sql_insert_chipeador($txt_nombre)){
		$success = true;
	}else{
		$valNombre = true;
	}
	header("location:frm_alta_chipeador.php");
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB-Cargar Persona</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.es.js"></script>
	<!--script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script-->

	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">

    <script type="text/javascript">

		function set_focus()
		{
			document.getElementById("txt_nombre_propietario").focus();
			alert("focus propietario nombre");
			return (false);
		}

    </script>

</head>


<body onLoad="document.form1.txt_nombre_propietario.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info">Cargar Chipeador</h4>

			<div class="container">
				<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<?php
							if($valNombre == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El NOMBRE no puede estar vacio.</div>
								";
								$valNombre = false;
							}
							elseif($valApellido == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El APELLIDO de la persona no puede estar vacio</div>
								";
								$valApellido = false;
							}
							elseif($valDni == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El DNI de la persona no puede estar vacio</div>
								";
								$valDni = false;
							}
							elseif($valdniNum == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El DNI debe ser numerico.</div>
								";
								$valdniNum = false;
							}
							elseif($valCalle == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El DOMICILIO de la persona no puede estar vacio</div>
								";
								$valCalle = false;
							}elseif($valNro == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El NUMERO DE DOMICILIO de la persona no puede estar vacio</div>
								";
								$valNro = false;
							}
							elseif($valTelefono == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El TELEFONO de la persona no puede estar vacio</div>
								";
								$valTelefono = false;
							}elseif($success == true){
								echo "
									<div class='alert alert-success-alt alert-dismissable'>
									<span class='glyphicon glyphicon-ok'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>La persona ha sido cargada satisfactoriamente.</div>";
									$success = false;
							}
							elseif($errorDni == true){
								echo "
									<div class='alert alert-warning-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El DNI indicado ya se encuentra cargado.</div>
								";
								$errorDni = false;
							}
							elseif($errordb == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Error en la creacion de la persona.</div>
								";
								$errordb = false;
							}
							?>
							<div class="panel panel-default">
								<div class="panel-body">
									<form class="form form-signup" role="form">
										<h4 class="text-center"><img src="../images/icons/propietario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre*</span>
													<input name="txt_nombre" type="text" class="form-control" id="txt_nombre" required/>
												</div>
											</div>

										<input name="Submit" type="submit" method="post" class="btn btn-sm btn-primary btn-block" value="GUARDAR" />
									</form>
								</div>
							</div>

						</div>
					</div>
				</form>
			</div> <!-- Container -->
		</div>   <!-- Jumbotron -->
		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
	</div>   <!-- Container -->

	<script type="text/javascript">
	$('#divMiCalendario').datetimepicker({
      format: 'DD-MM-YYYY'
    });
</script>
</body>
</html>
