<?php 
//--------------------------------Inicio de sesion------------------------
include("../lib/sesion.php"); 
if ($_SESSION['permiso'] != 'autorizado' or $_SESSION['area'] != 'med'){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------


include("../lib/funciones.php");
$link_bche=conectarse_bche();	


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Certificado</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

<script type="text/JavaScript">
//---------------------Verificar abandono de la pagina-------------------//
var bPreguntar = true;
     
    window.onbeforeunload = preguntarAntesDeSalir;
     
    function preguntarAntesDeSalir()
    {
      if (bPreguntar)
        return "";
    }
//------------------Fin verificar abandono--------------------------//
</script>


<script language='javascript' src="../jscripts/funciones.js"></script>
</head>


<body class="estilo_body_2" onLoad="document.form1.txt_legajo.focus();">

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DBDBDB">
 <tr>
  <td width="770"><?php include("../lib/encabezado.php"); ?></td>
  </tr>
  <tr>
    <td><?php include("../lib/barra_menu_standard.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6" class="titulos_pantalla">Alta de cupo </td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6"><table width="770" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><form id="form1" name="form1" method="post" onsubmit="return validar(this)" action="frm_alta_cupo_s2.php" >
            <table width="770" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#D3DBE2"><table width="770" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
                    <tr>
                      <td width="170" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><div align="right">Area :</div></td>
                      <td width="600" align="left" valign="middle" bgcolor="#D3DBE2"><table width="120" border="0" cellpadding="0" cellspacing="0" >
						<td width="200" align="left" valign="middle">
						<SELECT NAME="areas">
						<option>Seleccione una Opción...</option>
						<?php 
						$sql ="SELECT concepto
							   FROM in_organigrama 
							   WHERE   	codigo_organigrama != 0 AND
										codigo_organigrama != 0010 AND
										codigo_organigrama != 0110 AND
										codigo_organigrama != 103  AND
										codigo_organigrama != 106  AND
										codigo_organigrama != 1750 AND       
										codigo_organigrama != 998 
										ORDER BY concepto
							";
							
						$areas = mssql_query($sql,$link_bche);	
						while ($row=mssql_fetch_array($areas))
							{
							$concepto = ($row['concepto']);
							$area_sin_asc=normaliza($concepto);
							echo "<OPTION>", $area_sin_asc, "</OPTION>";
							}
						?>
						</SELECT> </td>
                          <td width="60"><a href="#"><img src="../images/adelante.gif" width="24" height="24" border="0" onclick="bPreguntar = false;document.form1.submit();" /></a></td>
                        </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table>
        </form></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
