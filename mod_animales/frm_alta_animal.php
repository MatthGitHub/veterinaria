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


//Inicializo variables
$valFechaCastrado=false;

$valDesparacitado=false;
$valSextuple=false;
$valQuintuple=false;
$valRabia=false;
$valHidatidosis=false;
$valGusanos=false;
$valLeucemia=false;
$valRabiaFelina=false;
$valTriple=false;
$valAnemia=false;
$valInfluenza=false;
$valAdenitis=false;
$valEncefalomielitis=false;

$validadoAnimal = false;
$successAnimal = false;
$errorEjemplar = false;
$errorChip = false;



$id_ejemplar = "";
$nombreEjemplar = "";
$fechaChip = "";
$anioNacimiento = "";
$especie = "";
$raza = "";
$pelaje = "";
$tamanio = "";
$alzada = "";
$libreta = "";
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
$desparacitado = "";
$sextuple="";
$fechaSextuple="";
$quintuple="";
$fechaQuintuple="";
$rabia ="";
$fechaRabia="";
$hidatidosis="";
$fechaHidatidosis="";
$gusanos_redondos="";
$fechaGusanos="";
$anemia="";
$fechaAnemia="";
$influenza="";
$fechaInfluenza="";
$adenitis="";
$fechaAdenitis="";
$encefalomielitis="";
$fechaEncefalomielitis="";
$leucemia="";
$fechaLeucemia="";
$triple="";
$fechaTriple="";
$rabiaFelino="";
$fechaRabiaFelino="";
$nroChip = "";
$nombre_chipeador = "";

//Cargo especies
$especies = sql_buscar_especies();

//Cargo pelajes
$pelajes= sql_traer_pelajes();

//Cargo propietarios
//$propietarios = sql_traer_propietarios();

$chipeadores = sql_traer_chipeadores();

//Capturo variables
if ($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST['txt_nombre'])&&isset($_POST['txt_apellido'])&&isset($_POST['txt_id_persona'])){
		$propietarioPrincipal = test_input($_POST['txt_nombre'])." ".test_input($_POST['txt_apellido']);
		$id_persona = test_input($_POST['txt_id_persona']);
	}

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// CUANDO DAN GUARDAR VALIDO Y PERSISTO

