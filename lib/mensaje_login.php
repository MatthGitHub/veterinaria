<?php 


$mensaje=$_GET['mensaje'];
$destino=$_GET['destino'];

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Mensaje del sistema</title>

<link href="../css/estilos.css" rel="stylesheet" type="text/css">



<script type="text/javascript">

function validar(frm) {

   	if (document.form1.txt_descripcion.value==""){
  		alert("Debe ingresar una descripción de la especialidad");
		document.form1.txt_descripcion.focus(); 
  		return (false); 
  	}
	
	if (!confirm('¿Estas seguro de enviar este formulario?')){   
	   return (false); 
   	}
}
	
</script>
<script language='javascript' src="../jscripts/funciones.js"></script>

<link href="../css/estilos.css" rel="stylesheet" type="text/css" />
</head>


<body class="estilo_body" onLoad="document.form1.continuar.focus();">

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DBDBDB">
 <tr>
  <td width="770"><?php include("../lib/encabezado.php"); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6" class="titulos_pantalla">Mensaje del sistema </td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6"><table width="770" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><form id="form1" name="form1" method="post"  action="<?php echo $destino;?>" >
            <table width="770" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#D3DBE2"><table width="770" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
                    <tr>
                      <td colspan="2" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas_encabezado"><?php echo utf8_encode($mensaje);?></td>
                      </tr>

                    <tr>
                      <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">&nbsp;</td>
                      <td width="250" align="left" valign="middle" bgcolor="#D3DBE2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="150" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><input name="continuar" type="submit" id="continuar" value="continuar" /></td>
                      <td width="250" align="left" valign="middle" bgcolor="#D3DBE2"><label></label></td>
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
