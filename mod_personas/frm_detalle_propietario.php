
<?php
//--------------------------------Inicio de sesion------------------------

include("../lib/sesion.php");
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

//Parametros - var - librerias
include("../lib/funciones.php");
include("../mod_sql/sql.php");


//Inicializo variables
$cargaInicialForm = 0;
$flagPersistencia = false;

//Capturo dni encontrado
$buscar_dni = $_GET['txt_buscar_dni'];

if ($buscar_dni == "") {
	$dni=$buscar_dni= $pDni;
}

//#########################################LLAMO A BUSCAR PROPIETARIO################################
if (!empty($buscar_dni))
{
	$propietario = sql_buscar_propietario($buscar_dni);

	$numeroRow = mysql_num_rows($propietario); // obtenemos el número de filas

	if ($propietario && $numeroRow > 0)
	{
		while ($row=mysql_fetch_array($propietario))
		{
			$dni = ($row['documento']);
			$nombre = ($row['nombre']);
			$apellido = ($row['apellido']);
			$telefono = ($row['telefono']);
			$calle = ($row['calle']);
			$numero = ($row['numero']);
			$barrio = ($row['barrio']);
			$piso = ($row['piso']);
			$dpto = ($row['departamento']);
			$email = ($row['email']);
		}
	}
		else
		$resultadoBusqueda= "La persona no se encuetra cargada en el Sistema";
}

?>

<!DOCTYPE html">
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="../images/icons/logo_vet.png" sizes="16x16">
    <title>Sistema VyZ MSCB-Detalle Persona</title>

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
			<h4 class="text-center bg-info">Detalle Persona</h4>
			<div class="container">
				<form id="form_detalle_propietario" name="form_detalle_propietario" method="post" onsubmit="" action="frm_buscar_propietario.php" >
					<div class="row">
						<div class="col-md-4 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<form class="form form-signup" role="form">
										<h4 class="text-center"><img src="../images/icons/propietario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
													<input name="txt_nombre_propietario" type="text" class="form-control" id="txt_nombre_propietario" value="<?php echo $nombre;?>" disabled="disabled"/>
												</div>
											</div>

											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Apellido</span>
													<input name="txt_apellido" type="text" class="form-control" id="txt_apellido" value="<?php echo $apellido;?>" disabled="disabled"/>
												</div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-id-card fa-fw"></i> DNI</span>
													<input name="txt_dni_modificado" type="text" class="form-control" id="txt_dni_modificado" value="<?php echo $dni;?>" disabled="disabled"/>
											   </div>
											</div>

											<div class="form-group">
											   <div class="input-group">
													<span class="input-group-addon"><i class="fa fa-map-signs fa-fw"></i> Domicilio</span>
													<input name="txt_calle" type="text" class="form-control" id="txt_domicilio" value="<?php echo $calle;?>" disabled="disabled"/>
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
													<span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i> Barrio</span>
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
													<input name="txt_email" type="text" class="form-control" id="txt_email" value="<?php echo $email;?>" disabled="disabled"/>
												</div>
											</div>
									</form>

									<input id="txt_cerrar" name="txt_cerrar" type="submit"  class="btn btn-sm btn-primary btn-block" value="CERRAR" />

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
