<?php
error_reporting(0);

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

// CARGO LA PAGINA CON LO QUE VIENE DE LA BUSQUEDA

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	//Capturo chip
	$buscar_chip = $_POST['txt_buscar_chip'];

	if (!empty($buscar_chip))
	{
		$ejemplar = sql_buscar_ejemplar_chip($buscar_chip);

		$numeroRow = mysql_num_rows($ejemplar); // obtenemos el número de filas

		if ($ejemplar && $numeroRow > 0)
		{
			while ($row=mysql_fetch_array($ejemplar))
			{
				$id_ejemplar = $row['id_ejemplar'];
				
				$propMostrar = $row['DOCUMENTO']." ".$row['NOMBRE']." ".$row['APELLIDO'];
				$id_persona = $row['id_persona'];

				$nombreEjemplar = $row['nombre'];
				$anioNacimiento = $row['anio_nacimiento'];
				$alzada = $row['alzada'];
				
				if($row['libreta'] == 1)
				{
					$libreta = true;
				}

				$tamanio = $row['tamanio'];
				//$pTamanio = $tamanio;

				$sexo = $row['sexo'];
				//$pSexo = $sexo;

				$condicion = $row['condicion'];
				//$pCondicion = $condicion;

				$caracter = $row['caracter'];
				//$pCaracter = $caracter;

				$capturas = $row['capturas'];

				if($row['castrado'] == 0)
				{
					$castrado = "No";
				}elseif($row['castrado'] == 1)
				{
					$castrado = "Si";
				}

				//$pCastrado = $castrado;

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
						if($rowC['fecha_alta'] != '')
						{
							$fechaChip = fecha_normal_mysql($rowC['fecha_alta']);
						}

						$nroRecibo = $rowC['nro_recibo'];
						$plan = $rowC['plan'];
						//$pPlan = $plan;

					}
				}

				//Busco Especie
				$especie = sql_buscar_especies_por_id($row['fk_id_especie']);
				//$pEspecie = $especie;

				//Cargo combo razas, en base a la especie
				$razas = sql_buscar_razas($row['fk_id_especie']);

				//Busco Raza
				$raza = sql_buscar_raza_por_id($row['fk_id_raza']);
			//	$pRaza = $raza;

				//Busco Pelaje
				$pelaje = sql_buscar_pelaje_por_id($row['fk_id_pelaje']);
			//	$pPelaje = $pelaje;

				$persona_chip = sql_buscar_chipeador_ejemplar($id_ejemplar);

				if ($persona_chip)
				{
					while ($row=mysql_fetch_array($persona_chip))
					{
						$nombre_chipeador = $row['nombre_chipeador'];
					}
				}

			//	$pNombre_chipeador = $nombre_chipeador;

				//VACUNAS

				$vacunas = sql_traer_vacunas_ejemplar($row['id_ejemplar']);

				$numeroRowVacunas = mysql_num_rows($vacunas); // obtenemos el número de filas

				if ($vacunas && $numeroRowVacunas > 0)
				{
					while ($rowVac=mysql_fetch_array($vacunas))
					{
						if($rowVac['nombre_vacuna'] == "Sextuple")
						{
							$sextuple = $rowVac['nombre_vacuna'];
							$fechaSextuple = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Quintuple")
						{
							$quintuple = $rowVac['nombre_vacuna'];
							$fechaQuintuple = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Rabia")
						{
							$rabia = $rowVac['nombre_vacuna'];
							$fechaRabia = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Hidatidosis")
						{
							$hidatidosis = $rowVac['nombre_vacuna'];
							$fechaHidatidosis = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Gusanos Redondos")
						{
							$gusanos_redondos = $rowVac['nombre_vacuna'];
							$fechaGusanos = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Anemia Infecciosa")
						{
							$anemia = $rowVac['nombre_vacuna'];;
							$fechaAnemia = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Influenza Equina")
						{
							$influenza = $rowVac['nombre_vacuna'];;
							$fechaInfluenza = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Adenitis Equina")
						{
							$adenitis = $rowVac['nombre_vacuna'];;
							$fechaAdenitis = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Encefalomielitis")
						{
							$encefalomielitis = $rowVac['nombre_vacuna'];;
							$fechaEncefalomielitis = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Triple")
						{
							$triple = $rowVac['nombre_vacuna'];;
							$fechaTriple = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}

						if($rowVac['nombre_vacuna'] == "Leucemia")
						{
							$leucemia = $rowVac['nombre_vacuna'];;
							$fechaLeucemia = fecha_normal_mysql($rowVac['fecha_aplicacion']);
						}
					}
				}

			}
			$buscar_chip = "";
		}
	}else{
			$errorCarga = true;
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
	$nombreEjemplar = test_input($_POST['txt_nombre_animal']);

	$alzada = $_POST['txt_alzada'];

	$libreta = $_POST['libreta'];

	if($libreta == 'Libreta')
	{
		$libreta = true;
	}

	$fechaChip = $_POST['txt_fecha_chip'];

	$anioNacimiento =  test_input($_POST['txt_anio_animal']);

	$capturas = test_input($_POST['txt_capturas']);

	$fechaCastrado = test_input($_POST['txt_fecha_castrado']);

	$observaciones = test_input($_POST['txt_observacion']);

	$nroRecibo = test_input($_POST['txt_nro_recibo']);

	$propMostrar = test_input($_POST['txt_propMostrar']);

	$id_persona = test_input($_POST['txt_id_propietario']);

	$id_ejemplar = test_input($_POST['txt_id_ejemplar']);

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


	if (isset($_POST['sextuple']) && $_POST['sextuple'] == 'Sextuple')
	{
		if(isset($_POST['txt_fecha_sextuple']) && $_POST['txt_fecha_sextuple']!="")
		{
			if(!is_numeric($_POST['txt_fecha_sextuple']))
			{
				$sextuple='Sextuple';
				$fechaSextuple=test_input($_POST['txt_fecha_sextuple']);
			}else{
				$valSextupleNum=true;
			}
		}else{
			$valSextuple = true;
		}
	}

	if (isset($_POST['quintuple']) && $_POST['quintuple'] == 'Quintuple')
	{
		if(isset($_POST['txt_fecha_quintuple']) && $_POST['txt_fecha_quintuple']!="")
		{
			if(!is_numeric($_POST['txt_fecha_quintuple']))
			{
				$quintuple='Quintuple';
				$fechaQuintuple=test_input($_POST['txt_fecha_quintuple']);
			}else{
				$valQuintupleNum=true;
			}
		}else{
			$valQuintuple=true;
		}
	}


	if (isset($_POST['rabia']) && $_POST['rabia'] == 'Rabia')
	{
		if(isset($_POST['txt_fecha_rabia']) && $_POST['txt_fecha_rabia']!="")
		{
			if(!is_numeric($_POST['txt_fecha_rabia']))
			{
				$rabia='Rabia';
				$fechaRabia=test_input($_POST['txt_fecha_rabia']);
			}else{
				$valRabiaNum=true;
			}
		}else{
			$valRabia=true;
		}
	}

	if (isset($_POST['hidatidosis']) && $_POST['hidatidosis'] == 'Hidatidosis')
	{
		if(isset($_POST['txt_fecha_hidatidosis']) && $_POST['txt_fecha_hidatidosis']!="")
		{
			if(!is_numeric($_POST['txt_fecha_hidatidosis']))
			{
				$hidatidosis='Hidatidosis';
				$fechaHidatidosis=test_input($_POST['txt_fecha_hidatidosis']);
			}else{
				$valHidatidosisNum=true;
			}
		}else{
			$valHidatidosis=true;
		}
	}

	if (isset($_POST['gusanos_redondos']) && $_POST['gusanos_redondos'] == 'Gusanos_redondos')
	{
		if(isset($_POST['txt_fecha_gusanos']) && $_POST['txt_fecha_gusanos']!="")
		{
			if(!is_numeric($_POST['txt_fecha_gusanos']))
			{
				$gusanos_redondos='Gusanos Redondos';
				$fechaGusanos=test_input($_POST['txt_fecha_gusanos']);
			}else{
				$valGusanosNum=true;
			}
		}else{
			$valGusanos=true;
		}
	}


	if (isset($_POST['anemia']) && $_POST['anemia'] == 'Anemia')
	{
		if(isset($_POST['txt_fecha_anemia']) && $_POST['txt_fecha_anemia']!="")
		{
			if(!is_numeric($_POST['txt_fecha_anemia']))
			{
				$anemia='Anemia Infecciosa';
				$fechaAnemia=test_input($_POST['txt_fecha_anemia']);
			}else{
				$valAnemiaNum=true;
			}
		}else{
			$valAnemia=true;
		}
	}

	if (isset($_POST['influenza']) && $_POST['influenza'] == 'Influenza')
	{
		if(isset($_POST['txt_fecha_influenza']) && $_POST['txt_fecha_influenza']!="")
		{
			if(!is_numeric($_POST['txt_fecha_influenza']))
			{
				$influenza='Influenza Equina';
				$fechaInfluenza=test_input($_POST['txt_fecha_influenza']);
			}else{
				$valInfluenzaNum=true;
			}
		}else{
			$valInfluenza=true;
		}
	}

	if (isset($_POST['adenitis']) && $_POST['adenitis'] == 'Adenitis')
	{
		if(isset($_POST['txt_fecha_adenitis']) && $_POST['txt_fecha_adenitis']!="")
		{
			if(!is_numeric($_POST['txt_fecha_adenitis']))
			{
				$adenitis='Adenitis Equina';
				$fechaAdenitis=test_input($_POST['txt_fecha_adenitis']);
			}else{
				$valAdenitisNum=true;
			}
		}else{
			$valAdenitis=true;
		}
	}

	if (isset($_POST['encefalomielitis']) && $_POST['encefalomielitis'] == 'Encefalomielitis')
	{
		if(isset($_POST['txt_fecha_encefalomielitis']) && $_POST['txt_fecha_encefalomielitis']!="")
		{
			if(!is_numeric($_POST['txt_fecha_encefalomielitis']))
			{
				$encefalomielitis='Encefalomielitis';
				$fechaEncefalomielitis=test_input($_POST['txt_fecha_encefalomielitis']);
			}else{
				$valEncefalomielitisNum=true;
			}
		}else{
			$valEncefalomielitis=true;
		}
	}

	if (isset($_POST['triple']) && $_POST['triple'] == 'Triple')
	{
		if(isset($_POST['txt_fecha_triple']) && $_POST['txt_fecha_triple']!="")
		{
			if(!is_numeric($_POST['txt_fecha_triple']))
			{
				$triple='Triple';
				$fechaTriple=test_input($_POST['txt_fecha_triple']);
			}else{
				$valTripleNum=true;
			}
		}else{
			$valTriple=true;
		}
	}


	if (isset($_POST['leucemia']) && $_POST['leucemia'] == 'Leucemia')
	{
		if(isset($_POST['txt_fecha_leucemia']) && $_POST['txt_fecha_leucemia']!="")
		{
			if(!is_numeric($_POST['txt_fecha_leucemia']))
			{
				$leucemia='Leucemia';
				$fechaLeucemia=test_input($_POST['txt_fecha_leucemia']);
			}else{
				$valLeucemiaNum=true;
			}
		}else{
			$valLeucemia=true;
		}
	}

	$file_name= $_FILES['foto_ejemplar']['name'];
	$file= $_FILES['foto_ejemplar']['tmp_name'];

	if($castrado == 'Si' && $fechaCastrado == "")
	{
		$valFechaCastrado = true;
	}elseif($valSextuple == true || $valQuintuple == true || $valHidatidosis == true || $valRabia == true || $valGusanos == true
		|| $valAnemia == true || $valLeucemia == true || $valEncefalomielitis == true || $valTriple == true || $valRabiaFelino
		|| $valInfluenza == true || $valAdenitis == true)
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}elseif($valSextupleNum == true || $valQuintupleNum == true || $valHidatidosisNum == true || $valRabiaNum == true || $valGusanosNum == true
		|| $valAnemiaNum == true || $valLeucemiaNum == true || $valEncefalomielitisNum == true || $valTripleNum == true || $valRabiaFelinoNum
		|| $valInfluenzaNum == true || $valAdenitisNum == true)
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}else{
		$validadoAnimal=true;
	}

	if($validadoAnimal == true)
	{


	}

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

	//Funcion COMBOBOX Autocomplete

	  $( function() {
	    $.widget( "custom.combobox", {
	      _create: function() {
	        this.wrapper = $( "<span>" )
	          .addClass( "custom-combobox" )
	          .insertAfter( this.element );

	        this.element.hide();
	        this._createAutocomplete();
	        this._createShowAllButton();
	      },

	      _createAutocomplete: function() {
	        var selected = this.element.children( ":selected" ),
	          value = selected.val() ? selected.text() : "";

	        this.input = $( "<input>" )
	          .appendTo( this.wrapper )
	          .val( value )
	          .attr( "title", "" )
	          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
	          .autocomplete({
	            delay: 0,
	            minLength: 0,
	            source: $.proxy( this, "_source" )
	          })
	          .tooltip({
	            classes: {
	              "ui-tooltip": "ui-state-highlight"
	            }
	          });

	        this._on( this.input, {
	          autocompleteselect: function( event, ui ) {
	            ui.item.option.selected = true;
	            this._trigger( "select", event, {
	              item: ui.item.option
	            });
	          },

	          autocompletechange: "_removeIfInvalid"
	        });
	      },

	      _createShowAllButton: function() {
	        var input = this.input,
	          wasOpen = false;

	        $( "<a>" )
	          .attr( "tabIndex", -1 )
	          .attr( "title", "Show All Items" )
	          .tooltip()
	          .appendTo( this.wrapper )
	          .button({
	            icons: {
	              primary: "ui-icon-triangle-1-s"
	            },
	            text: false
	          })
	          .removeClass( "ui-corner-all" )
	          .addClass( "custom-combobox-toggle ui-corner-right" )
	          .on( "mousedown", function() {
	            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
	          })
	          .on( "click", function() {
	            input.trigger( "focus" );

	            // Close if already visible
	            if ( wasOpen ) {
	              return;
	            }

	            // Pass empty string as value to search for, displaying all results
	            input.autocomplete( "search", "" );
	          });
	      },

	      _source: function( request, response ) {
	        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
	        response( this.element.children( "option" ).map(function() {
	          var text = $( this ).text();
	          if ( this.value && ( !request.term || matcher.test(text) ) )
	            return {
	              label: text,
	              value: text,
	              option: this
	            };
	        }) );
	      },

	      _removeIfInvalid: function( event, ui ) {

	        // Selected an item, nothing to do
	        if ( ui.item ) {
	          return;
	        }

	        // Search for a match (case-insensitive)
	        var value = this.input.val(),
	          valueLowerCase = value.toLowerCase(),
	          valid = false;
	        this.element.children( "option" ).each(function() {
	          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
	            this.selected = valid = true;
	            return false;
	          }
	        });

	        // Found a match, nothing to do
	        if ( valid ) {
	          return;
	        }

	        // Remove invalid value
	        this.input
	          .val( "" )
	          .attr( "title", value + " didn't match any item" )
	          .tooltip( "open" );
	        this.element.val( "" );
	        this._delay(function() {
	          this.input.tooltip( "close" ).attr( "title", "" );
	        }, 2500 );
	        this.input.autocomplete( "instance" ).term = "";
	      },

	      _destroy: function() {
	        this.wrapper.remove();
	        this.element.show();
	      }
	    });

	    $( "#combobox" ).combobox();
	    $( "#toggle" ).on( "click", function() {
	      $( "#combobox" ).toggle();
	    });
	  } );

		/*$( function() {
			// Variable que recoge el resultado de la consulta sobre la tabla Provincias, Jquery trabajará sobre este resultado para dinamizar el funcionamiento.
			var availableTags = [<?php //echo $texto ?>];
			$("#buscar_propietario").autocomplete({
				source: availableTags
			});

	});*/
	//////////////////////////////////////////////////////////////

	function set_focus()
	{
		document.getElementById("txt_nombre_animal").focus();
		alert("focus animal nombre");
		return (false);
	}

	</script>
</style>
</head>


<body onLoad="document.frm_mod_animal.txt_nombre_animal.focus();">

	<div class="container">
		<br>
			<?php include("../inc/menu.php"); ?>

	  <!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron">
			<h4 class="text-center bg-info"><i class="fa fa-pencil-square-o fa-fw"></i> Modificar Animal</h4>
			<div class="container">
				<form  enctype="multipart/form-data" id="frm_mod_ejemplar" name="frm_mod_ejemplar" method="post" onsubmit="" action="<?php $_SERVER["PHP_SELF"];?>" >

						<?php
							if($valAnioNacNum == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>El AÑO de nacimiento debe ser un numero.</div>
								";
								$valAnioNacNum = false;
							}elseif($pEspecie == "Canina" && ($valSextuple == true || $valQuintuple == true || $valHidatidosis == true || $valRabia == true || $valGusanos == true)){
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
							}elseif($pEspecie == "Canina" && ($valSextupleNum == true || $valQuintupleNum == true || $valHidatidosisNum == true || $valRabiaNum == true || $valGusanosNum == true)){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Lla FECHA de aplicacion de las VACUNAS debe ser seleccionada con el calendario.</div>
								";
								$valSextupleNum = false;
								$valQuintupleNum = false;
								$valHidatidosisNum = false;
								$valRabiaNum = false;
								$valGusanosNum = false;

							}elseif($pEspecie == "Felina" && ($valLeucemia == true || $valRabiaFelino == true || $valTriple == true)){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Debe completar la FECHA de aplicacion en las vacunas seleccionadas.</div>
								";
								$valLeucemia = false;
								$valRabiaFelino = false;
								$valTriple = false;

							}elseif($pEspecie == "Felina" && ($valLeucemia == true || $valRabiaFelino == true || $valTriple == true)){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Lla FECHA de aplicacion de las VACUNAS debe ser seleccionada con el calendario.</div>
								";
								$valLeucemia = false;
								$valRabiaFelino = false;
								$valTriple = false;

							}elseif($pEspecie == "Equina" && ($valAnemia == true || $valInfluenza == true || $valAdenitis == true || $valEncefalomielitis == true)){
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

							}elseif($pEspecie == "Equina" && ($valAnemia == true || $valInfluenza == true || $valAdenitis == true || $valEncefalomielitis == true)){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Lla FECHA de aplicacion de las VACUNAS debe ser seleccionada con el calendario.</div>
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
									×</button>El Animal se modificó correctamente.</div>
								";
								$successAnimal = false;
							}elseif($errorEjemplar == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Error al modificar el Animal.</div>
								";
								$errorEjemplar = false;
							}
							elseif($errorCarga == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Error al cargar los datos del animal.</div>
								";
								$errorCarga = false;
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
												<span class="input-group-addon"><i class="fa fa-keyboard-o fa-fw"></i> Nombre</span>
												<input name="txt_nombre_animal" type="text" class="form-control" id="txt_nombre_animal" value="<?php echo $nombreEjemplar;?>"  />
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha Chipeado* </span>
												<div class='input-group date' id='divMiCalendario'>
													<input name="txt_fecha_chip" type='text' id="txt_fecha_chip" class="form-control" value="<?php echo $fechaChip;?>" required/>
													<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Plan Institución*</span>
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
												<span class="input-group-addon"><i class="fa fa-calendar-check-o fa-fw"></i> Año Nacimiento</span>
												<input name="txt_anio_animal" type="number" class="form-control" id="txt_anio_animal" value="<?php echo $anioNacimiento;?>"  required/>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-bug fa-fw"></i> Especie*</span>
												<div class="col-xs-15 selectContainer">
													<select class="form-control" id="select_especie" name="select_especie" onChange="form.submit()" required>
													
															<option  selected="selected"> <?php echo $especie;?> </option>
														<?php
															while ($row=mysql_fetch_array($especies))
															{
																$id_especie = ($row['id_especie']);

																$especie = ($row['especie']);

																?>
															<option value = "<?php echo $especie; ?>"><?php echo $especie;?> </option>
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
													<select class="form-control" id="select_raza" name="select_raza" onChange="21" required>
														<?php
															while ($row=mysql_fetch_array($razas))
															{
																$id_raza = ($row['id_raza']);
																$raza = ($row['raza']);

															?>
														<option value = "<?php echo $raza;?>" selected="selected"><?php echo $raza;?> </option>
														<?php
															}
														?>
														<option  selected="selected"><?php echo $pRaza;?></option>
													</select>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Pelaje </span>
												<div class="col-xs-15 selectContainer">
													<select class="form-control" name="select_pelaje" required>
														<?php
															while ($row=mysql_fetch_array($pelajes))
															{
																$id_pelaje = ($row['id_pelaje']);
																$pelaje = ($row['pelaje']);

															?>
														<option value = "<?php echo $pelaje;?>" selected="selected"><?php echo  utf8_encode($pelaje);?> </option>
														<?php
															}
														?>
														<option  selected="selected"><?php echo $pPelaje;?></option>

													</select>
												</div>
											</div>
										</div>

										<?php
											if($pEspecie == "Equina")
											{ ?>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-arrows-v fa-fw"></i> Alzada</span>
														<input name="txt_alzada" type="text" class="form-control" id="txt_alzada" value="<?php echo $alzada;?>"  required/>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Libreta Sanitaria <input type="checkbox" name="libreta" value="Libreta" <?php if(isset($_POST['libreta']) or $libreta =='Libreta') echo "checked='checked'"; ?>/> </span>
													</div>
												</div>

											<?php }else
											{?>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Tamaño*</span>
														<div class="col-xs-15 selectContainer">
															<select  class="form-control" name="select_tamanio" required>
																<option value="Extra Grande">Extra Grande</option>
																<option value="Grande">Grande</option>
																<option value="Mediano">Mediano</option>
																<option value="Chico">Chico</option>
																<option  selected="selected"><?php echo $pTamanio;?></option>
															</select>
														</div>
													</div>
												</div>
											<?php }
											?>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-venus-mars fa-fw"></i> Sexo*</span>
												<div class="col-xs-15 selectContainer">
													<select  class="form-control" name="select_sexo" required>
														<option value="Macho">Macho</option>
														<option value="Hembra">Hembra</option>
														<option  selected="selected"><?php echo $pSexo;?></option>
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
														<option  selected="selected"><?php echo $pCondicion;?></option>
													</select>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Carácter</span>
												<div class="col-xs-15 selectContainer">
													<select class="form-control" name="select_caracter">
														<option value="Sociable">Sociable</option>
														<option value="Peligroso">Peligroso</option>
														<option  selected="selected"><?php echo $pCaracter;?></option>
													</select>
												</div>
											</div>
										</div>



									</div>
								</div>

								<div class="col-md-6 col-md-offset">
									<div class="panel panel-default">

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-flag-o fa-fw"></i> Capturas</span>
												<input name="txt_capturas" type="number" min="0" class="form-control" id="txt_capturas" value="<?php echo $capturas;?>" onKeyPress="return tabular(event,this)" placeholder="Cantidad" required/>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">

												<span class="input-group-addon"><i class="fa fa-medkit fw" aria-hidden="true"></i> Vacunas y Desparacitado

												<?php

												switch ($pEspecie) {

													case "Canina":
													?>
													<div class="form-group">
														<div class="col-xs-5 col-md-offset-0">
														<br><br>
															<input type="checkbox" name="sextuple" value="Sextuple" <?php if(isset($_POST['sextuple']) or $sextuple=='Sextuple') echo "checked='checked'"; ?> /> <label>Sextuple</label>
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
  															<input type="checkbox" name="quintuple" value="Quintuple" <?php if(isset($_POST['quintuple']) or $quintuple=='Quintuple') echo "checked='checked'"; ?> /> <label>Quintuple</label>
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
  															<input type="checkbox" name="rabia" value="Rabia" <?php if(isset($_POST['rabia']) or $rabia=='Rabia') echo "checked='checked'"; ?> /> <label>Rabia </label>
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
  															<input type="checkbox" name="hidatidosis" value="Hidatidosis" <?php if(isset($_POST['hidatidosis']) or $hidatidosis=='Hidatidosis') echo "checked='checked'"; ?> /> <label>Hidatidosis</label>
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
  															<input type="checkbox" name="gusanos_redondos" value="Gusanos_redondos"  <?php if(isset($_POST['gusanos_redondos']) or $gusanos_redondos=='Gusanos Redondos') echo "checked='checked'"; ?> /> <label>Gusanos Redondos</label>
  														</div>
  														<br>
  														<div class="input-group">
															<span class="input-group-addon">Fecha* </span>
															<div class='input-group date' id='divMiCalendarioGusanos'>
																<input name="txt_fecha_gusanos" type='text' id="txt_fecha_gusanos" class="form-control" value="<?php echo $fechaGusanos;?>"/>
																<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
															</div>
														</div>

  													</div>

  													<?php break;

													case "Equina":
													?>
														<div class="form-group">
															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="anemia" value="Anemia" <?php if(isset($_POST['anemia']) or $anemia=='Anemia Infecciosa') echo "checked='checked'"; ?> /> <label>Anemia Infecciosa </label>
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
	  															<input type="checkbox" name="influenza" value="Influenza" <?php if(isset($_POST['influenza']) or $influenza=='Influenza Equina') echo "checked='checked'"; ?>/> <label>Influenza Equina </label>
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
	  															<input type="checkbox" name="adenitis" value="Adenitis" <?php if(isset($_POST['adenitis']) or $adenitis=='Adenitis Equina') echo "checked='checked'"; ?> /> <label>Adenitis Equina </label>
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
	  															<input type="checkbox" name="encefalomielitis" value="Encefalomielitis" <?php if(isset($_POST['encefalomielitis']) or $encefalomielitis=='Encefalomielitis') echo "checked='checked'"; ?> /> <label>Encefalomielitis </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioEncefalomielitis'>
																	<input name="txt_fecha_encefalomielitis" type='text' id="txt_fecha_encefalomielitis" class="form-control" value="<?php echo $fechaEncefalomielitis;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>
														</div>
													<?php break;

													case "Felina":?>

														<div class="form-group">
															<div class="col-xs-5 col-md-offset-0">
																<br><br>
	  															<input type="checkbox" name="leucemia" value="Leucemia" <?php if(isset($_POST['leucemia']) or $leucemia=='Leucemia') echo "checked='checked'"; ?> /> <label>Leucemia </label>
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
	  															<input type="checkbox" name="rabiaFelino" value="RabiaFelino" <?php if(isset($_POST['rabiaFelino']) or $rabiaFelino=='Rabia') echo "checked='checked'"; ?>/> <label>Rabia </label>
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
	  															<input type="checkbox" name="triple" value="Triple" <?php if(isset($_POST['triple']) or $triple=='Triple') echo "checked='checked'"; ?>/> <label>Triple </label>
	  														</div>
	  														<br>
	  														<div class="input-group">
																<span class="input-group-addon">Fecha* </span>
																<div class='input-group date' id='divMiCalendarioTriple'>
																	<input name="txt_fecha_triple" type='text' id="txt_fecha_triple" class="form-control" value="<?php echo $fechaTriple;?>"/>
																	<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
																</div>
															</div>
														</div>

													<?php break;
													} ?>

												</span>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-user-md fa-fw"></i> Castrado <br><br>
												<div class="col-xs-4 col-md-offset-0">
													<div class="form-group">
														<select class="form-control" name="select_castrado" required>
															<option value="No">No</option>
													  		<option value="Si">Si</option>
														 	<option  selected="selected"><?php echo $pCastrado;?></option>
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
										   <span class="input-group-addon"><i class="fa fa-commenting-o fw" aria-hidden="true"></i> Observaciones</span>
										   <textarea class="form-control" rows="3" id="txt_observacion" name="txt_observacion"  ><?php echo $observaciones; ?></textarea>
										</div>

										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-ticket fa-fw"></i> Nro. Recibo*</span>
												<input name="txt_nro_recibo" type="text" class="form-control" id="txt_nro_recibo" value="<?php echo $nroRecibo;?>"  required />
											</div>
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
																<input name="txt_propMostrar" type="text" class="form-control" id="" value="<?php echo $propMostrar;?>" onkeypress="return tabular(event,this)" readonly/>
															</div>
														</div>


														<div class="form-group" >
															<div class="input-group">
																<input name="txt_id_propietario" type="text" class="form-control" id="txt_id_propietario" value="<?php echo $id_persona;?>" onkeypress="return tabular(event,this)"/>
															</div>
														</div>

														<div class="panel-body">
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-user fa-fw"></i> Chipeado / Patentado por: </span>
																	<div class="col-xs-15 selectContainer">
																		<select class="form-control" id="select_chipeadores" name="select_chipeadores" required>
																			<?php
																				while ($row=mysql_fetch_array($chipeadores))
																				{
																					$id_chipeador = ($row['id_chipeador']);

																					$nombre_chipeador = ($row['nombre_chipeador']);

																					?>
																				<option value = "<?php echo $nombre_chipeador; ?>" selected="selected"><?php echo $nombre_chipeador;?> </option>
																			<?php
																			}
																			?>
																			<option  selected="selected"> <?php echo $pNombre_chipeador;?> </option>
																		</select>
																	</div>

																</div>
															</div>
														</div>


													</div>
												</div>


												<div class="col-md-6 col-md-offset">
												<span class="input-group-addon">Imágenes Animal</span>
													<div class="panel panel-default">
														<div class="panel-body">
                                                                <table>
                                                                  <thead>
																	<th>Nombre</th>
                                                                    <th>Imagen</th>
                                                                    <th>Eliminar&nbsp;</th>
                                                                  </thead>
                                                                  <?php
																	$link=conectarse_mysql_veterinaria();
																 	$sql_images="select id,archivo from ejemplares_fotos where id_ejemplar=$id_ejemplar";
															   		$result_images=mysql_query($sql_images,$link);

															  		$cont=0;

																	while($row=mysql_fetch_array($result_images)){
																  ?>
                                                                  <tr>
                                                                    <td width="200" align="left" valign="middle" ><?php echo $row['archivo']; ?></td>
                                                                    <td class="<?php echo $clase;?>"><img  border="0" class='mano' src='imagenes_ejemplares/<?php echo $row["archivo"];?>' width="200" /></td>
                                                                    <td><a href="foto_delete.php?id_file=<?php echo $row['id']; ?>&txt_buscar_chip=<?php echo $_GET['txt_buscar_chip'];?>"><img src='../images/eliminar.gif' alt="" border="0" class='' hspace="25"/></a></td>
                                                                  </tr>
                                                                  <?php
																   }
																  ?>
                                                                </table>


													  </div>

															<div class="form-group">
															<h5 class="text-center bg-info"><i class="fa fa-exclamation-circle fw" aria-hidden="true"></i> Luego de seleccionar la imagen, haga clic en "Guardar Cambios"</h5>
																<div class="input-group">
																	<div class='input-group'>
																		<span class="btn btn-default btn-file"><i class="fa fa-paperclip fa-fw"></i><input name="foto_ejemplar" type="file" hidden>Seleccione una imagen...</span>
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
																	<span class="input-group-addon"><i class="fa fa-microchip fa-fw"></i> Nro. CHIP*</span>
																	<input name="txt_nro_chip" type="text" class="form-control" id="txt_nro_chip" value="<?php echo $nroChip;?>"  readonly  />
																	<input name="txt_id_ejemplar" type="text" class="form-control" id="txt_id_ejemplar" value="<?php echo $id_ejemplar;?>" />
																</div>
															</div>

															<input name="guardar_ejemplar" type="submit" method="post"  class="btn btn-sm btn-primary btn-block btn-danger" value="GUARDAR CAMBIOS" />
														</div>
													</div>
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
