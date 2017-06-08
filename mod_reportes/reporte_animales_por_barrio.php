<?php
include("../lib/funciones.php");
include("../mod_sql/sql.php");
//include('../inc/pdf/class.ezpdf.php');
include('class.ezpdf.php');

//Configuraci�n de p�gina-----------------

$pdf =& new Cezpdf('a4');

$pdf->selectFont('fonts/courier.afm');

$pdf->ezSetCmMargins(1,1,1.5,1.5);

//Fin configuraci�n de p�gina-----------------

$link_mysql=conectarse_mysql_veterinaria();
$barrio=$_POST['barrio'];

//DATOS
$sql="SELECT numero_chip,e.nombre,sexo,caracter, tamanio, condicion,especie, raza, pelaje,p.nombre AS Propietario, p.apellido,p.documento,p.calle,p.numero,p.telefono, p.piso,p.departamento
      FROM ejemplares e
      JOIN ejemplares_personas ep ON e.id_ejemplar = ep.fk_id_ejemplar
      JOIN personas p ON p.id_persona = ep.fk_id_persona
      JOIN especies esp ON esp.id_especie = e.fk_id_especie
      JOIN razas r ON r.id_raza = e.fk_id_raza
      JOIN pelajes pel ON pel.id_pelaje = e.fk_id_pelaje
      WHERE p.barrio LIKE '%$barrio%'";

$animales = mysql_query($sql,$link_mysql);

$pdf->ezImage("img.jpg", 0, 60, 'none', 'left');

$titles = 'Animales por barrio: '.$barrio;

$i= 0;
$pdf->ezText('<b>Municipalidad de San Carlos de Bariloche</b>',14,array('justification'=>'center'));
$pdf->ezText("\n", 5);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("\n", 10);
$pdf->ezText($titles,14);
while($mascota = mysql_fetch_array($animales)){
  $i++;
  $pdf->ezText("_______________________________________ $i _____________________________________________", 10);
  $pdf->ezText("Datos propietario ________________________________", 13);
  $pdf->ezText("\n", 5);
  $pdf->ezText('Nombre y Apellido:  '.$mascota['Propietario'].' '.$mascota['apellido'],12);
  $pdf->ezText('Documento:  '.$mascota['documento'],12);
  $pdf->ezText('Telefono'.$mascota['telefono'],12);
  $pdf->ezText('Calle:  '.$mascota['calle'],12);
  $pdf->ezText('Numero:  '.$mascota['numero'],12);
  $pdf->ezText('Piso:  '.$mascota['piso'],12);
  $pdf->ezText("\n", 5);
  $pdf->ezText("Datos ejemplar ____________________________________", 13);
  $pdf->ezText("\n", 5);
  $pdf->ezText('Numero Chip:  '.$mascota['numero_chip'],12);
  $pdf->ezText('Nombre:    '.$mascota['nombre'],12);
  $pdf->ezText('Sexo:       '.$mascota['sexo'],12);
  $pdf->ezText('Caracter: '.$mascota['caracter'],12);
  $pdf->ezText('Tamanio: '.$mascota['tamanio'],12);
  $pdf->ezText('Condicion: '.$mascota['condicion'],12);
  $pdf->ezText('Especie: '.$mascota['especie'],12);
  $pdf->ezText('Raza: '.$mascota['raza'],12);
  $pdf->ezText('Pelaje: '.$mascota['pelaje'],12);
}

$pdf->ezText("\n", 10);
$options = array(
'fontSize' => 7,
'rowGap' => 1,
'xOrientation'=>'center',
'width'=>600,
'cols'=>array(
  'fecha' => array('justification'=>'left', 'width' => '50'),
  'v_descripcion' => array('justification'=>'left', 'width' => '200'),
  'a_descripcion' => array('justification'=>'left', 'width' => '200'),
  'c_cantidad' => array('justification'=>'left', 'width' => '50')));


$pdf->ezText("<b>Fecha reporte:</b> ".date("d/m/Y"),10);
$pdf->ezText("<b>Hora reporte:</b> ".date("H:i:s")."\n\n",10);
$pdf->ezStream();
?>
