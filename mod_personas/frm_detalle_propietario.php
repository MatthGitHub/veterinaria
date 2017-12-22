
<?php
//--------------------------------Inicio de sesion------------------------

include("../inc/sesion.php");
include("../lib/funciones.php");
include("../mod_sql/sql.php");

//Inicializo variables
/*cargaInicialForm = 0;
$flagPersistencia = false;*/

//Capturo dni encontrado
if(isset($_POST['txt_buscar_dni'])){
		$buscar_dni = $_POST['txt_buscar_dni'];
}else{
	$buscar_dni = $_POST['txt_documento'];
}


if ($buscar_dni == "") {
	$dni=$buscar_dni= $pDni;
}

//Cargo barrios
$barrios = sql_buscar_barrios();

//#########################################LLAMO A BUSCAR PROPIETARIO################################
if (!empty($buscar_dni)){
	$propietario = sql_buscar_propietario($buscar_dni);

	$numeroRow = mysql_num_rows($propietario); // obtenemos el número de filas

	if ($propietario && $numeroRow > 0)
	{
		while ($row=mysql_fetch_array($propietario)){
			$id_persona = ($row['id_persona']);
			$dni = ($row['DOCUMENTO']);
			$nombre = ($row['NOMBRE']);
			$apellido = ($row['APELLIDO']);
			$telefono = ($row['TELEFONO']);
			$calle = ($row['CALLE_NOCOD']);
			$numero = ($row['NUMERACION_CALLE']);
			$barrio = ($row['BARRIO']);
			$piso = ($row['PISO']);
			$dpto = ($row['DEPARTAMENTO']);
			$email = ($row['E_MAIL']);
		}
	}else{
		header("Location:frm_alta_propietario.php?DNI=$buscar_dni");
		exit();
	}
}

if(isset($_POST['guardar']))
{
	$id_persona = $_POST['txt_id'];
	$dni = $_POST['txt_dni_modificado'];
	$nombre = $_POST['txt_nombre_propietario'];
	$apellido = $_POST['txt_apellido'];
	$telefono = $_POST['txt_telefono'];
	$calle = $_POST['txt_calle'];
	$numero = $_POST['txt_nro'];
	$barrio = $_POST['select_barrio'];
	$piso = $_POST['txt_piso'];
	$dpto = $_POST['txt_dpto'];
	$email = $_POST['txt_email'];

	$persona = sql_update_propietario($id_persona, $dni, $nombre, $apellido, $telefono, $calle, $numero, $barrio, $piso, $dpto, $email);

	if (!$persona)
	{
		$errorPersona = true;
	}
	else{

		$successPersona = true;
	}
}

?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB - Modificar Persona</title>

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
		document.getElementById("txt_nombre_propietario").focus();
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
			<h4 class="text-center bg-info">Detalle Persona</h4>
			<div class="container">
				<form id="form_detalle_propietario" name="form_detalle_propietario" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

					<?php
					if($successPersona == true){
						echo "
							<div class='alert alert-success-alt alert-dismissable'>
							<span class='glyphicon glyphicon-ok'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>La Persona se modificó correctamente.</div>
						";
						$successPersona = false;
					}elseif($errorPersona == true){
						echo "
							<div class='alert alert-danger-alt alert-dismissable'>
							<span class='glyphicon glyphicon-exclamation-sign'></span>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
							×</button>Error al modificar la Persona.</div>
						";
						$errorPersona = false;
					}
						?>

					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<form class="form form-signup" role="form">
										<h4 class="text-center"><img src="../images/icons/family.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
													<input name="txt_nombre_propietario" type="text" class="form-control" id="txt_nombre_propietario" value="<?php echo $nombre;?>" required/>
													<input name="txt_id" type="hidden" class="form-control" id="txt_id" value="<?php echo $id_persona;?>"/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido</span>
													<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $apellido;?>" required/>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> DNI</span>
													<input name="txt_dni_modificado" type="text" class="form-control" id="txt_dni_modificado" value="<?php echo $dni;?>" required/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-signs fa-fw"></i> Domicilio</span>
													<input name="txt_calle" type="text" class="form-control" id="txt_domicilio" value="<?php echo $calle;?>"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-hashtag fa-fw"></i> Número*</span>
													<input name="txt_nro" type="text" class="form-control" id="txt_domicilio" value="<?php echo $numero;?>" />
												</div>
											</div>
											
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i> Barrio*</span>
													<div class="col-xs-15 selectContainer">
														
														<select class="form-control" id="select_barrio" name="select_barrio"  required>
															<option  selected="selected"> <?php echo $barrio;?> </option>
															<?php
																while ($row=mysql_fetch_array($barrios))
																{
																	$id_barrio = ($row['codigo']);

																	$barrio = ($row['concepto']);

																	?>
																<option value = "<?php echo $barrio; ?>" ><?php echo $barrio;?> </option>
															<?php
															}
															?>

														</select>

													</div>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-building-o fa-fw"></i> Piso</span>
													<input name="txt_piso" type="text" class="form-control" id="txt_piso" value="<?php echo $piso;?>" />
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
													<input name="txt_telefono" type="text" class="form-control" id="txt_telefono" value="<?php echo $telefono;?>" required/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-at fa-fw"></i> Email</span>
													<input name="txt_email" type="email" class="form-control" id="txt_email" value="<?php echo $email;?>" />
												</div>
											</div>
									</form>

									<input id="guardar" name="guardar" type="submit"  class="btn btn-sm btn-primary btn-block" value="GUARDAR CAMBIOS" onclick="return confirm('¿Desea MODIFICAR la persona?');"/>

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
