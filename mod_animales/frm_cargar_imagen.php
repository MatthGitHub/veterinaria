
<?php
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


//Capturo dni encontrado
$buscar_chip = $_GET['txt_buscar_chip'];

//Inicializo variables
$id_ejemplar = "";
$nombreEjemplar = "";
$fechaChip = "";
$urlFoto =  "";
$anioNacimiento =  "";
$especie = "";
$raza = "";
$pelaje = "";
$tamanio = "";
$sexo = "";
$condicion = "";
$caracter = "";
$capturas = 0;
$castrado = "";
$fechaCastrado = "";
$vacuna = "";
$fechaVacuna = "";
$observaciones = "";
$nroRecibo = "";
$plan = "";
$sextuple=false;
$fechaSextuple="";
$quintuple=false;
$fechaQuintuple="";
$rabia =false;
$fechaRabia="";
$hidatidosis=false;
$fechaHidatidosis="";
$gusanos_redondos=false;
$fechaGusanos="";
$nroChip = "";
$propietarioPrincipal="";


//#########################################LLAMO A BUSCAR EJEMPLAR POR NRO################################

if (!empty($buscar_chip))
{
	$ejemplar = sql_buscar_ejemplar_chip($buscar_chip);

	$numeroRow = mysql_num_rows($ejemplar); // obtenemos el número de filas

	if ($ejemplar && $numeroRow > 0)
	{
		while ($row=mysql_fetch_array($ejemplar))
		{
			$nombreEjemplar = $row['nombre'];
			$urlFoto =  "";
			$anioNacimiento = $row['anio_nacimiento'];

			$tamanio = $row['tamanio'];
			$sexo = $row['sexo'];
			$condicion = $row['condicion'];
			$caracter = $row['caracter'];
			$capturas = $row['capturas'];


			if($row['castrado'] == 0)
			{
				$castrado = "No";
			}elseif($row['castrado'] == 1)
			{
				$castrado = "Si";
			}

			if($row['fecha_castrado'] != '0000-00-00')
			{
				$fechaCastrado = fecha_normal_mysql($row['fecha_castrado']);
			}

			$observaciones = $row['observaciones'];
			$nroChip = $row['numero_chip'];


			$chipeado = sql_buscar_chipeado_animal($row['id_ejemplar']);

			$numeroRowChip = mysql_num_rows($chipeado); // obtenemos el número de filas

			if ($chipeado && $numeroRowChip > 0)
			{
				while ($rowC=mysql_fetch_array($chipeado))
				{
					$fechaChip = fecha_normal_mysql($rowC['fecha_alta']);
					$nroRecibo = $rowC['nro_recibo'];
					$plan = $rowC['plan'];

					$aplicador = $rowC['fk_id_persona'];

					$personaAp = sql_buscar_persona_id($aplicador);

					$rowAplicador=mysql_fetch_array($personaAp);

					$chipeador = $rowAplicador['documento'].' '.$rowAplicador['nombre'].' '.$rowAplicador['apellido'];
				}
			}

			//Busco Especie
			$especie = sql_buscar_especies_por_id($row['fk_id_especie']);

			//Busco Raza
			$raza = sql_buscar_raza_por_id($row['fk_id_raza']);

			//Busco Pelaje
			$pelaje = sql_buscar_pelaje_por_id($row['fk_id_pelaje']);

			//VACUNAS

			$vacunas = sql_traer_vacunas_ejemplar($row['id_ejemplar']);

			$numeroRowVacunas = mysql_num_rows($vacunas); // obtenemos el número de filas

			if ($vacunas && $numeroRowVacunas > 0)
			{
				while ($rowVac=mysql_fetch_array($vacunas))
				{
					if($rowVac['nombre_vacuna'] == "Sextuple")
					{
						$sextuple = true;
						$fechaSextuple = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Quintuple")
					{
						$quintuple = true;
						$fechaQuintuple = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Rabia")
					{
						$rabia = true;
						$fechaRabia = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Hidatidosis")
					{
						$hidatidosis = true;
						$fechaHidatidosis = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Gusanos Redondos")
					{
						$gusanos_redondos = true;
						$fechaGusanos = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}
				}
			}

			$propietario = sql_buscar_propietario_ejemplar($row['id_ejemplar']);

			$numeroRowPropietario = mysql_num_rows($propietario); // obtenemos el número de filas

			if ($propietario && $numeroRowPropietario > 0)
			{
				while ($rowProp=mysql_fetch_array($propietario))
				{
					$propietarioPrincipal=$rowProp['documento']." ".$rowProp['nombre']." ".$rowProp['apellido'];
				}
			}
		}
	}
		else
		$resultadoBusqueda= "El ejemplar no se encuetra cargado en el Sistema.";
}


?>

<!DOCTYPE html>
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
	<script src="../js/bootstrap.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.es.js"></script>
	<script language='javascript' src="../js/jquery.dataTables.min.js"></script>

	<script language='javascript' src="../jscripts/funciones.js"></script>
	<script language='javascript' src="../jscripts/popcalendar.js"></script>
	<script language='javascript' src="../mod_validacion/validacion.js"></script>

	<!-- Bootstrap -->

    <link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet">

</head>


<body onLoad="document.formBuscar.txt_buscar_dni.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

	  <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info"><i class="fa fa-info fa-fw"></i> Cargar Foto</h4>
			<div class="container">
				<form id="frm_detalle_ejemplar" name="frm_detalle_ejemplar" method="post" onsubmit="" action="frm_buscar_ejemplar.php" >

					<div class="panel panel-default">
						<div class="panel-body">

							<form class="form form-signup" role="form">

								<h4 class="text-center"><img src="../images/icons/animal.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
								<h4 class="text-center bg-info">Animal</h4>

								<div class="col-md-6 col-md-offset">
									<div class="panel panel-default">

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
												<input name="txt_nombre_animal" type="text" class="form-control" id="txt_nombre_animal" value="<?php echo $nombreEjemplar;?>" disabled="disabled" />
											</div>
										</div>
									</div>
								</div>


							</form>
						</div>
					</div>	<!-- Container -->
				</form>
			</div>
		</div>
	</div>  <!-- Jumbotron -->
</body>
</html>
