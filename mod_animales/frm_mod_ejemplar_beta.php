
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

/*$stmtP = sql_buscar_personas();

//Si hay resultados...
if (mysql_num_rows($stmtP) > 0){

while($fila = mysql_fetch_assoc($stmtP)){
		 // se recoge la información según la vamos a pasar a la variable de javascript
				 $texto .= '"'.$fila['documento'].' '.$fila['nombre'].' '.$fila['apellido'].'",';
	}

}else{
		$texto = "NO HAY RESULTADOS EN LA BBDD";
}*/

//Capturo dni encontrado
$buscar_chip = $_GET['txt_buscar_chip'];

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
$successAnimal = false;
$errorEjemplar = false;
$errorCarga = false;

$propMostrar="";

//Cargo especies
$especies = sql_buscar_especies();

//Cargo pelajes
$pelajes= sql_traer_pelajes();

//Cargo propietarios
$propietarios = sql_traer_propietarios();

//Capturo variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$ejemplar = sql_buscar_ejemplar_chip($buscar_chip);

	$numeroRow = mysql_num_rows($ejemplar); // obtenemos el número de filas

	if ($ejemplar && $numeroRow > 0)
	{
		while ($row=mysql_fetch_array($ejemplar))
		{
			$id_ejemplar = $row['id_ejemplar'];
		}
	}

	$nombreEjemplar = test_input($_POST['txt_nombre_animal']);

	$fechaChip = $_POST['txt_fecha_chip'];

	$urlFoto =  test_input($_POST['txt_foto_carnet']);

	$anioNacimiento =  test_input($_POST['txt_anio_animal']);

	$capturas = test_input($_POST['txt_capturas']);

	$fechaCastrado = test_input($_POST['txt_fecha_castrado']);

	$observaciones = test_input($_POST['txt_observacion']);

	$nroRecibo = test_input($_POST['txt_nro_recibo']);

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

	$chipeador = $_POST['buscar_propietario'];

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
	}elseif(!is_numeric($propietarioPrincipal))
	{
		$valPropietario = true;
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

$chipeador = $_POST['buscar_propietario'];

//$campos_chip = explode(" ", $chipeador);
//echo trim ($campos_chip[0]); // dni

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


$successAnimal = false;

if($validadoAnimal == true)
{
	$fk_id_ejemplar = sql_update_ejemplar($id_ejemplar,$nombreEjemplar,$anioNacimiento,$especie,$raza,$pelaje,$tamanio,$sexo,$condicion,$caracter,$capturas,$castrado,$fechaCastrado,$observaciones, $fechaChip, $plan, $urlFoto, $nroRecibo, $sextuple, $fechaSextuple, $quintuple, $fechaQuintuple, $rabia, $fechaRabia, $hidatidosis, $fechaHidatidosis, $gusanos_redondos, $fechaGusanos, $propietarioPrincipal/*, $campos_chip[0]*/);

	if (!$fk_id_ejemplar)
	{
		$errorEjemplar = true;
	}
	else{

		$successAnimal = true;


		$file_name= $_FILES['txt_foto_carnet']['name'];
		$file= $_FILES['txt_foto_carnet']['tmp_name'];
		$path="imagenes_ejemplares/";


		move_uploaded_file ($file,$path.$file_name);

		$sql="insert into ejemplares_fotos(id_ejemplar,archivo)
				values('$id_ejemplar','$file_name')";
			//echo $sql;
			mysql_query($sql,$link);

	}
}

//#########################################LLAMO A BUSCAR EJEMPLAR POR NRO################################

if (!empty($buscar_chip))
{
	$ejemplar = sql_buscar_ejemplar_chip($buscar_chip);

	$numeroRow = mysql_num_rows($ejemplar); // obtenemos el número de filas

	if ($ejemplar && $numeroRow > 0)
	{
		while ($row=mysql_fetch_array($ejemplar))
		{
			$id_ejemplar = $row['id_ejemplar'];

			$nombreEjemplar = $row['nombre'];
			$urlFoto =  "";
			$anioNacimiento = $row['anio_nacimiento'];

			$tamanio = $row['tamanio'];
			$pTamanio = $tamanio;

			$sexo = $row['sexo'];
			$pSexo = $sexo;

			$condicion = $row['condicion'];
			$pCondicion = $condicion;

			$caracter = $row['caracter'];
			$pCaracter = $caracter;

			$capturas = $row['capturas'];

			if($row['castrado'] == 0)
			{
				$castrado = "No";
			}elseif($row['castrado'] == 1)
			{
				$castrado = "Si";
			}

			$pCastrado = $castrado;

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
					$pPlan = $plan;
					$aplicador = $rowC['fk_id_persona'];

					$personaAp = sql_buscar_persona_id($aplicador);

					$rowAplicador=mysql_fetch_array($personaAp);

					$chipeador = $rowAplicador['documento'].' '.$rowAplicador['nombre'].' '.$rowAplicador['apellido'];
				}
			}

			//Busco Especie
			$especie = sql_buscar_especies_por_id($row['fk_id_especie']);
			$pEspecie = $especie;

			//Cargo combo razas, en base a la especie
			$razas = sql_buscar_razas($row['fk_id_especie']);

			//Busco Raza
			$raza = sql_buscar_raza_por_id($row['fk_id_raza']);
			$pRaza = $raza;

			//Busco Pelaje
			$pelaje = sql_buscar_pelaje_por_id($row['fk_id_pelaje']);
			$pPelaje = $pelaje;

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
				}
			}

			$propietario = sql_buscar_propietario_ejemplar($row['id_ejemplar']);

			$numeroRowPropietario = mysql_num_rows($propietario); // obtenemos el número de filas

			if ($propietario && $numeroRowPropietario > 0)
			{
				while ($rowProp=mysql_fetch_array($propietario))
				{
					$propietarioPrincipal=$rowProp['id_persona'];
					$id_persona = $propietarioPrincipal;
					$propMostrar = $rowProp['documento']." ".$rowProp['nombre']." ".$rowProp['apellido'];

				}
			}
		}
		$buscar_chip = "";
	}
}else{
		$errorCarga = true;
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
				<form id="frm_mod_ejemplar" name="frm_mod_ejemplar" method="post" onsubmit="" action="<?php $_SERVER["PHP_SELF"];?>" >

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
							}elseif($valPropietario == true){
								echo "
									<div class='alert alert-danger-alt alert-dismissable'>
									<span class='glyphicon glyphicon-exclamation-sign'></span>
									<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>
									×</button>Debe indicar un PROPIETARIO.</div>
								";
								$valPropietario = false;
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
								<h4 class="text-center"><img src="../images/icons/propietario.png" alt="Municipalidad Bariloche" align="center" style="margin:0px 0px 0px 0px" height="64" width="64"></h4>

												<div class="col-md-6 col-md-offset">
													<div class="panel panel-default">

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
																				<option value = "<?php echo $id_persona;?>"><?php echo  utf8_encode($documento." ".$nombre." ".$apellido);?> </option>
																			<?php
																				}
																			?>

																			<option value = "<?php echo $propietarioPrincipal;?>" selected="selected"><?php echo $propMostrar; ?></option>

																		</select>
																	</div>
																</div>
															</div>
														</div>

														<div class="panel-body">
															<div class="form-group">
																<div class="input-group">
																	<span class="input-group-addon"><i class="fa fa-user fa-fw"></i> Chip aplicado por: </span>

																	<input name="buscar_propietario" type="text" class="form-control" id="buscar_propietario"  value="<?php echo $chipeador; ?>" disabled="disabled"/>
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
																	<input name="txt_nro_chip" type="text" class="form-control" id="txt_nro_chip" value="<?php echo $nroChip;?>"  disabled="disabled"  />
															  </div>

                                                                <div class="input-group">
																<span class="input-group-addon"><i class="fa fa-microchip fa-fw"></i></span>

                                                                <input name='file' type='file' />
                                                                <table width="350" border="0" cellspacing="1">
                                                                  <tr>
                                                                    <td width="200" align="left" valign="bottom" bgcolor="#A8B6C6" class="etiquetas">Nombre</td>
                                                                    <td width="120" align="center" valign="bottom" bgcolor="#A8B6C6" class="etiquetas">Imagen</td>
                                                                    <td width="30" align="left" valign="bottom" bgcolor="#A8B6C6" class="etiquetas">&nbsp;</td>
                                                                  </tr>
                                                                  <?php

			 	$sql_images="select * from noticias_2014_files where id_tipo='1' and id_contenido=$id_noticia";
		   		$result_images=mysql_query($sql_images,$link);

		  		$color_fondo="#FFFFFF";
		  		$cont=0;

				while($row=mysql_fetch_array($result_images)){
		  ?>
                                                                  <tr>
                                                                    <td width="200" align="left" valign="bottom" bgcolor="<?php echo $color_fondo; ?>" class="<?php echo $clase;?>"><?php echo $row['nombre']; ?></td>
                                                                    <td width="120" align="center" valign="bottom" bgcolor="<?php echo $color_fondo; ?>" class="<?php echo $clase;?>"><img  border="0" class='mano' src='../images_noticias/<?php echo $row["nombre"];?>' width="100" /></td>
                                                                    <td width="30" align="left" valign="bottom" bgcolor="<?php echo $color_fondo; ?>" class="<?php echo $clase;?>"><a href="prensa_foto_delete.php?id_file=<?php echo $row['id_file']; ?>&tipo=<?php echo $tipo_contenido;?>"><img border="0" class='' src='images/eliminar.gif' /></a></td>
                                                                  </tr>
                                                                  <?php
		  	if ($color_fondo=="#FFFFFF"){
					$color_fondo="#E2E7EB";
				}
				else
				{
				$color_fondo="#FFFFFF";
				}
		  }
		  ?>
                                                                </table>
                                                                </div>
														  </div>

															<input name="Submit" type="submit" method="post" class="btn btn-sm btn-primary btn-block btn-danger" value="GUARDAR CAMBIOS" />
														</div>
													</div>
												</div>

							</form>
						</div>
					</div>	<!-- Container -->
				</form>
	</div>  <!-- Jumbotron -->

</body>
</html>
