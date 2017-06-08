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
$link_horas_extras=conectarse_mysql_horas_extras();

$query="select codigo_organigrama,concepto from in_organigrama order by concepto";

$record_areas=mysql_query($query,$link_horas_extras);



//--------------Fin querys----------------------------


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Listado de cupos por areas entre fechas</title>

<link href="../css/estilos.css" rel="stylesheet" type="text/css">


<script language='javascript' src="../jscripts/java.js"></script>
<script language='javascript' src="../jscripts/popcalendar.js"></script>

<script type="text/javascript">

function validar(frm) {

   	if (validaFechaDDMMAAAA(document.form1.txt_fdesde.value)==false ){
  		alert("La fecha desde debe ser una fecha válida"); 
		document.form1.txt_fdesde.focus();
  		return (false); 
  	}
	
	   	if (validaFechaDDMMAAAA(document.form1.txt_fhasta.value)==false ){
  		alert("La fecha hasta debe ser una fecha válida"); 
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
    <td bgcolor="#A8B6C6" class="titulos_pantalla">Listado de cupos por area entre fechas</td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6"><table width="770" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><form action="../lib/pdf/repo_cupos_areas.php" method="post" name="form1" target="_blank" id="form1" onsubmit="return validar(this)" >
          <table width="770" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="middle" bgcolor="#D3DBE2"><table width="450" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
                  <tr>
                    <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fecha desde  :</td>
                    <td width="250" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_fdesde" type="text" id="txt_fdesde" tabindex="5" onclick="popUpCalendar(this, form1.txt_fdesde, 'dd-mm-yyyy');" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" value="<?php echo timestampToFecha(time());?>" size="10" />
                    </span></td>
                  </tr>
                  <tr>
                    <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fecha hasta: </td>
                    <td width="250" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                      <input name="txt_fhasta" type="text" id="txt_fhasta" tabindex="5" onclick="popUpCalendar(this, form1.txt_fhasta, 'dd-mm-yyyy');" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" value="<?php echo timestampToFecha (time());?>" size="10" />
                    </span></td>
                  </tr>
                  <tr>
                    <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Area:</td>
                    <td width="250" align="left" valign="middle" bgcolor="#D3DBE2"><label><span class="style17">
                    
                    <select name="txt_area" id="txt_area" tabindex="3" onkeypress="return tabular(event,this)" >
                     <option  value="<?php echo ""; ?>" selected="selected"><?php echo ""; ?></option>
                      <?php	
			  while($areas=mysql_fetch_array($record_areas)){ 
           		
			  ?>
                      <option  value="<?php echo $areas["codigo_organigrama"]; ?>"><?php echo htmlentities($areas["concepto"]); ?></option>
                      <?php
            	
		  	  }
         	?>
                    </select>
                    </span></label></td>
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
