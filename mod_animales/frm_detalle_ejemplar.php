
<?php
error_reporting(0);

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


//Capturo dni encontrado
$buscar_chip = $_POST['txt_buscar_chip'];

//Inicializo variables
$id_ejemplar = "";
$nombreEjemplar = "";
$fechaChip = "";
$anioNacimiento =  "";
$especie = "";
$raza = "";
$pelaje = "";
$tamanio = "";
$alzada = "";
$libreta=false;
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
$desparacitado=false;
$fechaDesparacitado="";
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
$anemia=false;
$fechaAnemia="";
$influenza=false;
$fechaInfluenza="";
$adenitis=false;
$fechaAdenitis="";
$encefalomielitis=false;
$fechaEncefalomielitis="";
$leucemia=false;
$fechaLeucemia="";
$triple=false;
$fechaTriple="";
$rabiaFelino=false;
$fechaRabiaFelino="";
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
			$id_ejemplar=$row['id_ejemplar'];
			$nombreEjemplar = $row['nombre'];
			$anioNacimiento = $row['anio_nacimiento'];
			$alzada = $row['alzada'];

			if($row['libreta'] == 1)
			{
				$libreta = true;
			}

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
					if($rowVac['nombre_vacuna'] == "Desparacitado")
					{
						$desparacitado = $rowVac['nombre_vacuna'];
						$fechaDesparacitado = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}
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
						if($especie == "Canina")
						{
							$rabia = true;
							$fechaRabia = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}elseif($especie == "Felina")
						{
							$rabiaFelino = true;
							$fechaRabiaFelino = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}
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

					if($rowVac['nombre_vacuna'] == "Anemia Infecciosa")
					{
						$anemia = true;
						$fechaAnemia = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Influenza Equina")
					{
						$influenza = true;
						$fechaInfluenza = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Adenitis Equina")
					{
						$adenitis = true;
						$fechaAdenitis = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Encefalomielitis")
					{
						$encefalomielitis = true;
						$fechaEncefalomielitis = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Triple")
					{
						$triple = true;
						$fechaTriple = fecha_normal_mysql($rowVac['fecha_aplicacion']);
					}

					if($rowVac['nombre_vacuna'] == "Leucemia")
					{
						$leucemia = true;
						$fechaLeucemia = fecha_normal_mysql($rowVac['fecha_aplicacion']);
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

			$persona_chip = sql_buscar_chipeador_ejemplar($id_ejemplar);

			if ($persona_chip)
			{
				while ($row=mysql_fetch_array($persona_chip))
				{
					$nombre_chipeador = $row['nombre_chipeador'];
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

<script type="text/JavaScript">

function set_focus()
{
	document.getElementById("txt_nombre_animal").focus();
	alert("focus animal sexo");
	return (false);
}

</script>

</head>


<body onLoad="document.formBuscar.txt_buscar_dni.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

	  <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info"><i class="fa fa-info fa-fw"></i> Detalle Animal</h4>
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

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha Chipeado / Patentado </span>
												<input name="txt_fecha_chip" type="text" class="form-control" id="txt_fecha_chip" value="<?php echo $fechaChip;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Institución</span>
												<input name="txt_plan" type="text" class="form-control" id="txt_plan" value="<?php echo $plan;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar-check-o fa-fw"></i> Año Nacimiento</span>
												<input name="txt_anio_animal" type="text" class="form-control" id="txt_anio_animal" value="<?php echo $anioNacimiento;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-bug fa-fw"></i> Especie</span>
												<input name="txt_especie" type="text" class="form-control" id="txt_especie" value="<?php echo $especie;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Raza</span>
												<input name="txt_raza" type="text" class="form-control" id="txt_raza" value="<?php echo $raza;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Pelaje</span>
												<input name="txt_pelaje" type="text" class="form-control" id="txt_pelaje" value="<?php echo $pelaje;?>" disabled="disabled" />
											</div>
										</div>

										<?php
											if($especie == "Equina")
											{ ?>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-arrows-v fa-fw"></i> Alzada</span>
														<input name="txt_alzada" type="text" class="form-control" id="txt_alzada" value="<?php echo $alzada;?>" disabled="disabled" />
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Libreta Sanitaria <input type="checkbox" name="libreta" value="Libreta" <?php if($libreta == true) echo "checked='checked'"; ?> disabled="disabled"/> </span>
													</div>
												</div>

											<?php }else
											{?>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Tamaño</span>
														<input name="txt_tamanio" type="text" class="form-control" id="txt_tamanio" value="<?php echo $tamanio;?>" disabled="disabled" />
													</div>
												</div>
											<?php }
											?>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-venus-mars fa-fw"></i> Sexo</span>
												<input name="txt_sexo" type="text" class="form-control" id="txt_sexo" value="<?php echo $sexo;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-certificate fa-fw"></i> Condición</span>
												<input name="txt_condicion" type="text" class="form-control" id="txt_condicion" value="<?php echo $condicion;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Carácter</span>
												<input name="txt_caracter" type="text" class="form-control" id="txt_caracter" value="<?php echo $caracter;?>" disabled="disabled" />
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user-md fa-fw"></i> Castrado <br><br>

													<div class="col-xs-5 col-md-offset-0">
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon">¿Castrado?</span>
																<input name="txt_castrado" type="text" class="form-control" id="txt_castrado" value="<?php echo $castrado;?>" disabled="disabled" />
															</div>
														</div>
													</div>

													<div class="input-group">
														<span class="input-group-addon">Fecha </span>
														<input name="txt_fecha_castrado" type='text' id="txt_fecha_castrado" class="form-control" value="<?php echo $fechaCastrado;?>" disabled="disabled" />
													</div>
													<br>
												</span>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-ticket fa-fw"></i> Nro. Recibo*</span>
												<input name="txt_nro_recibo" type="text" class="form-control" id="txt_nro_recibo" value="<?php echo $nroRecibo;?>" disabled="disabled" />
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6 col-md-offset">
									<div class="panel panel-default">

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-flag-o fa-fw"></i> Capturas</span>
												<input name="txt_capturas" type="text" class="form-control" id="txt_capturas" value="<?php echo $capturas;?>" disabled="disabled" />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">

												<span class="input-group-addon"><i class="fa fa-medkit fw" aria-hidden="true"></i> Desparacitado y Vacunas 

												<div class="form-group">

													<div class="col-xs-5 col-md-offset-0">
														<br><br>
														<input type="checkbox" name="desparacitado" value="Desparacitado" <?php if($desparacitado == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Desparacitado</label>
													</div>
													<br>
													<div class="form-group">
														<div class="input-group">
															<span class="input-group-addon"> Fecha</span>
															<input name="txt_fecha_desparacitado" type="text" class="form-control" id="txt_fecha_desparacitado" value="<?php if($desparacitado == true) echo $fechaDesparacitado;?>" disabled="disabled" />
														</div>
													</div>
												</div>
												<?php
													switch ($especie) {
														case "Canina":
														?>
														<div class="form-group">

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
																<input type="checkbox" name="sextuple" value="Sextuple" <?php if($sextuple == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Sextuple</label>
															</div>
															<br>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon"> Fecha</span>
																	<input name="txt_fecha_sextuple" type="text" class="form-control" id="txt_fecha_sextuple" value="<?php if($sextuple == true) echo $fechaSextuple;?>" disabled="disabled" />
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
																<input type="checkbox" name="quintuple" value="Quintuple" <?php if($quintuple == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Quintuple</label>
															</div>
															<br>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon">Fecha </span>
																	<input name="txt_fecha_quintuple" type='text' id="txt_fecha_quintuple" class="form-control" value="<?php if($quintuple == true) echo $fechaQuintuple;?>" disabled="disabled" />
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
															<br><br>
																<input type="checkbox" name="rabia" value="Rabia" <?php if($rabia == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Rabia</label>
															</div>
															<br>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon">Fecha </span>
																	<input name="txt_fecha_rabia" type='text' id="txt_fecha_rabia" class="form-control" value="<?php if($rabia == true) echo $fechaRabia;?>" disabled="disabled" />
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
																<input type="checkbox" name="hidatidosis" value="Hidatidosis" <?php if($hidatidosis == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Hidatidosis</label>
															</div>
															<br>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon">Fecha </span>
																	<input name="txt_fecha_hidatidosis" type='text' id="txt_fecha_hidatidosis" class="form-control" value="<?php if($hidatidosis == true) echo $fechaHidatidosis;?>" disabled="disabled" />
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
																<input type="checkbox" name="gusanos_redondos" value="Gusanos_redondos"  <?php if($gusanos_redondos == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Gusanos Redondos</label>
															</div>
															<br>
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon">Fecha </span>
																	<input name="txt_fecha_gusanos" type='text' id="txt_fecha_gusanos" class="form-control" value="<?php if($gusanos_redondos == true) echo $fechaGusanos;?>" disabled="disabled" />
																</div>
															</div>
														</div>
												<?php break;

												case "Equina":
												?>
													<div class="form-group">
														<div class="col-xs-5 col-md-offset-0">
															<br><br>
  															<input type="checkbox" name="anemia" value="Anemia" <?php if($anemia == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Anemia Infecciosa </label>
  														</div>
  														<br>
  														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon">Fecha </span>
																<input name="txt_fecha_anemia" type='text' id="txt_fecha_anemia" class="form-control" value="<?php if($anemia == true) echo $fechaAnemia;?>" disabled="disabled" />
															</div>
														</div>

  														<div class="col-xs-5 col-md-offset-0">
															<br><br>
  															<input type="checkbox" name="influenza" value="Influenza" <?php if($influenza == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Influenza Equina </label>
  														</div>
  														<br>
  														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon">Fecha </span>
																<input name="txt_fecha_influenza" type='text' id="txt_fecha_influenza" class="form-control" value="<?php if($influenza == true) echo $fechaInfluenza;?>" disabled="disabled" />
															</div>
														</div>

														<div class="col-xs-5 col-md-offset-0">
															<br><br>
  															<input type="checkbox" name="adenitis" value="Adenitis" <?php if($adenitis == true) echo "checked='checked'"; ?> disabled="disabled"/> <label>Adenitis Equina </label>
  														</div>
  														<br>
  														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon">Fecha </span>
																<input name="txt_fecha_adenitis" type='text' id="txt_fecha_adenitis" class="form-control" value="<?php if($adenitis == true) echo $fechaAdenitis;?>" disabled="disabled" />
															</div>
														</div>

  														<div class="col-xs-5 col-md-offset-0">
															<br><br>
  															<input type="checkbox" name="encefalomielitis" value="Encefalomielitis" <?php if($encefalomielitis == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Encefalomielitis </label>
  														</div>
  														<br>
  														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon">Fecha </span>
																<input name="txt_fecha_encefalomielitis" type='text' id="txt_fecha_encefalomielitis" class="form-control" value="<?php if($encefalomielitis == true) echo $fechaEncefalomielitis;?>" disabled="disabled" />
															</div>
														</div>

													</div>
													<?php break;
													case "Felina":?>

														<div class="form-group">
															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="leucemia" value="Leucemia" <?php if($leucemia == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Leucemia </label>
	  														</div>
	  														<br>
	  														<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon">Fecha </span>
																	<input name="txt_fecha_leucemia" type='text' id="txt_fecha_leucemia" class="form-control" value="<?php if($leucemia == true) echo $fechaLeucemia;?>" disabled="disabled" />
																</div>
															</div>

	  														<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="rabiaFelino" value="RabiaFelino" <?php if($rabiaFelino == true) echo "checked='checked'"; ?> disabled="disabled" /> <label>Rabia </label>
	  														</div>
	  														<br>
	  														<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon">Fecha </span>
																	<input name="txt_fecha_rabia_felino" type='text' id="txt_fecha_rabia_felino" class="form-control" value="<?php if($rabiaFelino == true) echo $fechaRabiaFelino;?>" disabled="disabled" />
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="triple" value="Triple" <?php if($triple == true) echo "checked='checked'"; ?> disabled="disabled"/> <label>Triple </label>
	  														</div>
	  														<br>
	  														<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon">Fecha </span>
																	<input name="txt_fecha_triple" type='text' id="txt_fecha_triple" class="form-control" value="<?php if($triple == true) echo $fechaTriple;?>" disabled="disabled" />
																</div>
															</div>

														</div>

													<?php break;
													} ?>

												</span>
											</div>
										</div>

										<div class="form-group">
										   <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
										   <textarea class="form-control" rows="3" id="txt_observacion" name="txt_observacion" disabled="disabled" ><?php echo $observaciones; ?></textarea>
										</div>

									</div>
								</div>

								<div class="row">
									<div class="col-md-12 col-md-offset">
										<div class="panel panel-default">
											<div class="panel-body">
												<h4 class="text-center"><img src="../images/icons/propietario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

												<div class="col-md-6 col-md-offset">
													<div class="panel panel-default">
														<div class="panel-body">

															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-user fa-fw"></i>Propietario</span>
																	<input name="txt_propietario" type="text" class="form-control" id="txt_propietario" value="<?php echo $propietarioPrincipal;?>" disabled="disabled" />
																</div>
															</div>

															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-user fa-fw"></i> Chipeado / Patentado por: </span>

																	<input name="txt_chipeador" type="text" class="form-control" id="txt_chipeador"  value="<?php echo $nombre_chipeador; ?>" disabled="disabled"/>
																</div>
															</div>

															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-microchip fa-fw"></i> Nro. CHIP / Patente*</span>
																	<input name="txt_nro_chip" type="text" class="form-control" id="txt_nro_chip" value="<?php echo $nroChip;?>"  disabled="disabled" />
																</div>
															</div>

														</div>
													</div>
												</div>

												<div class="col-md-6 col-md-offset">
													<div class="panel panel-default">
														<div class="panel-body">
															 <span class="input-group-addon">Fotografías Animal</span>
                             								 <div class="container">
																<?php
																$link=conectarse_mysql_veterinaria();
															 	$sql_images="select id,archivo from ejemplares_fotos where id_ejemplar=$id_ejemplar";
													   		$result_images=mysql_query($sql_images,$link);
																$i =0;
													   		?>
																<div id="myCarousel" class="carousel slide" data-ride="carousel">
																	 <!-- Wrapper for slides -->
																	 <div class="carousel-inner" style=" width:100%; height: 350px !important;">

																		 <div class="item active">
																			 <img width="100%" src="../images/portada.jpg" alt="">
																		 </div>

																		  <?php while($imagenes=mysql_fetch_array($result_images)){ ?>

																				<div class="item">
			 																		 <img width="95%" src="imagenes_ejemplares/<?php echo $imagenes['archivo']; ?>" alt="<?php echo $imagenes['archivo']; ?>">
			 																	 </div>
																			 <?php }?>


																	 <!-- Left and right controls -->
																	 <a class="left carousel-control" href="#myCarousel" data-slide="prev">
																		 <span class="glyphicon glyphicon-chevron-left"></span>
																		 <span class="sr-only">Previous</span>
																	 </a>
																	 <a class="right carousel-control" href="#myCarousel" data-slide="next">
																		 <span class="glyphicon glyphicon-chevron-right"></span>
																		 <span class="sr-only">Next</span>
																	 </a>
																	</div>
																</div>
															</div>
															
                            							</div>
                            							<input name="Submit" type="submit" method="post" class="btn btn-sm btn-primary btn-block" value="CERRAR" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div><!-- cierra row -->
							</form>
						</div>
					</div>	<!-- Container -->
				</form>
			</div>
		</div>
	</div>  <!-- Jumbotron -->

	<!--script type="text/javascript">
		$(document).ready(function(e)
		{
			$('.carousel-indicators li:nth-child(1)').addClass('active');
			$('.item:nth-child(1)').addClass('active');
		});

	</script-->
</body>
</html>
