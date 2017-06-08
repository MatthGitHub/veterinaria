<?php 
//--------------------------------Inicio de sesion------------------------
include("../lib/sesion.php"); 
if ($_SESSION['permiso'] != 'autorizado' or $_SESSION['area'] != 'med' or $_SESSION['subarea'] != 'meddoc'){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

include("../lib/funciones.php");
include("../lib/querys.php");

//-------Parametros--------------------------------




//-------------------------------------------------

//---------------Querys-----------------------------




//--------------Fin querys----------------------------


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Listado de horas tomadas</title>

<link href="../css/estilos.css" rel="stylesheet" type="text/css">


<script language='javascript' src="../jscripts/java.js"></script>
<script language='javascript' src="../jscripts/popcalendar.js"></script>

<script type="text/javascript">

function validar(frm) {

   		if (validaFechaDDMMAAAA(document.form1.txt_fdesde.value)==false ){
  		alert("La fecha de inicio de la licencia medica debe ser una fecha válida"); 
		document.form1.txt_fdesde.focus();
  		return (false); 
  	}
	
	if (validaFechaDDMMAAAA(document.form1.txt_fhasta.value)==false ){
  		alert("La fecha de inicio de la licencia medica debe ser una fecha válida"); 
		document.form1.txt_fhasta.focus();
  		return (false); 
  	}
	
	if (!confirm('¿Estas seguro de enviar este formulario?')){   
	   return (false); 
   	}
}

</script>


<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style17 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>


<body class="estilo_body_2" onLoad="document.form1.txt_descripcion.focus();">

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DBDBDB">
 <tr>
  <td width="770"><?php include("../lib/encabezado.php"); ?></td>
  </tr>
  <tr>
    <td><?php include("../lib/barra_menu_standard.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6" class="titulos_pantalla">Listado de horas tomadas</td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6"><table width="770" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form action="../lib/pdf/repo_cupos_personas_horas.php" method="post" name="form1" target="_blank" id="form1" onsubmit="return validar(this)" >
          <table width="770" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="middle" bgcolor="#D3DBE2"><table width="450" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
                  <tr>
                    <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fecha desde  :</td>
                    <td width="250" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_fdesde" type="text" id="txt_fdesde" tabindex="5" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" onclick="popUpCalendar(this, form1.txt_fdesde, 'dd-mm-yyyy');" size="10" value="<?php echo timestampToFecha(time());?>"/>
                    </span></td>
                  </tr>
                  <tr>
                    <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fecha hasta: </td>
                    <td width="250" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_fhasta" type="text" id="txt_fhasta" tabindex="5" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" onclick="popUpCalendar(this, form1.txt_fhasta, 'dd-mm-yyyy');" size="10" value="<?php echo timestampToFecha(time());?>"/>
                    </span></td>
                  </tr>
                  <tr>
                    <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Legajo:</td>
                    <td width="250" align="left" valign="middle" bgcolor="#D3DBE2"><label>
                    <input type="text" name="txt_legajo" id="txt_legajo" />
                    </label></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><input type="submit" name="Submit" value="Ver" onclick="bPreguntar = false;"/></td>
                    <td align="left" valign="middle" bgcolor="#D3DBE2">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table>
        </form></td>
      </tr>
      <tr>
        <td bgcolor="#D3DBE2">&nbsp;</td>
      </tr>
      <tr>
        <td></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
