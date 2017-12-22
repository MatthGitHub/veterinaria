
<?php
//--------------------------------Inicio de sesion------------------------
include("../inc/sesion.php");

//--------------------------------Fin inicio de sesion------------------------

//Parametros - var - librerias
include("../lib/funciones.php");
include("../mod_sql/sql.php");

//Inicializo variables
/*$cargaInicialForm = 0;
$flagPersistencia = false;

$valNombre = false;
$valApellido = false;
$valDocumento = false;
$valCalle = false;
$valNumero = false;
$valNumeroNum = false;
$valBarrio = false;
$valTelefono = false;
$valTelefonoNum = false;
$valEmail = false;
$valPersona = false;
$errorPersona = false;*/

//Capturo variables
$id_persona = $_POST['id_persona'];
/*$nombre = $_POST['txt_nombre_propietario'];
$apellido = $_POST['txt_apellido'];
$dni = $_POST['txt_dni_modificado'];
$telefono = $_POST['txt_telefono'];
$calle = $_POST['txt_calle'];
$numero = $_POST['txt_nro'];
$barrio = $_POST['txt_barrio'];
$piso = $_POST['txt_piso'];
$dpto = $_POST['txt_dpto'];
$email = $_POST['txt_email'];*/

//Capturo dni encontrado
//$buscar_dni = $_GET['txt_buscar_dni'];

/*if ($buscar_dni == "") {
	$dni=$buscar_dni= $pDni;
}*/

//#########################################LLAMO A BUSCAR PROPIETARIO################################
if (!empty($id_persona))
{
	echo "ID: ".$id_persona;
	exit();
	$propietario = sql_buscar_persona_id($id_persona);

	$numeroRow = mysql_num_rows($propietario); // obtenemos el número de filas

	if ($propietario && $numeroRow > 0)
	{
		while ($row=mysql_fetch_array($propietario))
		{
			$dni = ($row['documento']);
			//$txt_dni_original = $dni;
			$nombre = ($row['NOMBRE']);
			$apellido = ($row['APELLIDO']);
			$telefono = ($row['telefono']);
			$calle = ($row['calle']);
			$numero = ($row['numero']);
			$barrio = ($row['barrio']);
			$piso = ($row['piso']);
			$dpto = ($row['departamento']);
			$email = ($row['email']);
		}
	}
}

//sql_update_propietario($txt_dni_original,$txt_dni,$txt_nombre_propietario,$txt_apellido,$txt_telefono,$txt_calle,$txt_nro,$txt_barrio);
//#########################################PERSISTIR DATOS####################################################

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$buscar_dni = $_POST['txt_dni_modificado'];

	$txt_dni_original = $_POST['txt_dni_original'];
	$nombre = $_POST['txt_nombre_propietario'];
	$apellido = $_POST['txt_apellido'];
	$dni = $_POST['txt_dni_modificado'];
	$telefono = $_POST['txt_telefono'];
	$calle = $_POST['txt_calle'];
	$numero = $_POST['txt_nro'];
	$barrio = $_POST['txt_barrio'];
	$piso = $_POST['txt_piso'];
	$dpto = $_POST['txt_dpto'];
	$email = $_POST['txt_email'];

	if($nombre == "")
	{
		$valNombre = true;

	}elseif($apellido == "")
	{
		$valApellido = true;

	}elseif ($dni == "")
	{
		$valDocumento = true;

	}elseif ($calle == "")
	{
		$valCalle = true;

	}elseif ($numero == "")
	{
		$valNumero = true;
	}elseif (!is_numeric($numero))
	{
		$valNumeroNum = true;

	}elseif ($barrio == "")
	{
		$valBarrio = true;

	}elseif ($telefono == "")
	{
		$valTelefono = true;
	}elseif (!is_numeric($telefono))
	{
		$valTelefonoNum = true;

	}elseif($email != "" && !filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$valEmail = true;

	}else
	{
		$update = sql_update_propietario($txt_dni_original,$dni,$nombre,$apellido,$telefono,$calle,$numero,$barrio,$piso,$dpto,$email);

		if (!$update)
		{
			$errorPersona = true;
		}else
		{
			$valPersona = true;
		}
	}

}
*/
?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB-Modificar Persona</title>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script language='javascript' src="../js/jquery-1.12.3.js"></script>
    <script src="../js/bootstrap.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.es.js"></script>
	<script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script>

	<!-- Bootstrap -->
    <script src="../js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">

	<script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../jscripts/popcalendar.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script>

	<script type="text/JavaScript">

	function set_focus()
	{
		document.getElementById("txt_nombre_animal").focus();
		alert("focus animal nombre");
		return (false);
	}
	/*
	//---------------------Verificar abandono de la pagina-------------------//
	var bPreguntar = true;

		window.onbeforeunload = preguntarAntesDeSalir;

		function preguntarAntesDeSalir()
		{
		  if (bPreguntar)
			return "";
		}
	//------------------Fin verificar abandono--------------------------//
	*/

	</script>
