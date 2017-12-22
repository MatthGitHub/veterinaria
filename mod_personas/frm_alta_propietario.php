
<?php
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

//Inicializacion
$validado = false;

$valNombre =false;
$valApellido =false;
$valdni =false;
$valdniNum =false;
$valCalle =false;
$valNro =false;
$valTelefono =false;
$success = false;
$errordb = false;
$errorDni = false;

$txt_nombre_propietario = "";
$txt_apellido = "";
$txt_dni = "";
$txt_telefono = "";
$txt_calle = "";
$txt_nro = "";
$txt_barrio = "";
$txt_piso = "";
$txt_dpto = "";
$txt_email = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	$txt_dni = test_input($_GET['DNI']);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$txt_nombre_propietario = test_input($_POST['txt_nombre_propietario']);
	$txt_apellido = test_input($_POST['txt_apellido']);
	$txt_dni = test_input($_POST['txt_dni']);
	$txt_telefono = test_input($_POST['txt_telefono']);
	$txt_calle = test_input($_POST['txt_calle']);
	$txt_nro = test_input($_POST['txt_nro']);
	$txt_barrio = test_input($_POST['txt_barrio']);
	$txt_piso = test_input($_POST['txt_piso']);
	$txt_dpto = test_input($_POST['txt_dpto']);
	$txt_email = test_input($_POST['txt_email']);
	$txt_cp = test_input($_POST['txt_cp']);
	$txt_ec = test_input($_POST['txt_ec']);
	$txt_fecha_nac = test_input($_POST['txt_fecha_nac']);

	$valor = explode('.',$_POST['select_ec']);
	$txt_ec = $valor[0];

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//---------Persistir datos

//Controlo que no exista la persona
if (!sql_buscar_persona_duplicada($txt_dni))
{
	$persona = sql_insert_persona($txt_nombre_propietario,$txt_apellido,$txt_dni,$txt_telefono,$txt_calle,$txt_sexo,$txt_nro,$txt_barrio,$txt_piso, $txt_dpto, $txt_email,$txt_ec,$txt_fecha_nac,$txt_pais,$txt_cp);

	if ($persona)
	{
		$success=true;

		$txt_nombre_propietario = "";
		$txt_apellido = "";
		$txt_dni = "";
		$txt_telefono = "";
		$txt_calle = "";
		$txt_nro = "";
		$txt_barrio = "";
		$txt_piso = "";
		$txt_dpto = "";
		$txt_email = "";
	}
	else if (!$flag)
	{
		$errordb=true;
	}
}
else
{
	 $errorDni=true;
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
			<h4 class="text-center bg-info">Cargar Persona</h4>

			<div class="container">
				<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<?php
							if($success == true){
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
													<input name="txt_nombre_propietario" type="text" class="form-control" id="txt_nombre_propietario" value="<?php echo $txt_nombre_propietario;?>" required/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido*</span>
													<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $txt_apellido;?>" required/>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
												   <span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> DNI*</span>
												   <input name="txt_dni" type="number" class="form-control" id="txt_dni" value="<?php echo $txt_dni;?>" required/>
											   </div>
											</div>

											<div class="form-group" hidden>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha nacimiento </span>
													<div class='input-group date' id='divMiCalendario'>
														<input name="txt_fecha_nac" type='text' id="txt_fecha_nac" class="form-control" value=""  />
														<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
													</div>
												</div>
											</div>

											<div class="form-group" hidden>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-bug fa-fw"></i> Sexo*</span>
													<div class="col-xs-15 selectContainer">
														<select class="form-control" id="select_sexo" name="select_sexo" >
															<option value = "m" selected="selected"> M </option>
															<option value = "f"> F </option>
														</select>
													</div>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-signs fa-fw"></i> Domicilio*</span>
													<input name="txt_calle" type="text" class="form-control" id="txt_calle" value="<?php echo $txt_calle;?>" />
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i> Número*</span>
													<input name="txt_nro" type="number" class="form-control" id="txt_nro" value="<?php echo $txt_nro;?>" />
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i> Barrio</span>
													<input name="txt_barrio" type="text" class="form-control" id="txt_barrio" value="<?php echo $txt_barrio;?>" required/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Piso</span>
													<input name="txt_piso" type="text" class="form-control" id="txt_piso" value="<?php echo $txt_piso;?>"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Dpto.</span>
													<input name="txt_dpto" type="text" class="form-control" id="txt_dpto" value="<?php echo $txt_dpto;?>"/>
											   </div>
											</div>

											<div class="form-group" hidden>
												 <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i> Codigo postal</span>
													<input name="txt_cp" type="text" class="form-control" id="txt_cp" value="8400"/>
												 </div>
											</div>

											<div class="form-group" hidden>
												 <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i> Pais </span>
													<input name="txt_pais" type="text" class="form-control" id="txt_pais" value=""/>
												 </div>
											</div>

											<div class="form-group" hidden>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-bug fa-fw"></i> Estado civil</span>
													<div class="col-xs-15 selectContainer">
														<select class="form-control" id="select_ec" name="select_ec">
															<option value = "soltero" selected="selected"> Soltero/a </option>
															<option value = "casado"> Casado/a </option>
															<option value = "divorciado"> Divorciado/a </option>
															<option value = "viudo"> Viudo/a </option>
														</select>
													</div>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i> Teléfono*</span>
													<input name="txt_telefono" type="number" class="form-control" id="txt_telefono" value="<?php echo $txt_telefono;?>" required/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-at fa-fw"></i> Email</span>
													<input name="txt_email" type="email" class="form-control" id="txt_email" value="<?php echo $txt_email;?>"/>
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
