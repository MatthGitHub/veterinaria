<?php
//--------------------------------Inicio de sesion------------------------
include("../../lib/sesion.php"); 
if ($_SESSION['permiso'] != 'autorizado'){
	$mensaje="Usuario sin permisos";
	$destino="../index.php";
	header("location:../lib/mensaje.php?mensaje=$mensaje&destino=$destino");
}
//--------------------------------Fin inicio de sesion------------------------

include("../../lib/funciones.php");
require_once("class.ezpdf.php");


//Configuración de página-----------------

$pdf =& new Cezpdf('a4');

$pdf->selectFont('../fonts/courier.afm');

$pdf->ezSetCmMargins(1,1,1.5,1.5);

//Fin configuración de página-----------------


//---------------Querys-----------------------------



$link=conectarse_mysql();


$usuario=$_SESSION['id'];


if(isset($_GET['pdf_oficina_personal'])){
		$oficina_personal=$_GET['pdf_oficina_personal'];
	}
	else
	{
		$oficina_personal='%';
}

					  
if(isset($_GET['pdf_legajo'])){
		$legajo=$_GET['pdf_legajo'];
	}
	else
	{
		$legajo="";
}

					  
if(isset($_GET['pdf_fecha_desde'])){
		$fecha_desde=$_GET['pdf_fecha_desde'];
		$fecha_desde_mysql=fecha_normal_mysql($_GET['pdf_fecha_desde']);
		
	}
	else
	{
		$fecha_desde=timestampToFecha (time());
		$fecha_desde_mysql=fecha_normal_mysql(timestampToFecha (time()));
				
}

if(isset($_GET['pdf_fecha_hasta'])){
		$fecha_hasta=$_GET['pdf_fecha_hasta'];
		$fecha_hasta_mysql=fecha_normal_mysql($_GET['pdf_fecha_hasta']);
	}
	else
	{
		$fecha_hasta=timestampToFecha (time());
		$fecha_hasta_mysql=fecha_normal_mysql(timestampToFecha (time()));
}
				


//-------Si legajo es vacio trae todos entre fechas----------------------
if ($legajo==""){


$query_certificados="select c.id_certificado as certificado,fecha_recibido,legajo,apellido,nombre,m.descripcion as motivo,fecha_inicio,fecha_fin,aprobado,fuera_termino,descripcion_organigrama_original,descripcion_organigrama from 
certificados c inner join motivos m
on c.id_motivo=m.id_motivo
inner join historico_areas ha
on c.id_certificado=ha.id_certificado
where 
((fecha_fin >= '$fecha_desde_mysql' and fecha_fin <= '$fecha_hasta_mysql') or 
(fecha_inicio >= '$fecha_desde_mysql' and fecha_inicio <= '$fecha_hasta_mysql') or
(fecha_inicio >= '$fecha_desde_mysql' and fecha_inicio <= '$fecha_hasta_mysql' and fecha_fin >= '$fecha_desde_mysql' and fecha_fin <= '$fecha_hasta_mysql'))
and aprobado='1'
and personal like'$oficina_personal'
and fuera_termino='1'
order by apellido";
}
else
{

if (strlen($legajo) < 8 and $legajo !="") {
		$repeticion=8-strlen($legajo);
		$relleno = str_repeat('0',$repeticion);
        $legajo = $relleno.$legajo;
    }

$query_certificados="select c.id_certificado as certificado,fecha_recibido,legajo,apellido,nombre,m.descripcion as motivo,fecha_inicio,fecha_fin,aprobado, fuera_termino,descripcion_organigrama_original,descripcion_organigrama from 
certificados c inner join motivos m
on c.id_motivo=m.id_motivo
inner join historico_areas ha
on c.id_certificado=ha.id_certificado 
where 
((fecha_fin >= '$fecha_desde_mysql' and fecha_fin <= '$fecha_hasta_mysql') or 
(fecha_inicio >= '$fecha_desde_mysql' and fecha_inicio <= '$fecha_hasta_mysql') or
(fecha_inicio >= '$fecha_desde_mysql' and fecha_inicio <= '$fecha_hasta_mysql' and fecha_fin >= '$fecha_desde_mysql' and fecha_fin <= '$fecha_hasta_mysql'))
and legajo='$legajo'
and aprobado='1'
and personal like '$oficina_personal'
and fuera_termino='1'
order by apellido";
}
//-------FIN Si legajo es vacio trae todos entre fechas----------------------


$record_certificados=mysql_query($query_certificados,$link);

//--------------Fin querys----------------------------









//Armado de las matrices-------------------------------------
$ixx = 0;
while($datatmp = mysql_fetch_assoc($record_certificados)) {
	$ixx = $ixx+1;
	 $datatmp["legajo"]=(int)$datatmp["legajo"];
	$datatmp["fecha_recibido"]=fecha_mysql_normal($datatmp["fecha_recibido"]);
	$datatmp["fecha_inicio"]=fecha_mysql_normal($datatmp["fecha_inicio"]);
	$datatmp["fecha_fin"]=fecha_mysql_normal($datatmp["fecha_fin"]);
	
	if($datatmp["descripcion_organigrama"]==""){
			$datatmp["descripcion_organigrama"]=$datatmp["descripcion_organigrama_original"];
			}
			else
			{
			$datatmp["descripcion_organigrama"]=$datatmp["descripcion_organigrama"];
			}
	
	
    $data[] = array_merge($datatmp, array('num'=>$ixx));

}


$titles = array(

                //'num'=>'<b>Num</b>',

               	'legajo'=>'<b>legajo</b>',
              	'apellido'=>' <b>Apellido</b>',
				'nombre'=>' <b>Nombre</b>',
				'motivo'=>' <b>Motivo</b>',
				'fecha_recibido'=>' <b>Recibido</b>',
				'fecha_inicio'=>' <b>Inicio</b>',
				'fecha_fin'=>' <b>Fin</b>',
				'descripcion_organigrama'=>' <b>Area</b>',

            

            );


$options = array(

              	
'fontSize' => 7,
'rowGap' => 1,
                'xOrientation'=>'center',

                'width'=>600,
				
				'cols'=>array( 
'legajo' => array('justification'=>'left', 'width' => '30'), 
'apellido' => array('justification'=>'left', 'width' => '66'), 
'nombre' => array('justification'=>'left', 'width' => '60'), 
'motivo' => array('justification'=>'left', 'width' => '50'), 
'fecha_recibido' => array('justification'=>'left', 'width' => '50'), 
'fecha_inicio'=> array('justification'=>'left', 'width' => '50'), 
'fecha_fin' => array('justification'=>'left', 'width' => '50'), 
'descripcion_organigrama' => array('justification'=>'left', 'width' => '130'))

            );


// Fin armado de matrices-----------------------------------

$txttit= "Listado de ausentes entre el día ".$fecha_desde." y el ".$fecha_hasta." ,certificados fuera de termino\n";


 


$pdf->ezText($txttit, 12);


$pdf->ezTable($data,$titles ,'' , $options);

$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>