</head>


<body onLoad="document.formBuscar.txt_buscar_dni.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info">Modificar Persona</h4>
			<div class="container">
				<form id="formBuscar" name="formBuscar" method="post" value= "buscar_propietario" action="<?php $_SERVER["PHP_SELF"];?>">

				<?php
					if($valNombre == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El NOMBRE no puede estar vacio.</div>
						";
						$valNombre = false;
					}elseif($valApellido == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El APELLIDO no puede estar vacio.</div>
						";
						$valApellido = false;
					}elseif($valDocumento == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El DOCUMENTO no puede estar vacio.</div>
						";
						$valDocumento = false;
					}elseif($valCalle == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>La CALLE no puede estar vacia.</div>
						";
						$valCalle = false;
					}elseif($valNumero == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El NUMERO de la CALLE no puede estar vacia.</div>
						";
						$valNumero = false;
					}elseif($valNumeroNum == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El NUMERO de la CALLE debe ser numérico.</div>
						";
						$valNumeroNum = false;
					}elseif($valBarrio == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El BARRIO no puede estar vacio.</div>
						";
						$valBarrio = false;
					}elseif($valTelefono == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El TELEFONO no puede estar vacio.</div>
						";
						$valTelefono = false;
					}elseif($valTelefonoNum == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El NUMERO de TELEFONO debe ser numérico.</div>
						";
						$valTelefonoNum = false;
					}elseif($valEmail == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>El formato de EMAIL es incorrecto.</div>
						";
						$valEmail = false;
					}elseif($errorPersona == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>ERROR al modificar la persona.</div>
						";
						$errorPersona = false;
					}elseif($valPersona == true){
						echo "
							<div class='alert alert-success-alt alert-dismissable'>
							<span class='glyphicon glyphicon-ok'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>La PERSONA ha sido modificada correctamente.</div>
						";
						$valPersona = false;
					}
				?>

					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<form class="form form-signup" role="form">
										<h4 class="text-center"><img src="../images/icons/propietario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre*</span>
													<input name="txt_nombre_propietario" type="text" class="form-control" id="txt_nombre_propietario" value="<?php echo $nombre;?>"/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido*</span>
													<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $apellido;?>"/>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> DNI*</span>
													<input name="txt_dni_modificado" type="text" class="form-control" id="txt_dni_modificado" value="<?php echo $dni;?>"/>
											   </div>
											</div>

											<input style="visibility:hidden" name="txt_dni_original" type="text" class="form-control" id="txt_dni_original" value="<?php echo $dni;?>"/>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-signs fa-fw"></i> Domicilio*</span>
													<input name="txt_calle" type="text" class="form-control" id="txt_domicilio" value="<?php echo $calle;?>"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i> Número*</span>
													<input name="txt_nro" type="text" class="form-control" id="txt_domicilio" value="<?php echo $numero;?>"/>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i> Barrio*</span>
													<input name="txt_barrio" type="text" class="form-control" id="txt_domicilio" value="<?php echo $barrio;?>"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Piso</span>
													<input name="txt_piso" type="text" class="form-control" id="txt_piso" value="<?php echo $piso;?>"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Dpto.</span>
													<input name="txt_dpto" type="text" class="form-control" id="txt_dpto" value="<?php echo $dpto;?>"/>
											   </div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i> Teléfono*</span>
													<input name="txt_telefono" type="text" class="form-control" id="txt_telefono" value="<?php echo $telefono;?>"/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-at fa-fw"></i> Email</span>
													<input name="txt_email" type="text" class="form-control" id="txt_email" value="<?php echo $email;?>"/>
												</div>
											</div>

											<input name="Submit" type="submit" method="post" class="btn btn-sm btn-primary btn-block btn-danger" value="GUARDAR CAMBIOS" />
									</form>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div><!-- Container 2 -->
		</div> <!-- Jumbotron -->
	</div> <!-- Container -->
</body>
</html>
