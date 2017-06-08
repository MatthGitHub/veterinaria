
<?php 
error_reporting(0);
//--------------------------------Inicio de sesion------------------------

include("../lib/sesion.php"); 
if ($_SESSION['permiso'] != 'autorizado' ){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion-----------------------

//Parametros - var - librerias
include("../lib/funciones.php");
include("../mod_sql/sql.php");	

//Inicializo variables
$cargaInicialForm = 0;
$flagPersistencia = false;

//Capturo variables
$select_persona = $_POST['select_persona']; 
$txt_id_ejemplar = $_POST['txt_id']; 
$txt_nombre_ejemplar = $_POST['txt_nombre'];  
$txt_caracter = $_POST['select_caracter']; 
$txt_anios = $_POST['txt_anios']; 
$txt_especie = $_POST['selectEspecie'];
$txt_raza = $_POST['txt_raza'];
$select_pelaje = $_POST['select_pelaje'];
$select_tamanio = $_POST['select_tamanio'];
$txt_sexo = $_POST['select_sexo'];
$txt_capturas = $_POST['txt_capturas'];
$txt_observaciones = $_POST['txt_observaciones'];


$txt_checkboxAdopatdo = $_POST['checkboxAdopatdo']; 
if($txt_checkboxAdopatdo == "on")$txt_checkboxAdopatdo = 1; else $txt_checkboxAdopatdo = 0; 

$txt_meses = $_POST['select_meses']; 

$txt_checkboxSenial = $_POST['checkboxSenial'];
if($txt_checkboxSenial == "on")$txt_checkboxSenial = 1; else $txt_checkboxSenial = 0; 

$txt_checkboxEsterilizado = $_POST['checkboxEsterilizado']; 
if($txt_checkboxEsterilizado == "on")$txt_checkboxEsterilizado = 1; else $txt_checkboxEsterilizado = 0; 

$txt_checkboxFalecido = $_POST['checkboxFalecido']; 
if($txt_checkboxFalecido == "on")$txt_checkboxFalecido = 1; else $txt_checkboxFalecido = 0; 

//Capturo nro encontrado
$buscar_nro = $_POST['txt_buscar_nro'];


//#########################################LLAMO A BUSCAR EJEMPLAR POR NRO################################

if (!empty($buscar_nro))
{
	$ejemplar = sql_buscar_ejemplar($buscar_nro);	
 
	$numeroRow = mysql_num_rows($ejemplar); // obtenemos el número de filas
	
	if ($ejemplar && $numeroRow > 0) 
	{
		while ($row=mysql_fetch_array($ejemplar))
		{
			$id_ejemplar = $row['id_ejemplar']; 
			$nombre = ($row['nombre']); 
			$sexo = ($row['sexo']);
			$caracter = ($row['caracter']); 
			$pelaje = ($row['pelaje']);
			$capturas = ($row['capturas']);
			$tamanio = ($row['tamanio']);
			$anios = ($row['anios']);	
			$esterilizado = ($row['esterilizado']);	
			$senial = ($row['senial']);
			$fallecido = ($row['fallecido']);	
			$adoptado = ($row['adoptado']);	
			$meses = ($row['castrado']);
			$fk_id_especie = ($row['fk_id_especie']);	
			$fk_id_raza = ($row['fk_id_raza']);	
			$fk_documento = ($row['fk_documento']);	
			$observaciones = ($row['observaciones']);	
		}
	}
		else
		$resultadoBusqueda= "El ejemplar no se encuetra cargado en el Sistema";
}

//Set combo carater 
$pCaracter = $caracter;

//Cargo Personas
$pPersona = $fk_documento;
$personas = sql_buscar_personas(); 

//Cargo especies
$pEspecie = sql_buscar_especies_por_id($fk_id_especie); 
$especies = sql_buscar_especies();

//Cargo combo razas, en base a la especie
$pRaza  = sql_buscar_raza_por_id($fk_id_raza);
$razas = sql_buscar_razas_todas();	

//Cargo combo  pelaje
$pPelaje = $pelaje;

//Cargo combo tamaño
$pTamanio = $tamanio;

//Cargo combo sexo
$pSexo = $sexo;

//Cargo Meses
$pMeses  = $meses ;



//#########################################PERSISTIR DATOS####################################################

$persistir = $_POST['txt_guardar'];

if ($persistir == 'Guardar')
{	

	$update = sql_update_ejemplar($txt_id_ejemplar,$txt_nombre_ejemplar,$txt_caracter,$txt_anios,$txt_especie,$txt_raza ,$select_pelaje,$select_tamanio,$txt_sexo,$txt_capturas,$txt_observaciones,$txt_checkboxAdopatdo,$txt_meses,$txt_checkboxSenial,$txt_checkboxEsterilizado,$select_persona,$txt_checkboxFalecido);
	
	if (!$update)
	{
		echo "Error al modificar ejemplar";
		$flagPersistencia = false;
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
	alert("focus animal sexo");
	return (false);	
}

</script>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
-->
</style>
</head>


<body class="estilo_body_2" onLoad="document.formBuscar.txt_buscar_nro.focus();">

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#A8B6C6">
 <tr>
  <td width="770"><?php  include("../lib/encabezado.php"); ?></td>
  </tr>

  <tr>
    <td><?php include("../lib/barra_menu_standard.php"); ?></td>	
  </tr>

  <tr>
    <td height="35" bgcolor="#A8B6C6" class="titulos_pantalla"><p align="center" class="Estilo1">Modificar Animal </p></td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6"><table width="770" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="5" bgcolor="#FF9900">      
      </tr>
      <tr>
        <td height="20" bgcolor="#FF9900"> 
         <form id="formBuscar" name="formBuscar" method="post" value= "buscar_ejemplar" onsubmit="" action="frm_mod_ejemplar.php" >
			    <strong>Ejemplar - Nro. </strong>
			    <label>
			    <input name="txt_buscar_nro" type="text" id="txt_buscar_nro" value="<?php echo $buscar_nro;?>" tabindex="5" />
			    </label> 
				<input type="submit" name="Buscar_ejemplar" value="Buscar" method="post" onclick="submit()" tabindex="6" />
		<label><strong><font color="blue"> <?php  echo $resultadoBusqueda; ?> </font></strong></label></form>      </tr>
      <tr>
	  <tr>
        <td height="5" bgcolor="#FF9900">      
      </tr>
        <td><form id="form_mod_ejemplar" name="form_mod_ejemplar" method="post" onsubmit="" action="frm_mod_ejemplar.php"  >
            <table width="770" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="bottom" bgcolor="#D3DBE2"><table width="307" height="179" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
                  <tr>
                    <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Nro:</td>
                    <td height="10" align="left" valign="middle" bordercolor="#D4D0C8" bgcolor="#D3DBE2"><span class="style17" >
                      <input name="txt_id_ejemplar" disabled="disabled" type="text" class="datos" id="txt_id_ejemplar" tabindex="5" value="<?php echo $id_ejemplar;?>"  size="30" maxlength="45">
					  <input type="hidden" name="txt_id" value="<?php echo $id_ejemplar;?>"  /> 
                      <span class="Estilo1">*</span></span></td>
                  </tr>
                  <tr>
                    <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Nombre:</td>
                    <td width="220" height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17" >
                      <input name="txt_nombre" type="text" class="datos" id="txt_nombre" tabindex="5" value="<?php echo $nombre;?>"  size="30" maxlength="45"   />
                      <span class="Estilo1">*</span></span></td>
                  </tr>
                  <tr>
                    <td height="15" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Caracter:</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">                    
                     <select  name="select_caracter"  tabindex="19">
                   	 <option value="Sociable">Sociable</option>
                  	 <option value="Peligroso">Peligroso</option>
                  	 <option value="Amistoso">Amistoso</option>
					 <option  selected="selected"> <?php echo $pCaracter;?> </option>
                   </select>
					 
					  <span class="Estilo1">*</span></span></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Sexo:</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <select name="select_sexo" tabindex="17">
                 		    <option value="Macho">Macho</option>
                  			<option value="Hembra">Hembra</option>
							<option  selected="selected"> <?php echo $pSexo;?> </option>
             			 </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Esterilizado:</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><label>
                      <input name="checkboxEsterilizado" type="checkbox" <?php if ($esterilizado == 1) { ?> checked="CHECKED"  <?php } ?> />
                    </label></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Años:</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_anios" type="text" class="datos" id="txt_anios" tabindex="5" value="<?php echo $anios;?>"  size="20" maxlength="45"/>
                    </span></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Meses:</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><select name="select_meses" tabindex="19.5">
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
					   <option  selected="selected"> <?php echo $pMeses;?> </option>
                                        </select></td>
                  </tr>
                  <tr>
                    <td height="25" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Tamaño:</td>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2"><select name="select_tamanio" tabindex="12">
                      <option value="Seleccione un tamanio..">Seleccione un tamaño..</option>
                      <option value="Grande">Grande</option>
                      <option value="Chico">Chico</option>
                      <option value="Mediano">Mediano</option>
					   <option  selected="selected"> <?php echo $pTamanio;?> </option>
                    </select></td>
                  </tr>
             
                </table>				
			    <table width="383" height="279" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
			     
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Especie:</td>
			        <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">				  
					<select id="selectEspecie" name="selectEspecie" onchange="" tabindex="7" >
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
					
					*</span></span></td>
			        </tr>
			     
				  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Raza:</td>
				    <td width="267" height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">
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
					
					*</span></span></td>
				    </tr>
				  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Pelaje:</td>
				    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">
					<select name="select_pelaje" tabindex="10" >
                    <option value="Negro">Negro</option>
                    <option value="Negro / Blanco">Negro / Blanco</option>
                    <option value="Blanco">Blanco</option>
                    <option value="Pardo">Pardo</option>
                    <option value="Dorado">Dorado</option>
                    <option value="Mestizo">Mestizo</option>
                    <option value="Marron">Marron</option>
                    <option value="Marron claro">Marron claro</option>
                    <option value="Beige">Beige</option>
                       <option  selected="selected"><?php echo $pPelaje;?></option>
                    </select>
					*</span></span></td>
				    </tr>
				  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Capturas:</td>
				    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_capturas" type="text" class="datos" id="txt_domicilio" tabindex="5" value="<?php echo $capturas;?>"  size="5" maxlength="5" />
                      <span class="Estilo1">*</span></span><span class="Estilo1"></span></span></td>
				    </tr>
				  
                  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Adoptado:</td>
                    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">
                      <label>
                      <input name="checkboxAdopatdo" type="checkbox" <?php if ($adoptado == 1) { ?> checked="CHECKED"  <?php } ?> />
                      </label>
                    </span></span></td>
                  </tr>
                
                  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Señal:</td>
                    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">
                      <label></label>
                      <label>
                      <input name="checkboxSenial" type="checkbox" <?php if ($senial == 1) { ?> checked="checked"  <?php } ?> />
                      </label>
                    </span></span></td>
                  </tr>
                  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fallecido:</td>
                    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">
                      <label></label>
                      <label>
                      <input name="checkboxFalecido" type="checkbox" <?php if ($fallecido == 1) { ?> checked="CHECKED"  <?php } ?> />
                      </label>
                    </span></span></td>
                  </tr>
                  <tr>
                    <td height="10" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Propietario:</td>
                    <td height="25" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17"><span class="Estilo1">
                     <select id="select_persona" name="select_persona" onchange="" tabindex="7" >
                    <?php 	
						 
							while ($row=mysql_fetch_array($personas))
							{
								$nro_documento = ($row['documento']);										

								?>
                    <option value = "<?php echo $nro_documento; ?>" selected="selected"><?php echo $nro_documento;?> </option>
                    <?php						
							}
						?>
                    <option  selected="selected"> <?php echo $pPersona;?> </option>
                  </select>
                      *</span></span></td>
                  </tr>
                  
                  <tr>
                    <td width="113" height="43" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Observaciones:</td>
                    <td height="43" colspan="3" align="left" valign="middle" bgcolor="#D3DBE2"><label>
                      <textarea name="txt_observaciones" cols="30" id="txt_observaciones" ><?php echo $observaciones;?></textarea>
                    </label></td>
                  </tr>
                </table></td>
              </tr>
            </table>
     
            <table width="770" height="50" border="0" cellpadding="0" cellspacing="0">
		   <input type="hidden"  name="txt_dni_original"  class="datos" id="txt_dni_original"  tabindex="5" value="<?php echo $caracter;?>"  size="20" maxlength="45"/>   
            <tr bordercolor="#FFFFFF">
              <td height="25" colspan="4" align="left" valign="middle" bgcolor="#FF9900" class="etiquetas">&nbsp;</td>
            
            <tr bordercolor="#FFFFFF">
            
              <td width="732" height="25" align="left" valign="middle" bgcolor="#A8B6C6"><div align="right"><span class="etiquetas">
                <input type="submit" id="txt_guardar" name="txt_guardar" value="Guardar" tabindex="23" onclick="return validar_frm_mod_ejemplar();"  />
              </span></div></td>
              
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