if(isset($_POST['guardar_ejemplar']))
{
	$propietarioPrincipal = test_input($_POST['txt_propietario']);
		//echo 'propietario '.$_POST['txt_propietario'];
	$id_persona = test_input($_POST['txt_documento_prop']);

		//echo ' / doc '.$_POST['txt_documento_prop'];

		//echo "Propietario: ".$_POST['txt_propietario'];
	//exit();
	
	/*echo "Prop:".$_POST['txt_propietario'];
	exit();*/

	$nombreEjemplar = test_input($_POST['txt_nombre_animal']);

	$fechaChip = test_input($_POST['txt_fecha_chip']);

	$anioNacimiento =  test_input($_POST['txt_anio_animal']);

	$capturas = test_input($_POST['txt_capturas']);

	$fechaCastrado = test_input($_POST['txt_fecha_castrado']);

	$observaciones = test_input($_POST['txt_observacion']);

	$nroRecibo = test_input($_POST['txt_nro_recibo']);

	$nroChip = test_input($_POST['txt_nro_chip']);

	$alzada = test_input($_POST['txt_alzada']);


	if (isset($_POST['libreta']) && $_POST['libreta'] == 'Libreta')
	{
		$libreta=1;
	}


	//COMBOS

	//capturo especie seleccionada y parametros cargados
	$especie = $_POST['select_especie'];

	$raza = $_POST['select_raza'];
	
	$pelaje = $_POST['select_pelaje'];
	
	$tamanio = $_POST['select_tamanio'];
	
	$sexo = $_POST['select_sexo'];
	
	$condicion = $_POST['select_condicion'];
	
	$caracter = $_POST['select_caracter'];

	$castrado = $_POST['select_castrado'];	

	$plan = $_POST['select_plan'];
	
	$nombre_chipeador = $_POST['select_chipeadores'];



	if (isset($_POST['desparacitado']) && $_POST['desparacitado'] == 'Desparacitado')
	{
		if(isset($_POST['txt_fecha_desparacitado']) && $_POST['txt_fecha_desparacitado']!="")
		{
			$desparacitado='Desparacitado';
			$fechaDesparacitado=test_input($_POST['txt_fecha_desparacitado']);	

		}else{
			$valDesparacitado = true;
		}
	}

	if (isset($_POST['sextuple']) && $_POST['sextuple'] == 'Sextuple')
	{
		if(isset($_POST['txt_fecha_sextuple']) && $_POST['txt_fecha_sextuple']!="")
		{
			$sextuple='Sextuple';
			$fechaSextuple=test_input($_POST['txt_fecha_sextuple']);	

		}else{
			$valSextuple = true;
		}
	}

	if (isset($_POST['quintuple']) && $_POST['quintuple'] == 'Quintuple')
	{
		if(isset($_POST['txt_fecha_quintuple']) && $_POST['txt_fecha_quintuple']!="")
		{
			$quintuple='Quintuple';
			$fechaQuintuple=test_input($_POST['txt_fecha_quintuple']);
			
		}else{
			$valQuintuple=true;
		}
	}


	if (isset($_POST['rabia']) && $_POST['rabia'] == 'Rabia')
	{
		if(isset($_POST['txt_fecha_rabia']) && $_POST['txt_fecha_rabia']!="")
		{
			$rabia='Rabia';
			$fechaRabia=test_input($_POST['txt_fecha_rabia']);
			
		}else{
			$valRabia=true;
		}
	}

	if (isset($_POST['hidatidosis']) && $_POST['hidatidosis'] == 'Hidatidosis')
	{
		if(isset($_POST['txt_fecha_hidatidosis']) && $_POST['txt_fecha_hidatidosis']!="")
		{
			$hidatidosis='Hidatidosis';
			$fechaHidatidosis=test_input($_POST['txt_fecha_hidatidosis']);
			
		}else{
			$valHidatidosis=true;
		}
	}

	if (isset($_POST['gusanos_redondos']) && $_POST['gusanos_redondos'] == 'Gusanos_redondos')
	{
		if(isset($_POST['txt_fecha_gusanos']) && $_POST['txt_fecha_gusanos']!="")
		{
			$gusanos_redondos='Gusanos Redondos';
			$fechaGusanos=test_input($_POST['txt_fecha_gusanos']);
			
		}else{
			$valGusanos=true;
		}
	}

	if (isset($_POST['anemia']) && $_POST['anemia'] == 'Anemia')
	{
		if(isset($_POST['txt_fecha_anemia']) && $_POST['txt_fecha_anemia']!="")
		{
			$anemia='Anemia';
			$fechaAnemia=test_input($_POST['txt_fecha_anemia']);
			
		}else{
			$valAnemia = true;
		}
	}

	if (isset($_POST['influenza']) && $_POST['influenza'] == 'Influenza')
	{
		if(isset($_POST['txt_fecha_influenza']) && $_POST['txt_fecha_influenza']!="")
		{
			$influenza='Influenza';
			$fechaInfluenza=test_input($_POST['txt_fecha_influenza']);
			
		}else{
			$valInfluenza = true;
		}
	}

	if (isset($_POST['adenitis']) && $_POST['adenitis'] == 'Adenitis')
	{
		if(isset($_POST['txt_fecha_adenitis']) && $_POST['txt_fecha_adenitis']!="")
		{
			$adenitis='Adenitis';
			$fechaAdenitis=test_input($_POST['txt_fecha_adenitis']);
			
		}else{
			$valAdenitis = true;
		}
	}

	if (isset($_POST['encefalomielitis']) && $_POST['encefalomielitis'] == 'Encefalomielitis')
	{
		if(isset($_POST['txt_fecha_encefalomielitis']) && $_POST['txt_fecha_encefalomielitis']!="")
		{
			$encefalomielitis='Encefalomielitis';
			$fechaEncefalomielitis=test_input($_POST['txt_fecha_encefalomielitis']);
			
		}else{
			$valEncefalomielitis = true;
		}
	}

	if (isset($_POST['leucemia']) && $_POST['leucemia'] == 'Leucemia')
	{
		if(isset($_POST['txt_fecha_leucemia']) && $_POST['txt_fecha_leucemia']!="")
		{
			$leucemia='Leucemia';
			$fechaLeucemia=test_input($_POST['txt_fecha_leucemia']);
			
		}else{
			$valLeucemia = true;
		}
	}

	if (isset($_POST['rabiaFelino']) && $_POST['rabiaFelino'] == 'RabiaFelino')
	{
		if(isset($_POST['txt_fecha_rabia_felino']) && $_POST['txt_fecha_rabia_felino']!="")
		{
			$rabiaFelino='Rabia';
			$fechaRabiaFelino=test_input($_POST['txt_fecha_rabia_felino']);
			
		}else{
			$valRabiaFelino = true;
		}
	}

	if (isset($_POST['triple']) && $_POST['triple'] == 'Triple')
	{
		if(isset($_POST['txt_fecha_triple']) && $_POST['txt_fecha_triple']!="")
		{
			$triple='Triple';
			$fechaTriple=test_input($_POST['txt_fecha_triple']);
			
		}else{
			$valTriple = true;
		}
	}

	if($castrado== 'Si' && $fechaCastrado=="")
	{
		$valFechaCastrado = true;
	}elseif($valDesparacitado == true)
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}elseif($especie == "Canina" && ($valSextuple == true || $valQuintuple == true || $valHidatidosis == true || $valRabia == true || $valGusanos == true))
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}elseif($especie == "Felina" && ($valLeucemia == true || $valRabiaFelino == true || $valTriple == true))
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}elseif($especie == "Equina" && ($valAnemia == true || $valInfluenza == true || $valAdenitis == true || $valEncefalomielitis == true))
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}else{
		$validadoAnimal=true;
	}

	//#########################################PERSISTIR DATOS####################################################


	$successAnimal = false;

	if (!sql_buscar_animal_duplicado($nroChip) && $nroChip != "" && $validadoAnimal == true)
	{
		$fk_id_ejemplar = sql_insert_ejemplar($nombreEjemplar,$anioNacimiento,$especie,$raza,$pelaje,$tamanio,$alzada,$libreta,$sexo,$condicion,$desparacitado, $fechaDesparacitado, $caracter,$capturas,$castrado,$fechaCastrado,$observaciones,$nroChip, $fechaChip, $plan, $nroRecibo, $sextuple, $fechaSextuple, $quintuple, $fechaQuintuple, $rabia, $fechaRabia, $hidatidosis, $fechaHidatidosis,
		 $gusanos_redondos, $fechaGusanos, $anemia, $fechaAnemia, $influenza, $fechaInfluenza, $adenitis, $fechaAdenitis, $encefalomielitis, $fechaEncefalomielitis, $leucemia, $fechaLeucemia, $rabiaFelino, $fechaRabiaFelino, $triple, $fechaTriple, $id_persona, $nombre_chipeador);


		if (!$fk_id_ejemplar)
		{
			$errorEjemplar = true;
		}
		else{

			$successAnimal = true;
		}
	}elseif(sql_buscar_animal_duplicado($nroChip) && $nroChip != "")
	{
		$errorChip = true;
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
	<script src="../js/bootstrap.min.js"></script>
    <script src="../js/moment.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.min.js"></script>
    <script src="../js/bootstrap-datetimepicker.es.js"></script>
	<script src="../js/jquery.dataTables.min.js"></script>

	<script src="../jscripts/funciones.js"></script>
	<script src="../mod_validacion/validacion.js"></script>

	<!-- Combobox autocomplete -->
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Bootstrap -->

    <link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="../css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!--estilo para combobox-->

	<style>
	.custom-combobox {
	position: relative;
	display: inline-block;
	}
	.custom-combobox-toggle {
	position: absolute;
	top: 0;
	bottom: 0;
	margin-left: -1px;
	padding: 0;
	}
	.custom-combobox-input {
	margin: 0;
	padding: 5px 10px;
	height: 50px;
    width: 180%;
	}
	</style>

	<script type="text/JavaScript">

	//Funcion trae areas segun especie
	 $(document).ready(function(){
      $("#select_especie").change(function(){
        $.ajax({
          url:"traer_razas.php",
          type: "POST",
          data:"especie="+$("#select_especie").val(),
          success: function(opciones){
            $("#select_raza").html(opciones);
          }
        })
      });
    });

	//////////////////////////////////////////////////////////////

	function set_focus()
	{
		document.getElementById("txt_nombre_animal").focus();
		alert("focus animal nombre");
		return (false);
	}


	</script>
</head>

<body onLoad="document.frm_alta_animal.txt_nombre_animal.focus();">

	<div class="container">
		<br>
		<?php include("../inc/menu.php"); ?>

	  <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info">Cargar Animal</h4>
			<div class="container">

				<form id="form1" name="form1" method="post" onsubmit="" action="<?php $_SERVER["PHP_SELF"];?>">

					<div class="row">
						<div class="col-md-12 col-md-offset">

							<?php
								if($valDesparacitado == true)
								{
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe completar la FECHA de desparacitado.</div>
									";
									$valDesparacitado = false;
								}elseif($especie == "Canina" && ($valSextuple == true || $valQuintuple == true || $valHidatidosis == true || $valRabia == true || $valGusanos == true)){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe completar la FECHA de aplicacion en las vacunas seleccionadas.</div>
									";
									$valSextuple = false;
									$valQuintuple = false;
									$valHidatidosis = false;
									$valRabia = false;
									$valGusanos = false;
								}elseif($especie == "Felina" && ($valLeucemia == true || $valRabiaFelino == true || $valTriple == true)){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe completar la FECHA de aplicacion en las vacunas seleccionadas.</div>
									";
									$valLeucemia = false;
									$valRabiaFelino = false;
									$valTriple = false;

								}elseif($especie == "Equina" && ($valAnemia == true || $valInfluenza == true || $valAdenitis == true || $valEncefalomielitis == true)){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe completar la FECHA de aplicacion en las vacunas seleccionadas.</div>
									";
									$valAnemia = false;
									$valInfluenza = false;
									$valAdenitis = false;
									$valEncefalomielitis = false;

								}elseif($valFechaCastrado == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar la fecha de castracion.</div>
									";
									$valFechaCastrado = false;
								}elseif($successAnimal == true){
									echo "
										<div class='alert alert-success-alt alert-dismissable'>
										<span class='glyphicon glyphicon-ok'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>El Animal se cargó correctamente.</div>
									";
									$successAnimal = false;
								}elseif($errorEjemplar == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Error al cargar el Animal.</div>
									";
									$errorEjemplar = false;
								}
								elseif($errorChip == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>El chip indicado ya existe.</div>
									";
									$errorChip = false;
								}
							?>

							<div class="panel panel-default">
								<div class="panel-body">

									<form class="form form-signup" role="form">

										<h4 class="text-center"><img src="../images/icons/animal.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>
										<h4 class="text-center bg-info">Animal</h4>

										<div class="col-md-6 col-md-offset">
											<div class="panel panel-default">

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre*</span>
														<input name="txt_nombre_animal" type="text" class="form-control" id="txt_nombre_animal" value="<?php echo $nombreEjemplar;?>" onkeypress="return tabular(event,this)"/>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha Chipeado /Patentado* </span>
														<div class='input-group date' id='divMiCalendario'>
															<input name="txt_fecha_chip" type='text' id="txt_fecha_chip" class="form-control" value="<?php echo $fechaChip;?>" required/>
															<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Institución*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" name="select_plan" required>
															  <option value="Municipal">Municipal</option>
															  <option value="Veterinaria">Veterinaria</option>
															  <option  selected="selected"><?php echo $plan;?></option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-calendar-check-o fa-fw"></i> Año Nacimiento*</span>
														<input name="txt_anio_animal" type="number" class="form-control" id="txt_anio_animal" value="<?php echo $anioNacimiento;?>" onkeypress="return tabular(event,this)"  required/>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-bug fa-fw"></i> Especie*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" id="select_especie" name="select_especie"  required>
																<option  selected="selected"> <?php echo $especie;?> </option>
																<?php
																	while ($row=mysql_fetch_array($especies))
																	{
																		$id_especie = ($row['id_especie']);

																		$especie = ($row['especie']);

																		?>
																	<option value = "<?php echo $especie; ?>" ><?php echo $especie;?> </option>
																<?php
																}
																?>

															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Raza*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" id="select_raza" name="select_raza" required>
																<option  selected="selected"><?php echo $raza;?></option>
																<?php
																	while ($row=mysql_fetch_array($razas))
																	{
																		$id_raza = ($row['id_raza']);
																		$raza = ($row['raza']);

																	?>
																<option value = "<?php echo $raza;?>" ><?php echo $raza;?> </option>
																<?php
																	}
																?>

															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Pelaje* </span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" name="select_pelaje" required>
																<option  selected="selected"><?php echo $pelaje;?></option>
																<?php
																	while ($row=mysql_fetch_array($pelajes))
																	{
																		$id_pelaje = ($row['id_pelaje']);
																		$pelaje = ($row['pelaje']);

																	?>
																<option value = "<?php echo $pelaje;?>" ><?php echo  utf8_encode($pelaje);?> </option>
																<?php
																	}
																?>


															</select>
														</div>
													</div>
												</div>

												<h5 class="text-center bg-info"> Equino </h5>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-arrows-v fa-fw"></i> Alzada*</span>
														<input name="txt_alzada" type="text" class="form-control" id="txt_alzada" value="<?php echo $alzada;?>" onkeypress="return tabular(event,this)"/>
													</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Libreta Sanitaria <input type="checkbox" name="libreta" value="Libreta"<?php if(isset($_POST['libreta'])) echo "checked='checked'"; ?> /> </span>
													</div>
												</div>
												<h5 class="text-center bg-info"> ------ </h5>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Tamaño*</span>
														<div class="col-xs-15 selectContainer">
															<select  class="form-control" name="select_tamanio" required>
																<option value="Extra Grande">Extra Grande</option>
																<option value="Grande">Grande</option>
																<option value="Mediano">Mediano</option>
																<option value="Chico">Chico</option>
																<option  selected="selected"><?php echo $tamanio;?></option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-venus-mars fa-fw"></i> Sexo*</span>
														<div class="col-xs-15 selectContainer">
															<select  class="form-control" name="select_sexo" required>
																<option value="Macho">Macho</option>
																<option value="Hembra">Hembra</option>
																<option  selected="selected"><?php echo $sexo;?></option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-certificate fa-fw"></i> Condición*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" name="select_condicion" required>
																<option value="Adoptado Perrera">Adoptado Perrera</option>
																<option value="Adoptado Asoc. Protectora">Adoptado Asoc. Protectora</option>
																<option value="Propio">Propio</option>
																<option value="En Tránsito">En Tránsito</option>
																<option value="Fallecido">Fallecido</option>
																<option  selected="selected"><?php echo $condicion;?></option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Carácter*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" name="select_caracter" required>
																<option value="Sociable">Sociable</option>
																<option value="Peligroso">Peligroso</option>
																<option  selected="selected"><?php echo $caracter;?></option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-flag-o fa-fw"></i> Capturas*</span>
														<input name="txt_capturas" type="number" min="0" class="form-control" id="txt_capturas" value="<?php echo $capturas;?>" onkeypress="return tabular(event,this)" placeholder="Cantidad" required/>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-user-md fa-fw"></i> Castrado* <br><br>
														<div class="col-xs-4 col-md-offset-0">
															<div class="form-group">
																<select class="form-control" name="select_castrado" required>
																	<option value="No">No</option>
															  		<option value="Si">Si</option>
																 	<option  selected="selected"><?php echo $castrado;?></option>
																</select>
															</div>
														</div>

														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendario1'>
																	<input name="txt_fecha_castrado" type='text' id="txt_fecha_castrado" class="form-control" value="<?php echo $fechaCastrado;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
														</div>
														<br>
														</span>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-ticket fa-fw"></i> Nro. Recibo*</span>
														<input name="txt_nro_recibo" type="text" class="form-control" id="txt_nro_recibo" value="<?php echo $nroRecibo;?>" onkeypress="return tabular(event,this)" required/>
													</div>
												</div>

											</div>
										</div>

										<div class="col-md-6 col-md-offset">
											<div class="panel panel-default">



												<div class="form-group">
													<div class="input-group">

														<span class="input-group-addon"><i class="fa fa-medkit fw" aria-hidden="true"></i> Desparacitado y Vacunas
														<br>
														<div class="col-xs-5 col-md-offset-0">
														<br><br>
															<input type="checkbox" name="desparacitado" value="Desparacitado" <?php if(isset($_POST['desparacitado'])) echo "checked='checked'"; ?> /> <label>Desparacitado</label>
														</div>
														<br>
														<div class="input-group">
															<span class="input-group-addon">Fecha* </span>
															<div class='input-group date' id='divMiCalendarioDesparacitado'>
																<input name="txt_fecha_desparacitado" type='text' id="txt_fecha_desparacitado" class="form-control" value="<?php echo $fechaDesparacitado;?>"/>
																<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
															</div>
														</div>
														<br>
														<h5 class="text-center bg-info"> Canina</h5>

													
															<div class="col-xs-5 col-md-offset-0">
															<br><br>
																<input type="checkbox" name="sextuple" value="Sextuple" <?php if(isset($_POST['sextuple'])) echo "checked='checked'"; ?> /> <label>Sextuple</label>
															</div>
															<br>
															<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioSextuple'>
																	<input name="txt_fecha_sextuple" type='text' id="txt_fecha_sextuple" class="form-control" value="<?php echo $fechaSextuple;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>


															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="quintuple" value="Quintuple" <?php if(isset($_POST['quintuple'])) echo "checked='checked'"; ?> /> <label>Quintuple</label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioQuintuple'>
																	<input name="txt_fecha_quintuple" type='text' id="txt_fecha_quintuple" class="form-control" value="<?php echo $fechaQuintuple;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="rabia" value="Rabia" <?php if(isset($_POST['rabia'])) echo "checked='checked'"; ?> /> <label>Rabia </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioRabia'>
																	<input name="txt_fecha_rabia" type='text' id="txt_fecha_rabia" class="form-control" value="<?php echo $fechaRabia;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

	  														<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="hidatidosis" value="Hidatidosis" <?php if(isset($_POST['hidatidosis'])) echo "checked='checked'"; ?> /> <label>Hidatidosis</label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioHidatidosis'>
																	<input name="txt_fecha_hidatidosis" type='text' id="txt_fecha_hidatidosis" class="form-control" value="<?php echo $fechaHidatidosis;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

	  														<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="gusanos_redondos" value="Gusanos_redondos"  <?php if(isset($_POST['gusanos_redondos'])) echo "checked='checked'"; ?> /> <label>Gusanos Redondos</label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioGusanos'>
																	<input name="txt_fecha_gusanos" type='text' id="txt_fecha_gusanos" class="form-control" value="<?php echo $fechaGusanos;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

		  													<h5 class="text-center bg-info"> Equino </h5>
															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="anemia" value="Anemia" <?php if(isset($_POST['anemia'])) echo "checked='checked'"; ?> /> <label>Anemia Infecciosa </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioAnemia'>
																	<input name="txt_fecha_anemia" type='text' id="txt_fecha_anemia" class="form-control" value="<?php echo $fechaAnemia;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="influenza" value="Influenza" <?php if(isset($_POST['influenza'])) echo "checked='checked'"; ?> /> <label>Influenza Equina </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioInfluenza'>
																	<input name="txt_fecha_influenza" type='text' id="txt_fecha_influenza" class="form-control" value="<?php echo $fechaInfluenza;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="adenitis" value="Adenitis" <?php if(isset($_POST['adenitis'])) echo "checked='checked'"; ?> /> <label>Adenitis Equina </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioAdenitis'>
																	<input name="txt_fecha_adenitis" type='text' id="txt_fecha_adenitis" class="form-control" value="<?php echo $fechaAdenitis;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="encefalomielitis" value="Encefalomielitis" <?php if(isset($_POST['encefalomielitis'])) echo "checked='checked'"; ?> /> <label>Encefalomielitis </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioEncefalomielitis'>
																	<input name="txt_fecha_encefalomielitis" type='text' id="txt_fecha_encefalomielitis" class="form-control" value="<?php echo $fechaEncefalomielitis;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

															<h5 class="text-center bg-info"> Felina </h5>
															
															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="leucemia" value="Leucemia" <?php if(isset($_POST['leucemia'])) echo "checked='checked'"; ?> /> <label>Leucemia</label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioLeucemia'>
																	<input name="txt_fecha_leucemia" type='text' id="txt_fecha_leucemia" class="form-control" value="<?php echo $fechaLeucemia;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="rabiaFelino" value="RabiaFelino" <?php if(isset($_POST['rabiaFelino'])) echo "checked='checked'"; ?> /> <label>Rabia </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioRabiaFelino'>
																	<input name="txt_fecha_rabia_felino" type='text' id="txt_fecha_rabia_felino" class="form-control" value="<?php echo $fechaRabiaFelino;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>

	  														<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="triple" value="Triple" <?php if(isset($_POST['triple'])) echo "checked='checked'"; ?> /> <label>Triple</label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioTriple'>
																	<input name="txt_fecha_triple" type='text' id="txt_fecha_triple" class="form-control" value="<?php echo $fechaTriple;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>
		  												</span>
													</div>
												</div>

												<div class="form-group">
												   <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
												   <textarea class="form-control" rows="3" id="txt_observacion" name="txt_observacion" onkeypress="return tabular(event,this)"><?php echo $observaciones; ?></textarea>
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

																<div class="form-group">
																	<div class="input-group">
																		<span class="input-group-addon"><i class="fa fa-ticket fa-fw"></i> Propietario</span>
																		<input name="txt_propietario" type="text" class="form-control" id="txt_propietario" value="<?php echo $propietarioPrincipal;?>" readonly />
																	</div>
																</div>

																<div class="form-group" hidden>
																	<div class="input-group">
																		<span class="input-group-addon"><i class="fa fa-ticket fa-fw"></i> DNI</span>
																		<input name="txt_documento_prop" type="text" class="form-control" id="txt_documento_prop" value="<?php echo $id_persona;?>" readonly />
																	</div>
																</div>

																<div class="form-group">
																	<div class="input-group">
																		<span class="input-group-addon"><i class="fa fa-user fa-fw"></i> Chipeado / Patentado por: *</span>
																		<div class="col-xs-15 selectContainer">
																			<select class="form-control" id="select_chipeadores" name="select_chipeadores" required>
																				<option  selected="selected"> <?php echo $nombre_chipeador;?> </option>
																				<?php
																					while ($row=mysql_fetch_array($chipeadores))
																					{
																						$id_chipeador = ($row['id_chipeador']);

																						$nombre_chipeador = ($row['nombre_chipeador']);

																						?>
																					<option value = "<?php echo $nombre_chipeador; ?>" ><?php echo $nombre_chipeador;?> </option>
																				<?php
																				}
																				?>
																			
																			</select>
																		</div>
																	</div>
																</div>

															</div>
														</div>

														<div class="col-md-6 col-md-offset">
															<div class="panel panel-default">
																<div class="panel-body">

																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon"><i class="fa fa-microchip fa-fw"></i> Nro. CHIP / Patente *</span>
																			<input name="txt_nro_chip" type="number" class="form-control" id="txt_nro_chip" value="<?php echo $nroChip;?>" onkeypress="return tabular(event,this)" required/>
																		</div>
																	</div>

																	<input name="guardar_ejemplar" type="submit" method="post" class="btn btn-sm btn-primary btn-block" value="GUARDAR" />
																</div>
															</div>
														</div>

													</div>
												</div>
											</div>
										</div><!-- cierra row -->


									</form>
								</div>
							</div>
						</div>
					</div>

				</form>	<!-- form principal -->
			</div><!-- Container -->
		</div><!-- Jumbotron -->
		<div class="panel-footer">
			<p class="text-center">Direccion de Sistemas - Municipalidad de Bariloche</p>
		</div>
	</div><!-- Container principal -->

	<script type="text/javascript">
	$('#divMiCalendario').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	$('#divMiCalendario1').datetimepicker({
      format: 'DD-MM-YYYY'
    });

    $('#divMiCalendario2').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	//Desparacitado
	 $('#divMiCalendarioDesparacitado').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	//Canino
	 $('#divMiCalendarioSextuple').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	 $('#divMiCalendarioQuintuple').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	 $('#divMiCalendarioRabia').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	 $('#divMiCalendarioHidatidosis').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	 $('#divMiCalendarioGusanos').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	 //Equinos
	 $('#divMiCalendarioAnemia').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioInfluenza').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioAdenitis').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioEncefalomielitis').datetimepicker({
      format: 'DD-MM-YYYY'
    });

	//Felinos
	$('#divMiCalendarioLeucemia').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioRabiaFelino').datetimepicker({
      format: 'DD-MM-YYYY'
    });
	 $('#divMiCalendarioTriple').datetimepicker({
      format: 'DD-MM-YYYY'
    });


    </script>
</body>
</html>
