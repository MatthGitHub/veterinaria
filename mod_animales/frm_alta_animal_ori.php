
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
//$todayh = getdate(); //monday week begin reconvert
//$d = $todayh[mday];
//$m = $todayh[mon];
//$y = $todayh[year];
//$fecha_actual =  "$d-$m-$y"; //getdate converted day
$flagEncontrada = true; 
$fecha_actual = date("d-m-Y");

$fecha_masanio = strtotime ( '+1 year' , strtotime ( $fecha_actual ) ) ;
$fecha_vencimiento = date ( 'd-m-Y' , $fecha_masanio );

$numeroRow = -1;
$senial = 0;
$adoptado = 0;

//Capturo variables
$especie = $_POST['txt_especie'];
$raza = $_POST['txt_raza'];
$pelaje = $_POST['select_pelaje'];
$tamanio = $_POST['select_tamanio'];
$esterelizado = $_POST['select_esterelizado'];
$sexo = $_POST['select_sexo'];
$nombreEjemplar = $_POST['txt_nombre_animal'];
$capturas = $_POST['txt_capturas'];
$caracter = $_POST['select_caracter'];
$altaCarnet = $_POST['txt_fecha_alta_carnet'];
$bajaCarnet = $_POST['txt_fecha_vencimiento'];
$nroRecibo = $_POST['txt_nro_recibo'];
$observaciones = $_POST['txt_observacion'];
$dni_fk = $_POST['txt_dni_fk'];
$gender = $_POST['gender']; 
$anios = $_POST['select_anios']; 
$castrado = $_POST['select_castrado']; 
$nroCarnet = $_POST['txt_nro_carnet']; 

if ($gender == 'senial')$senial = 1; 
else if ($gender == 'adoptado')$adoptado =1;


//$fecha_vencimiento = "$d-$m-$y";
$cargaInicialForm = 0;
$flagPersistencia = false;

//Cargo especies
$especies = sql_buscar_especies();	

//capturo especie seleccionada y parametros cargados
$valor = explode('.',$_POST['txt_especie']); 
$pEspecie = $valor[0];
$pDni = $valor[1];
$txt_nombre_animal = $valor[2];

//Capturo dni encontrado
$buscar_dni = $_POST['txt_buscar_dni'];

if ($buscar_dni == "") {
	//$ingresoDni = false;
	$dni=$buscar_dni= $pDni;
}

//Especie
if ( $pEspecie) {
	$pEspecie = $pEspecie;
}
else {
	$pEspecie = "Seleccione una especie..";
}

//busco id especie
$pId_especie = sql_buscar_id_especie($pEspecie);

//Cargo combo razas, en base a la especie
$razas = sql_buscar_razas($pId_especie);	

//Capturo raza seleccionada
$pRaza = $_POST['txt_raza'];

