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

$stmtP = sql_buscar_personas();

//Si hay resultados...
if (mysql_num_rows($stmtP) > 0){

while($fila = mysql_fetch_assoc($stmtP)){
		 // se recoge la información según la vamos a pasar a la variable de javascript
				 $texto .= '"'.$fila['documento'].' '.$fila['nombre'].' '.$fila['apellido'].'",';
	}

}else{
		$texto = "NO HAY RESULTADOS EN LA BBDD";
}

//Inicializo variables
$valNombre=false;
$valFechaChip=false;
$valPlan=false;
$valAnioNac=false;
$valAnioNacNum=false;
$valEspecie=false;
$valSexo=false;
$valCondicion=false;
$valCapturas=false;
$valCapturasNum=false;
$valCastrado=false;
$valFechaCastrado=false;
$valnroRecibo=false;
$valnroReciboNum=false;
$valNroChip=false;
$valNroChipNum=false;
$valSextuple=false;
$valQuintuple=false;
$valRabia=false;
$valHidatidosis=false;
$valGusanos=false;
$valSextupleNum =false;
$valQuintupleNum=false;
$valHidatidosisNum=false;
$valRabiaNum=false;
$valGusanosNum =false;
$valPropietario=false;
$validadoAnimal = false;
$valChipeado = false;
$successAnimal = false;
$errorEjemplar = false;
$errorChip = false;



$id_ejemplar = "";
$nombreEjemplar = "";
$fechaChip = "";
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
$nroChip = "";
$propietarioPrincipal="";
$chipeador = "";

//Cargo especies
$especies = sql_buscar_especies();

//Cargo pelajes
$pelajes= sql_traer_pelajes();

//Cargo propietarios
$propietarios = sql_traer_propietarios();


//Capturo variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$nombreEjemplar = test_input($_POST['txt_nombre_animal']);

	$fechaChip = test_input($_POST['txt_fecha_chip']);

	$anioNacimiento =  test_input($_POST['txt_anio_animal']);

	$capturas = test_input($_POST['txt_capturas']);

	$fechaCastrado = test_input($_POST['txt_fecha_castrado']);

	$observaciones = test_input($_POST['txt_observacion']);

	$nroRecibo = test_input($_POST['txt_nro_recibo']);

	$nroChip = test_input($_POST['txt_nro_chip']);


	//COMBOS

	//capturo especie seleccionada y parametros cargados
	$valor = explode('.',$_POST['select_especie']);
	$especie = $valor[0];

	$valor = explode('.',$_POST['select_raza']);
	$raza = $valor[0];

	$valor = explode('.',$_POST['select_pelaje']);
	$pelaje = $valor[0];

	$valor = explode('.',$_POST['select_tamanio']);
	$tamanio = $valor[0];

	$valor = explode('.',$_POST['txt_alzada']);
	$alzada = $valor[0];

	$valor = explode('.',$_POST['select_sexo']);
	$sexo = $valor[0];

	$valor = explode('.',$_POST['select_condicion']);
	$condicion = $valor[0];

	$valor = explode('.',$_POST['select_caracter']);
	$caracter = $valor[0];

	$valor = explode('.',$_POST['select_castrado']);
	$castrado = $valor[0];

	$valor = explode('.',$_POST['select_plan']);
	$plan = $valor[0];

	$valor = explode('.',$_POST['select_propietarios']);
	$propietarioPrincipal = $valor[0];

	$chipeador = test_input($_POST['buscar_propietario']);

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

	if($nombreEjemplar == "")
	{
		$valNombre=true;
	}elseif($fechaChip =="")
	{
		$valFechaChip=true;
	}elseif($plan=="" || $plan=="Seleccione un plan de chipeado")
	{
		$valPlan=true;
	}elseif($anioNacimiento=="")
	{
		$valAnioNac=true;
	}elseif(!is_numeric($anioNacimiento))
	{
		$valAnioNacNum = true;
	}elseif($especie=="" || $especie=="Seleccione una especie")
	{
		$valEspecie = true;
	}elseif($sexo=="" || $sexo=="Seleccione un sexo")
	{
		$valSexo = true;
	}elseif($condicion=="" || $condicion=="Seleccione una condición")
	{
		$valCondicion = true;
	}elseif($capturas=="")
	{
		$valCapturas = true;
	}elseif(!is_numeric($capturas))
	{
		$valCapturasNum = true;
	}elseif($castrado=="" || $castrado=="¿Castrado?")
	{
		$valCastrado = true;
	}elseif($castrado== 'Si' && $fechaCastrado=="")
	{
		$valFechaCastrado = true;
	}elseif($valSextuple == true || $valQuintuple == true || $valHidatidosis == true || $valRabia == true || $valGusanos == true)
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}elseif($valSextupleNum == true || $valQuintupleNum == true || $valHidatidosisNum == true || $valRabiaNum == true || $valGusanosNum == true)
	{
		//entra aca, más abajo pone el cartel segun que vacuna está mal completada.
	}elseif($nroRecibo=="")
	{
		$valnroRecibo = true;
	}elseif(!is_numeric($nroRecibo))
	{
		$valnroReciboNum = true;
	}elseif($propietarioPrincipal == "" || $propietarioPrincipal == "Busque un propietario")
	{
		$valPropietario = true;
	}elseif($chipeador == "")
	{
		$valChipeado = true;
	}elseif($nroChip=="")
	{
		$valNroChip = true;
	}elseif(!is_numeric($nroChip))
	{
		$valNroChipNum = true;
	}else{
		$validadoAnimal=true;
	}

}
//COMBOS

