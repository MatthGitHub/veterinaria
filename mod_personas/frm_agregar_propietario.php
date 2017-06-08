
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

//Capturo variables
$txt_dni_original = $_POST['txt_dni_original']; 
$txt_nombre_propietario = $_POST['txt_nombre_propietario'];
$txt_apellido = $_POST['txt_apellido'];
$txt_dni = $_POST['txt_dni_modificado'];
$txt_telefono = $_POST['txt_telefono'];
$txt_calle = $_POST['txt_calle'];
$txt_nro = $_POST['txt_nro'];
$txt_barrio = $_POST['txt_barrio'];

//Capturo dni encontrado
$buscar_dni = $_POST['txt_buscar_dni'];

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
		}
	}
		else
		$resultadoBusqueda= "La persona no se encuetra cargada en el Sistema";
}

//sql_update_propietario($txt_dni_original,$txt_dni,$txt_nombre_propietario,$txt_apellido,$txt_telefono,$txt_calle,$txt_nro,$txt_barrio);
//#########################################PERSISTIR DATOS####################################################
$persistir = $_POST['txt_guardar'];

if ($persistir == 'Guardar')
{	
	$update = sql_update_propietario($txt_dni_original,$txt_dni,$txt_nombre_propietario,$txt_apellido,$txt_telefono,$txt_calle,$txt_nro,$txt_barrio);
	
	if (!$update)
	{
		echo "Error al modificar la persona";
		$flagPersistencia = false;
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
    <title>Sistema VyZ MSCB</title>
	
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
	<style type="text/css">
	<!--
	.Estilo1 {color: #FF0000}
	-->
	</style>
</head>


<body onLoad="document.formBuscar.txt_buscar_dni.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

      <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info"><img src="../images/icons/nuevo_propietario.png" alt="Municipalidad Bariloche" height="24" width="24"> Agregar Propietario</h4>
			<div class="container">
				<form id="formBuscar" name="formBuscar" method="post" value= "buscar_propietario" action="frm_buscar_propietario.php">
				  <div class="row">
					<div class="col-md-4 col-md-offset-4">
					  <div class="panel panel-default">
						<div class="panel-body"
						  <form class="form form-signup" role="form">
							<div class="form-group">
							  <div class="input-group">
								<span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
								<input name="txt_buscar_dni" type="text" id="txt_buscar_dni" class="form-control" value="<?php echo $dni;?>" placeholder="Ingresar DNI a buscar"/>
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
				<div class="container">
					<form id="form_buscar_propietario" name="form_buscar_propietario" method="post" onsubmit="" action="frm_buscar_propietario.php" >
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
														<span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i> Número</span>
														<input name="txt_nro" type="text" class="form-control" id="txt_domicilio" value="<?php echo $numero;?>" disabled="disabled"/>
													</div>
												</div>
												
												<div class="form-group">
												   <div class="input-group">
														<span class="input-group-addon"><i class="fa fa-map-o fa-fw"></i> Barrio</span>
														<input name="txt_barrio" type="text" class="form-control" id="txt_domicilio" value="<?php echo $barrio;?>" disabled="disabled"/>
												   </div>
												</div>
												
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-phone fa-fw"></i> Teléfono</span>
														<input name="txt_telefono" type="text" class="form-control" id="txt_telefono" value="<?php echo $telefono;?>" disabled="disabled"/>
													</div>
												</div>	
												
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-at fa-fw"></i> Email</span>
														<input name="txt_email" type="text" class="form-control" id="txt_email" value="<?php echo $email;?>" disabled="disabled"/>
													</div>
												</div>
										</form>
										<input id="txt_guardar" name="txt_guardar" type="submit"  class="btn btn-sm btn-primary btn-block" onclick="return validar_frm_agregar_propietario();" value="AGREGAR" />     
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
