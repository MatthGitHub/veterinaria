<?php
//--------------------------------Inicio de sesion------------------------
include("../sesion.php"); 
if ($_SESSION['permiso'] != 'autorizado'){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------


require_once("class.ezpdf.php");


//Configuración de página-----------------

$pdf =& new Cezpdf('a4');

$pdf->selectFont('fonts/courier.afm');

$pdf->ezSetCmMargins(1,1,1.5,1.5);

//Fin configuración de página-----------------


//Lectura de la base-----------------------------
include("../funciones.php");
$link=conectarse_mysql_horas_extras();

$fdesde=fecha_normal_mysql($_POST['txt_fdesde']);
$fhasta=fecha_normal_mysql($_POST['txt_fhasta']);
$area=$_POST['txt_area'];

if($area==""){
$query="select id_cupo,estado,fecha_cupo,cantidad_hs,horas_utilizadas,codigo_area,concepto from cupos inner join in_organigrama
on cupos.codigo_area=in_organigrama.codigo_organigrama where fecha_cupo >='$fdesde' and fecha_cupo<='$fhasta'";
}
else
{
$query="select id_cupo,estado,fecha_cupo,cantidad_hs,horas_utilizadas,codigo_area,concepto from cupos inner join in_organigrama
on cupos.codigo_area=in_organigrama.codigo_organigrama where codigo_organigrama='$area' and fecha_cupo >='$fdesde' and fecha_cupo<='$fhasta'";
}


$recordset=mysql_query($query,$link);



//Fin lectura de la base----------------------------




//Armado de las matrices-------------------------------------
$ixx = 0;
while($datatmp = mysql_fetch_assoc($recordset)) {
	$ixx = $ixx+1;
	
	$datatmp["fecha_cupo"]=fecha_mysql_normal($datatmp["fecha_cupo"]); 
	$nro_mes=date("m", strtotime($datatmp["fecha_cupo"]));
	
	switch ($nro_mes) {
    case 01:
        $mes="Enero";
        break;
	case 02:
        $mes="Febrero";
        break;
	case 03:
        $mes="Marzo";
        break;
	case 04:
        $mes="Abril";
        break;
	case 05:
        $mes="Mayo";
        break;
	case 06:
        $mes="Junio";
        break;
	case 07:
        $mes="Julio";
        break;
	case 08:
        $mes="Agosto";
        break;
	case 09:
        $mes="Septiembre";
        break;
	case 10:
        $mes="Octubre";
        break;
	case 11:
        $mes="Noviembre";
        break;
	case 12:
        $mes="Diciembre";
        break;
    
}

$datatmp["mes"]=$mes;
	
    $data[] = array_merge($datatmp, array('num'=>$ixx));

}


$titles = array(

                //'num'=>'<b>Num</b>',

               	'id_cupo'=>'<b>Cupo</b>',
				'mes'=>'<b>Mes</b>',
              	'fecha_cupo'=>' <b>fecha</b>',
				'cantidad_hs'=>' <b>Cant horas</b>',
				'horas_utilizadas'=>' <b>Horas utilizadas</b>',
				'concepto'=>' <b>Area</b>',

            

            );


$options = array(

              //  'shadeCol'=>array(0.9,0.9,0.9),

                'xOrientation'=>'center',

                'width'=>500

            );


// Fin armado de matrices-----------------------------------

$txttit= "Cupos por areas";


 


$pdf->ezText($txttit, 14);
$pdf->ezText("\n", 12);

$pdf->ezTable($data,$titles ,'' , $options);

$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>