//capturo especie seleccionada y parametros cargados
$valor = explode('.',$_POST['select_especie']);
$pEspecie = $valor[0];

$valor = explode('.',$_POST['select_raza']);
$pRaza = $valor[0];

$valor = explode('.',$_POST['select_pelaje']);
$pPelaje = $valor[0];

$valor = explode('.',$_POST['select_tamanio']);
$pTamanio = $valor[0];

$valor = explode('.',$_POST['select_sexo']);
$pSexo = $valor[0];

$valor = explode('.',$_POST['select_condicion']);
$pCondicion = $valor[0];

$valor = explode('.',$_POST['select_caracter']);
$pCaracter = $valor[0];

$valor = explode('.',$_POST['select_castrado']);
$pCastrado = $valor[0];

$valor = explode('.',$_POST['select_plan']);
$pPlan = $valor[0];

$valor = explode('.',$_POST['select_propietarios']);
$propietarioPrincipal = $valor[0];

$chipeador = test_input($_POST['buscar_propietario']);

$campos_chip = explode(" ", $chipeador);

//Especie
if ( $pEspecie) {
	$especie = $pEspecie;
}
else {
	$pEspecie = "Seleccione una especie...";
}

//busco id especie
$pId_especie = sql_buscar_id_especie($pEspecie);

//Cargo combo razas, en base a la especie
$razas = sql_buscar_razas($pId_especie);


if ($pRaza) {
	$raza = $pRaza;
}
else {
	$pRaza = "Seleccione una raza...";
}

//Pelaje
if ( $pPelaje) {
	$pelaje = $pPelaje;
}
else {
	$pPelaje = "Seleccione un pelaje...";
}

//Tamaño
if ( $pTamanio) {
	$tamanio = $pTamanio;
}
else {
	$pTamanio = "Seleccione un tamaño...";
}

//Sexo
if ( $pSexo) {
	$sexo = $pSexo;
}
else {
	$pSexo = "Seleccione un sexo...";
}

//Condicion
if ( $pCondicion) {
	$condicion = $pCondicion;
}
else {
	$pCondicion = "Seleccione una condición...";
}

//Caracter
if ( $pCaracter) {
	$caracter = $pCaracter;
}
else {
	$pCaracter = "Seleccione un carácter...";
}

//Castrado
if ( $pCastrado) {
	$castrado = $pCastrado;
}
else {
	$pCastrado = "¿Castrado?";
}