if ($pRaza) {
	$pRaza = $_POST['txt_raza'];
}
else {
	$pRaza = "Seleccione una raza..";
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



//#########################################LLAMO A BUSCAR PROPIETARIO MANTENGO DATOS CARGADOS################################
if (!empty($pDni))
{
	$propietario = sql_buscar_propietario($pDni);
	
	$numeroRow = mysql_num_rows($propietario); // obtenemos el número de filas
    //echo 'El número de registros de la tabla es: '.$numeroRow.'';  // imprimos en pantalla
	
	if ($propietario && $numeroRow > 0 ) 
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

//#########################################PERSISTIR DATOS####################################################

//Se quito la validacion de nro_recibo, por pedido del usuario.
$persistir = $_POST['txt_guardar'];

if ($persistir == 'guardar')
{		
	
	$fk_id_ejemplar = sql_insert_ejemplar_propietario($castrado,$especie,$raza,$pelaje,$tamanio,$txt_calle,$esterelizado,$sexo,$nombreEjemplar,$capturas,$altaCarnet,$bajaCarnet,$nroRecibo,$Observaciones,$caracter,$nroRecibo,$dni_fk,$adoptado,$senial,$anios,$observaciones);
	
	if (!$fk_id_ejemplar)
	{
		echo "Error al cargar el ejemplar, Nro. de Recibo: ".$nroRecibo." YA EXISTENTE!!!";
		$flagPersistencia = false;
	}
	else{
		
		$nro_carnet = sql_insert_carnet_ejemplar($altaCarnet,$bajaCarnet,$observaciones,$nroRecibo,$fk_id_ejemplar,$nroCarnet);
		
		$flagPersistencia=true;

	}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Veterinaria</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

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
.Estilo2 {font-weight: bold}
-->
</style>
</head>

<?php
if ($flagPersistencia)
{
?>

<script>
var variablejs = "<?php echo $nro_carnet; ?>" ;
alert ("El numero de carnet es: "+variablejs);
window.location.href="../mod_animales/frm_alta_animal.php";
</script>
	
<?php
}
?>
<body class="estilo_body_2" onLoad="document.formBuscar.txt_buscar_dni.focus();">

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#A8B6C6">
 <tr>
  <td width="770"><?php  include("../lib/encabezado.php"); ?></td>
  </tr>

  <tr>
    <td><?php include("../lib/barra_menu_standard.php"); ?></td>	
  </tr>

  <tr>
    <td height="35" bgcolor="#A8B6C6" class="titulos_pantalla"><p align="center">Alta de Animal </p></td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6"><table width="770" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="5" bgcolor="#FF9900">      
      </tr>
      <tr>
        <td height="20" bgcolor="#FF9900"> 
         <form id="formBuscar" name="formBuscar" method="post" value= "buscar_propietario" onsubmit="" action="frm_alta_animal.php" >
			    <strong>Propietario - DNI </strong>
			    <label>
			    <input name="txt_buscar_dni" type="text" id="txt_buscar_dni" value="<?php echo $dni;?>" tabindex="5" />
			    </label> 
				<input type="submit" name="Buscar_propietario" value="Buscar" method="post" onclick="submit()" tabindex="6" />
		<label><strong><font color="blue"> <?php  echo $resultadoBusqueda; ?> </font></strong></label></form>      </tr>
      <tr>
	  <tr>
        <td height="5" bgcolor="#FF9900">      
      </tr>
        <td><form id="form_alta_animal" name="form_alta_animal" method="post" onsubmit="" action="frm_alta_animal.php"  >
            <table width="770" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="bottom" bgcolor="#D3DBE2"><table width="307" height="106" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
				
                  <tr>
                    <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Nombre:</td>
                    <td width="220" height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17" >
                      <input name="txt_nombre_propietario" type="text" class="datos_sin_edicion" id="txt_nombre_propietario" tabindex="5" value="<?php echo $nombre;?>"  size="30" maxlength="45"  disabled="disabled"  />
                    </span></td>
                  </tr>
                  <tr>
                    <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Apellido</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_apellido" type="text" class="datos_sin_edicion" id="txt_apellido" tabindex="5" value="<?php echo $apellido;?>"  size="30" maxlength="45" disabled="disabled" />
                    </span></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Telefono:</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_telefono" type="text" class="datos_sin_edicion" id="txt_telefono" tabindex="5" value="<?php echo $telefono;?>"  size="20" maxlength="45" disabled="disabled" />
                    </span></td>
                  </tr>

                </table>
			    <table width="452" height="105" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
			     
				  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Calle:</td>
				    <td width="376" height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_calle" type="text" class="datos_sin_edicion" id="txt_domicilio" tabindex="5" value="<?php echo $calle;?>"  size="54" maxlength="45" disabled="disabled" />
				    </span></td>
				    </tr>
				  
                  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Nro:</td>
                    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_nro" type="text" class="datos_sin_edicion" id="txt_domicilio" tabindex="5" value="<?php echo $numero;?>"  size="54" maxlength="45" disabled="disabled" />
                    </span></td>
                  </tr>
                  <tr>
                    <td width="71" height="43" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Barrio:</td>
                    <td height="43" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_barrio" type="text" class="datos_sin_edicion" id="txt_domicilio" tabindex="5" value="<?php echo $barrio;?>"  size="54" maxlength="45" disabled="disabled" />
                    </span></td>
                  </tr>
                </table></td>
              </tr>
            </table>
     
            <table width="770" height="306" border="0" cellpadding="0" cellspacing="0">
			
            <tr bordercolor="#FFFFFF">
              <td height="25" colspan="4" align="left" valign="middle" bgcolor="#FF9900" class="etiquetas"><strong>Animal</strong></td>
			<tr bordercolor="#FFFFFF">
			  <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Especie :</div></td>
			  <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><label></label>
                  <label>
                  <select id="selectEspecie" name="txt_especie" onchange="form.submit()" tabindex="7" >
                    <?php 	
						 
							while ($row=mysql_fetch_array($especies))
							{
								$id_especie = ($row['id_especie']);									
								
								$especie = ($row['especie']);		

								?>
                    <option value = "<?php echo $especie.".".$dni; ?>" selected="selected"><?php echo $especie;?> </option>
                    <?php						
							}
						?>
                    <option  selected="selected"> <?php echo $pEspecie;?> </option>
                  </select>
                  <span class="style17"> <span class="Estilo1">*</span></span></label></td>
			
				<td width="82" height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><p align="left">Capturas:</p></td>
             	<td width="376" height="25" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                  
                    <div align="left">
                      <input name="txt_capturas" type="text" class="datos" id="txt_capturas" tabindex="19" title="" onkeypress="return tabular(event,this)" size="5" maxlength="50"/>
                    <span class="Estilo1">* </span>Años : 
                    <label>
                    <select name="select_anios" tabindex="19">
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                      <option value="12">12</option>
                      <option value="13">13</option>
                      <option value="14">14</option>
                      <option value="15">15</option>
                      <option value="16">16</option>
                      <option value="17">17</option>
                      <option value="18">18</option>
                      <option value="19">19</option>
                      <option value="20">20</option>
                    </select>
                    </label>
                    Meses
                    <label>
                    :                    </label>
                    <label>
                    <select name="select_castrado" tabindex="19.5">
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                      <option value="11">11</option>
                    </select>
                    </label>
                    </div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Raza :</div></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><label></label>
                  <label>
                  <select id="selectRaza" name="txt_raza" onchange="21" tabindex="9" >
                    <?php 					
						while ($row=mysql_fetch_array($razas))
						{
							$id_raza = ($row['id_raza']);
							$raza = ($row['raza']);

							?>
                    <option value = "<?php echo $raza;?>" selected="selected"><?php echo  utf8_encode($raza);?> </option>
                    <?php						
						}
						?>
                    <option  selected="selected"><?php echo $pRaza;?></option>
                  </select>
                  <span class="style17"> <span class="Estilo1">*</span></span></label></td>
              <td width="82" height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Carácter:</div></td>
              <td width="376" height="25" align="left" valign="middle" bgcolor="#D3DBE2"><div align="left">
                   <select  name="select_caracter"  tabindex="19">
                     <option value="Seleccione un caracter..">Seleccione un carácter..</option>
                    <option value="Sociable">Sociable</option>
                    <option value="Peligroso">Peligroso</option>
                    <option value="Amistoso">Amistoso</option>
                   </select>
									
                <span class="style17"> <span class="Estilo1">*</span></span></div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Pelaje  :</div></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><label></label>
                  <label>
                  <select name="select_pelaje" tabindex="10" >
                    <option value="Seleccione un pelaje..">Seleccione un pelaje..</option>
                    <option value="Perro">Negro</option>
                    <option value="Negro / Blanco">Negro / Blanco</option>
                    <option value="Blanco">Blanco</option>
                    <option value="Pardo">Pardo</option>
                    <option value="Dorado">Dorado</option>
                    <option value="Mestizo">Mestizo</option>
                    <option value="Marron">Marron</option>
                    <option value="Marron claro">Marron claro</option>
                    <option value="Beige">Beige</option>
                    <option value="Tricolor">Tricolor</option>
                    <option value="Gris">Gris</option>
                    <option value="Marron Atigrado">Marron Atigrado</option>
                    <option value="Negro Atigrado">Negro Atigrado</option>
                    <option value="Gris Atigrado">Gris Atigrado</option>
                    <option value="Marron Claro">Marron Claro</option>
                    <option value="Marron Oscuro">Marron Oscuro</option>
                    <option value="Chocolate">Chocolate</option>
                    <option value="Negro y Marron">Negro y Marron</option>
                    <option value="Negro y Beige">Negro y Beige</option>
                    <option value="Azul">Azul</option>
                    <option value="Champagne">Champagne</option>
                    <option value="Gris Jaspeado">Gris Jaspeado</option>
                    <option value="Negro Jaspeado">Negro Jaspeado</option>
                    <option value="Marron Jaspeado">Marron Jaspeado</option>
                    <option value="Negro Fuego">Negro Fuego</option>
                    <option value="Negro y Amarillo">Negro y Amarillo</option>
                    <option value="Negro y Gris">Negro y Gris</option>
                    <option value="Marron y Blanco">Marron y Blanco</option>
                    <option value="Colorado">Colorado</option>
                    <option value="Gris con Blanco">Gris con Blanco</option>
                    <option value="Atigrado">Atigrado</option>
                    <option value="Blanco y Negro">Blanco y Negro</option>
                  </select>
                  <span class="style17"> <span class="Estilo1">*</span></span></label></td>
              <td width="82" height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas Estilo"><div align="left">Alta Carnet:</div></td>
              <td width="376" height="25" align="left" valign="middle" bgcolor="#D3DBE2"><label>
                              
           <input name="txt_fecha_alta_carnet" type="text" class="Estilo2" id="txt_fecha_alta_carnet" tabindex="20" onclick="popUpCalendar(this, form_alta_animal.txt_fecha_alta_carnet, 'dd-mm-yyyy');" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" value="<?php echo $fecha_actual;?>"  size="10" maxlength="10" />
								
                                              <span class="Estilo1">*</span></div>
              </label></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Tamaño:</div></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><select name="select_tamanio" tabindex="12">
                <option value="Seleccione un tamanio..">Seleccione un tamaño..</option>
                  <option value="Grande">Grande</option>
                  <option value="Chico">Chico</option>
                  <option value="Mediano">Mediano</option>
              </select></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">V. Carnet :</div></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><div align="left"><span class="style17">
                  <input name="txt_fecha_vencimiento" type="text" class="Estilo2" id="txt_fecha_vencimiento" tabindex="20" onclick="popUpCalendar(this, form_alta_animal.txt_fecha_vencimiento, 'dd-mm-yyyy');" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" value="<?php echo $fecha_vencimiento;?>"  size="10" maxlength="10" />
                  <span class="Estilo1"> *</span></span></div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Esterilizado: </div></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">
                <label>
                <select name="select_esterelizado" tabindex="14">
                  <option value="0">No</option>
                  <option value="1">Si</option>
                </select>
                </label>
              </span></span></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Nro. Carnet:</div></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><div align="left">
                  <input name="txt_nro_carnet" type="text" class="datos" id="txt_nro_carnet" tabindex="21" title="" onkeypress="return tabular(event,this)" size="5" maxlength="50"/>
                  <span class="Estilo1">*</span>
                  </label>
              </div></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Sexo</div></td>
              <td height="25" align="left" valign="middle" bgcolor="#D3DBE2"><select name="select_sexo" tabindex="17">
                  <option value="Macho">Macho</option>
                  <option value="Hembra">Hembra</option>
              </select></td>
              <td width="82" height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Nro. Recibo:</div></td>
              <td width="376" height="25" align="left" valign="middle" bgcolor="#D3DBE2"><div align="left">
                <input name="txt_nro_recibo" type="text" class="datos" id="txt_nro_recibo" tabindex="21" title="" onkeypress="return tabular(event,this)" size="5" maxlength="50"/>
                <span class="Estilo1">*</span>
                </label>
</div></td>
            </tr>
			
			<tr bordercolor="#FFFFFF">
			  <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Nombre:</div></td>
			  <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                  <div align="left">
                    <input name="txt_nombre_animal" type="text" class="datos" id="txt_nombre_animal" tabindex="17" title="" onkeypress="return tabular(event,this)" size="26" maxlength="50" value = "<?php echo $txt_nombre_animal;?>" />
                    <span class="Estilo1">*</span></div></td>
			  <td width="82" height="25" rowspan="3" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="left">Observaci&oacute;n:</div></td>
              <td width="376" height="25" rowspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><label>
                <div align="left">
                  <textarea name="txt_observacion" cols="60" rows="5" class="datos" id="txt_observacion" tabindex="22"></textarea>
                  </div>
              </label></td>
            </tr>
            <tr bordercolor="#FFFFFF">
              <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><span class="Estilo1"></span>Adoptado:
                <label></label>
                  <label></label>
                  <label></label></td>
              <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><input name="gender" type="radio" value="adoptado" />
                  <?php if (isset($gender)) echo "checked";?>
                  <span class="etiquetas">Señal:
                    <input name="gender" type="radio" value="senial" />
                  <?php if (isset($gender)) echo "checked";?>
                </span></td>
              </tr>
            <tr bordercolor="#FFFFFF">
              <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">&nbsp;</td>
              <td height="10" align="left" valign="middle" bgcolor="#D3DBE2">&nbsp;</td>
              </tr>
            <tr>
              <td align="left" valign="bottom" bgcolor="#D3DBE2">			  </td>
              <td align="left" valign="bottom" bgcolor="#D3DBE2">&nbsp;</td>			  
              <td align="left" valign="bottom" bgcolor="#D3DBE2">&nbsp;</td>
			  <input type="hidden" name="txt_dni_fk" value="<?php echo $dni;?>">
              <td align="left" valign="bottom" bgcolor="#D3DBE2"><div align="right"><span class="etiquetas">
                <input type="submit" id="txt_guardar" name="txt_guardar" value="Guardar" tabindex="23" onclick="return validar_frm_alta_ejemplar();"  />
              </span></div></td>
            </tr>
            <tr>
              <td align="left" valign="bottom" bgcolor="#D3DBE2">&nbsp;</td>
              <td align="left" valign="bottom" bgcolor="#D3DBE2">&nbsp;</td>
              <td align="left" valign="bottom" bgcolor="#D3DBE2">&nbsp;</td>
              <td align="left" valign="bottom" bgcolor="#D3DBE2">&nbsp;</td>			
            </tr>
          </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
