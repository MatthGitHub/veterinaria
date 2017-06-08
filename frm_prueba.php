<?php 




$legajo=$_POST["txt_legajo"];
$codigo_organigrama=$_POST["txt_id_area"];
$codigo_ubicacion=$_POST["txt_id_edificio"];
$descripcion_organigrama=$_POST["txt_area"];
$descripcion_ubicacion=$_POST["txt_edificio"];








?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Certificado</title>
<link href="../css/estilos.css" rel="stylesheet" type="text/css" />

<script language='javascript' src="../jscripts/funciones.js"></script>
<script language='javascript' src="../jscripts/popcalendar.js"></script>

<script type="text/JavaScript">
<!--

/**************************************************************
Máscara de entrada. Script creado por Tunait! (21/12/2004)
Si quieres usar este script en tu sitio eres libre de hacerlo con la condición de que permanezcan intactas estas líneas, osea, los créditos.
No autorizo a distribuír el código en sitios de script sin previa autorización
Si quieres distribuírlo, por favor, contacta conmigo.
Ver condiciones de uso en http://javascript.tunait.com/
tunait@yahoo.com 
****************************************************************/
var patron = new Array(2,2,4)
var patron2 = new Array(1,3,3,3,3)
function mascara(d,sep,pat,nums){
if(d.valant != d.value){
	val = d.value
	largo = val.length
	val = val.split(sep)
	val2 = ''
	for(r=0;r<val.length;r++){
		val2 += val[r]	
	}
	if(nums){
		for(z=0;z<val2.length;z++){
			if(isNaN(val2.charAt(z))){
				letra = new RegExp(val2.charAt(z),"g")
				val2 = val2.replace(letra,"")
			}
		}
	}
	val = ''
	val3 = new Array()
	for(s=0; s<pat.length; s++){
		val3[s] = val2.substring(0,pat[s])
		val2 = val2.substr(pat[s])
	}
	for(q=0;q<val3.length; q++){
		if(q ==0){
			val = val3[q]
		}
		else{
			if(val3[q] != ""){
				val += sep + val3[q]
				}
		}
	}
	d.value = val
	d.valant = val
	}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_changeProp(objName,x,theProp,theValue) { //v6.0
  var obj = MM_findObj(objName);
  if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
    if (theValue == true || theValue == false)
      eval("obj."+theProp+"="+theValue);
    else eval("obj."+theProp+"='"+theValue+"'");
  }
}

function validar(frm) {
  if (!confirm('¿Confirma el registro del certificado?')){   
	   return (false); 
   }

function confirmar() {
	if (confirm ("Seguro de que deseas salir?")) {
	document.location.href = 'http://www.unapagina.com';
	}
}
   
    
}

//-->
</script>
<style type="text/css">
<!--
.style17 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
</head>


<body class="estilo_body" onLoad="document.form1.combo_motivo.focus();"  onUnLoad="confirmar();">

<table width="770" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#DBDBDB">
  <tr>
    <td width="770" bgcolor="#A8B6C6" class="titulos_pantalla">Alta de certificado </td>
  </tr>
  <tr>
    <td bgcolor="#A8B6C6"><table width="770" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><form id="form1" name="form1" method="post" onsubmit="return validar(this)" action="prueba.php" >
            <table width="770" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="middle" bgcolor="#D3DBE2"><table width="770" border="0" align="left" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
                    <tr>
                      <td width="170" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fecha de inicio: </td>
                      <td width="600" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                        <input name="txt_fecha_inicio" type="text" id="txt_fecha_inicio" tabindex="5"  size="10" />
                      </span></td>
                    </tr>
                    <tr>
                      <td width="170" align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fecha de fin: </td>
                      <td width="600" align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                        <input name="txt_fecha_fin" type="text" id="txt_fecha_fin" tabindex="5" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" onclick="popUpCalendar(this, form1.txt_fecha_fin, 'dd-mm-yyyy');" value="<?php echo timestampToFecha (time()); ?>" size="10" />
                      </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Diagnostico:</td>
                      <td align="left" valign="middle" bgcolor="#D3DBE2">
                        <textarea name="txt_diagnostico" cols="60" rows="5" id="txt_diagnostico" tabindex="6" onkeypress="return tabular(event,this)"></textarea>                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Recibido por:</td>
                      <td align="left" valign="middle" bgcolor="#D3DBE2"><input name="txt_recibido_por" type="text" id="txt_recibido_por" tabindex="4" onkeypress="return tabular(event,this)" size="50" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">Fecha recibido:</td>
                      <td align="left" valign="middle" bgcolor="#D3DBE2"><span class="style17">
                        <input name="txt_fecha_recibido" type="text" id="txt_fecha_recibido" tabindex="5" onkeypress="return tabular(event,this)" onkeyup="mascara(this,'-',patron,true)" onclick="popUpCalendar(this, form1.txt_fecha_recibido, 'dd-mm-yyyy');" value="<?php echo timestampToFecha (time()); ?>" size="10" />
                      </span></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#D3DBE2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas">&nbsp;</td>
                      <td align="left" valign="middle" bgcolor="#D3DBE2">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" bgcolor="#D3DBE2" class="etiquetas"><input type="submit" name="Submit" value="&gt;&gt;" /></td>
                      <td align="left" valign="middle" bgcolor="#D3DBE2"></td>
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