//Planes
if ( $pPlan) {
	$plan = $pPlan;
}
else {
	$pPlan = "Seleccione un plan de chipeado...";
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//#########################################PERSISTIR DATOS####################################################


$successAnimal = false;

if($validadoAnimal == true)
{
	if (!sql_buscar_animal_duplicado($nroChip))
	{
		$fk_id_ejemplar = sql_insert_ejemplar($nombreEjemplar,$anioNacimiento,$especie,$raza,$pelaje,$tamanio,$alzada,$sexo,$condicion,$caracter,$capturas,$castrado,$fechaCastrado,$observaciones,$nroChip, $fechaChip, $plan, $nroRecibo, $sextuple, $fechaSextuple, $quintuple, $fechaQuintuple, $rabia, $fechaRabia, $hidatidosis, $fechaHidatidosis, $gusanos_redondos, $fechaGusanos, $propietarioPrincipal, $campos_chip[0]);

		if (!$fk_id_ejemplar)
		{
			$errorEjemplar = true;
		}
		else{

			$successAnimal = true;
		}
	}else
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

	    $( function() {
			// Variable que recoge el resultado de la consulta sobre la tabla Provincias, Jquery trabajará sobre este resultado para dinamizar el funcionamiento.
			var availableTags = [<?php echo $texto ?>];
			$("#buscar_propietario").autocomplete({
				source: availableTags
			});

	  } );

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
								if($valNombre == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>El NOMBRE no puede estar vacio.</div>
									";
									$valNombre = false;
								}elseif($valFechaChip == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>La FECHA de chipeado no puede estar vacia.</div>
									";
									$valFechaChip = false;
								}elseif($valPlan == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe seleccionar un Plan.</div>
									";
									$valPlan = false;
								}elseif($valAnioNac == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>El AÑO de nacimiento no puede estar vacio.</div>
									";
									$valAnioNac = false;
								}elseif($valAnioNacNum == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>El AÑO de nacimiento debe ser un numero.</div>
									";
									$valAnioNacNum = false;
								}elseif($valEspecie == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe seleccionar una especie.</div>
									";
									$valEspecie = false;
								}elseif($valSexo == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe seleccionar un sexo.</div>
									";
									$valSexo = false;
								}elseif($valCondicion == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe seleccionar una condicion.</div>
									";
									$valCondicion = false;
								}elseif($valCapturas == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar cantidad de capturas.</div>
									";
									$valCapturas = false;
								}elseif($valCapturasNum == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Las capturas debe ser un numero.</div>
									";
									$valCapturasNum = false;
								}elseif($valSextuple == true || $valQuintuple == true || $valHidatidosis == true || $valRabia == true || $valGusanos == true){
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
								}elseif($valSextupleNum == true || $valQuintupleNum == true || $valHidatidosisNum == true || $valRabiaNum == true || $valGusanosNum == true){
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
								}elseif($valCastrado == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar si fue castrado.</div>
									";
									$valCastrado = false;
								}elseif($valFechaCastrado == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar la fecha de castracion.</div>
									";
									$valFechaCastrado = false;
								}elseif($valnroRecibo == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar el numero de recibo.</div>
									";
									$valnroRecibo = false;
								}elseif($valnroReciboNum == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>El recibo debe ser un numero.</div>
									";
									$valnroReciboNum = false;
								}elseif($valNroChip == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar el numero de chip.</div>
									";
									$valNroChip = false;
								}elseif($valPropietario == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar un PROPIETARIO.</div>
									";
									$valPropietario = false;
								}elseif($valChipeado == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>Debe indicar quién aplicó el chip.</div>
									";
									$valChipeado = false;
								}elseif($valNroChipNum == true){
									echo "
										<div class='alert alert-danger-alt alert-dismissable'>
										<span class='glyphicon glyphicon-exclamation-sign'></span>
										<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
										×</button>El chip debe ser un numero.</div>
									";
									$valNroChipNum = false;
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
														<span class="input-group-addon"><i class="fa fa-calendar-o fa-fw"></i> Fecha Chipeado* </span>
														<div class='input-group date' id='divMiCalendario'>
															<input name="txt_fecha_chip" type='text' id="txt_fecha_chip" class="form-control" value="<?php echo $fechaChip;?>"/>
															<span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i></span>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-question-circle-o fa-fw"></i> Plan Institución*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" name="select_plan">
															  <option value="Barrial">Barrial</option>
															  <option value="Municipal">Municipal</option>
															  <option value="Campaña 2017">Campaña 2017</option>
															  <option value="Veterinaria">Veterinaria</option>
															  <option  selected="selected"><?php echo $pPlan;?></option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-calendar-check-o fa-fw"></i> Año Nacimiento*</span>
														<input name="txt_anio_animal" type="text" class="form-control" id="txt_anio_animal" value="<?php echo $anioNacimiento;?>" onkeypress="return tabular(event,this)"/>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-bug fa-fw"></i> Especie*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" id="select_especie" name="select_especie" onchange="form.submit()">
																<?php
																	while ($row=mysql_fetch_array($especies))
																	{
																		$id_especie = ($row['id_especie']);

																		$especie = ($row['especie']);

																		?>
																	<option value = "<?php echo $especie; ?>" selected="selected"><?php echo $especie;?> </option>
																<?php
																}
																?>
																<option  selected="selected"> <?php echo $pEspecie;?> </option>
															</select>
														</div>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Raza*</span>
														<div class="col-xs-15 selectContainer">
															<select class="form-control" id="select_raza" name="select_raza" onchange="21" >
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
															<select class="form-control" name="select_pelaje">
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
																<input name="txt_alzada" type="text" class="form-control" id="txt_alzada" value="<?php echo $alzada;?>" onkeypress="return tabular(event,this)"/>
															</div>
														</div>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon"><i class="fa fa-book fa-fw"></i> Libreta Sanitaria <input type="checkbox" name="libreta" value="Libreta"/> </span>

															</div>
														</div>

													<?php }else
													{?>
														<div class="form-group">
															<div class="input-group">
																<span class="input-group-addon"><i class="fa fa-info-circle fa-fw"></i> Tamaño*</span>
																<div class="col-xs-15 selectContainer">
																	<select  class="form-control" name="select_tamanio">
																		<option value="Seleccione un caracter...">Seleccione un tamaño...</option>
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
															<select  class="form-control" name="select_sexo">
																<option value="Seleccione un sexo...">Seleccione un sexo...</option>
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
															<select class="form-control" name="select_condicion">
																<option value="Seleccione una condición...">Seleccione una condición...</option>
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
																<option value="Seleccione un caracter..">Seleccione un carácter...</option>
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
														<input name="txt_capturas" type="number" min="0" class="form-control" id="txt_capturas" value="<?php echo $capturas;?>" onkeypress="return tabular(event,this)" placeholder="Cantidad"/>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">

														<span class="input-group-addon"><i class="fa fa-medkit fw" aria-hidden="true"></i> Vacunas y Desparacitado

														<?php
															switch ($pEspecie) {
   																 case "Equina":?>
																<div class="form-group">
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
																</div>


														<?php  break;

														case "Canina":?>

															<div class="form-group">

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

		  													</div>

															<?php break;
															case "Felina":?>
																<div class="form-group">

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
		  													</div>

															<?php break;

															}	?>

		  												</span>
													</div>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-user-md fa-fw"></i> Castrado <br><br>
														<div class="col-xs-4 col-md-offset-0">
															<div class="form-group">
																<select class="form-control" name="select_castrado">
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
												   <textarea class="form-control" rows="3" id="txt_observacion" name="txt_observacion" onkeypress="return tabular(event,this)"><?php echo $observaciones; ?></textarea>
												</div>

												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-ticket fa-fw"></i> Nro. Recibo*</span>
														<input name="txt_nro_recibo" type="text" class="form-control" id="txt_nro_recibo" value="<?php echo $nroRecibo;?>" onkeypress="return tabular(event,this)"/>
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

																<div class="panel-body">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon"><i class="fa fa-user fa-fw"></i> Propietario </span>
																			<div class="col-xs-15 selectContainer">
																				<select id="combobox" class="form_control" name="select_propietarios">
																					<?php
																						while ($row=mysql_fetch_array($propietarios))
																						{
																							$id_persona = ($row['id_persona']);
																							$documento = ($row['documento']);
																							$nombre = ($row['nombre']);
																							$apellido = ($row['apellido']);

																						?>
																						<option value = "<?php echo $id_persona;?>" selected="selected"><?php echo  utf8_encode($documento." ".$nombre." ".$apellido);?> </option>
																					<?php
																						}

																						if($propietarioPrincipal != "")
																						{
																							$persona = sql_buscar_persona_id($propietarioPrincipal);

																							$rowPersona=mysql_fetch_array($persona);

																							$id_persona = ($rowPersona['id_persona']);
																							$documento = ($rowPersona['documento']);
																							$nombre = ($rowPersona['nombre']);
																							$apellido = ($rowPersona['apellido']);
																						?>
																							<option value = "<?php echo $id_persona;?>" selected="selected"><?php echo  utf8_encode($documento." ".$nombre." ".$apellido);?> </option>
																						<?php
																						}
																					?>
																				</select>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="panel-body">
																	<div class="form-group">
																		<div class="input-group">
																			<span class="input-group-addon"><i class="fa fa-user fa-fw"></i> Chip aplicado por: </span>

																			<input name="buscar_propietario" type="text" id="buscar_propietario" class="form-control" value="<?php echo $chipeador;?>" placeholder="Escribir aquí"/>

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
																			<input name="txt_nro_chip" type="text" class="form-control" id="txt_nro_chip" value="<?php echo $nroChip;?>" onkeypress="return tabular(event,this)" placeholder="Escanear chip"/>
																		</div>
																	</div>

																	<input name="Submit" type="submit" method="post" class="btn btn-sm btn-primary btn-block" value="GUARDAR" />
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