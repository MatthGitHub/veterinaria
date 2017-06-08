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

$legajo=$_POST['txt_legajo'];
$fdesde=fecha_normal_mysql($_POST['txt_fdesde']);
$fhasta=fecha_normal_mysql($_POST['txt_fhasta']);


$link_horas_extras=conectarse_mysql_horas_extras();

if($legajo==""){
$query="select 
concepto,
fecha_hora_extra,
legajo_fk,apellido,
empleados.nombre as nom_persona,
tipo_hora_fk,hs_solicitadas,
hs_realizadas,
pago,
cupos_horas_personas.numero_nota,
cupos_horas_personas.fecha_nota,
horas_tipo.nombre as hora_tipo
from cupos_horas_personas 
inner join empleados on cupos_horas_personas.legajo_fk=empleados.legajo
inner join horas_tipo on cupos_horas_personas.tipo_hora_fk=horas_tipo.id_tipo_hora
inner join cupos on cupos.id_cupo = cupos_horas_personas.id_cupo_fk
inner join in_organigrama on codigo_organigrama = cupos.codigo_area
where fecha_hora_extra >='$fdesde' and fecha_hora_extra<='$fhasta'
order by fecha_hora_extra,concepto";
}
else
{
$query="select 
concepto,
fecha_hora_extra,
legajo_fk,apellido,
empleados.nombre as nom_persona,
tipo_hora_fk,hs_solicitadas,
hs_realizadas,
pago,
cupos_horas_personas.numero_nota,
cupos_horas_personas.fecha_nota,
horas_tipo.nombre as hora_tipo
from cupos_horas_personas 
inner join empleados on cupos_horas_personas.legajo_fk=empleados.legajo
inner join horas_tipo on cupos_horas_personas.tipo_hora_fk=horas_tipo.id_tipo_hora
inner join cupos on cupos.id_cupo = cupos_horas_personas.id_cupo_fk
inner join in_organigrama on codigo_organigrama = cupos.codigo_area
where legajo_fk='$legajo' and fecha_hora_extra >='$fdesde' and fecha_hora_extra<='$fhasta' order by apellido,fecha_hora_extra,concepto";
}


$recordset=mysql_query($query,$link_horas_extras);



//Fin lectura de la base----------------------------



//Armado de las matrices-------------------------------------
$ixx = 0;
while($datatmp = mysql_fetch_assoc($recordset)) {
	$ixx = $ixx+1;
	
	$datatmp["fecha_hora_extra"]=fecha_mysql_normal($datatmp["fecha_hora_extra"]); 
	$datatmp["fecha_nota"]=fecha_mysql_normal($datatmp["fecha_nota"]);
	$datatmp["pago"]=$datatmp["pago"]." %";
	
	$total_horas_solicitadas=$total_horas_solicitadas+$datatmp["hs_solicitadas"];
	$total_horas_realizadas=$total_horas_realizadas+$datatmp["hs_realizadas"];
	
	$area=$total_horas_realizadas+$datatmp["concepto"];

    $data[] = array_merge($datatmp, array('num'=>$ixx));

}


$titles = array(

                //'num'=>'<b>Num</b>',
                'concepto'=>'<b>Area</b>',
               	'fecha_hora_extra'=>'<b>Fecha</b>',
              	'legajo_fk'=>' <b>Legajo</b>',
				'apellido'=>' <b>Apellido</b>',
				'nom_persona'=>' <b>Nombre</b>',
				'hora_tipo'=>' <b>Tipo hora</b>',
				'hs_solicitadas'=>' <b>Hs solicitadas</b>',
				'hs_realizadas'=>' <b>Hs realizadas</b>',
				'pago'=>' <b>Pago</b>',
				'numero_nota'=>' <b>Nro nota</b>',
				'fecha_nota'=>' <b>Fecha nota</b>',
				
            

            );


$options = array(

              //  'shadeCol'=>array(0.9,0.9,0.9),
				'fontSize' => 8,
                'xOrientation'=>'center',

                'width'=>500,
				
				'cols'=>array( 
'concepto' => array('justification'=>'left', 'width' => '40'), 
'fecha_hora_extra' => array('justification'=>'left', 'width' => '53'), 
'legajo_fk' => array('justification'=>'left', 'width' => '45'), 
'apellido' => array('justification'=>'left', 'width' => '70'), 
'nom_persona' => array('justification'=>'left', 'width' => '70'), 
'hora_tipo' => array('justification'=>'left', 'width' => '50'), 
'hs_solicitadas'=> array('justification'=>'left', 'width' => '50'), 
'hs_realizadas' => array('justification'=>'left', 'width' => '50'), 
'pago' => array('justification'=>'left', 'width' => '45'),
'numero_nota' => array('justification'=>'left', 'width' => '50'),
'fecha_nota' => array('justification'=>'left', 'width' => '53'))

            );


// Fin armado de matrices-----------------------------------

$txttit= "Cupos por areas";


$txt_horas_solicitadas="Total de horas solicitadas :".$total_horas_solicitadas;
$txt_horas_realizadas="Total de horas realizadas :".$total_horas_realizadas; 


$pdf->ezText($txttit, 15);
$pdf->ezText("\n", 12);

$pdf->ezTable($data,$titles ,'' , $options);

$pdf->ezText("\n", 12);

$pdf->ezText($txt_horas_solicitadas, 12);
$pdf->ezText($txt_horas_realizadas, 12);

$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>