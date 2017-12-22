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
$sql="SELECT numero_chip,e.nombre,e.sexo,caracter, tamanio, condicion,especie, raza, pelaje,p.nombre AS Propietario, p.apellido,p.documento,p.calle_nocod,p.numeracion_calle,p.telefono, p.piso,p.departamento
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
$pdf->ezText('<b>Sistema Veterinaria y Zoonosis - MSCB</b>',14,array('justification'=>'center'));
$pdf->ezText("\n", 5);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("\n", 5);
$pdf->ezText($titles,14);
while($mascota = mysql_fetch_array($animales)){
  $i++;
  $pdf->ezText("_______________________________________ $i _____________________________________________", 10);
  $pdf->ezText("\n", 5);
  $pdf->ezText("__________________ Datos propietario __________________", 12);
  $pdf->ezText("\n", 5);
  $pdf->ezText('Nombre y Apellido:  '.$mascota['Propietario'].' '.$mascota['apellido'],10);
  $pdf->ezText('Documento:  '.$mascota['documento'],10);
  $pdf->ezText(utf8_decode('Teléfono'.$mascota['telefono']),10);
  $pdf->ezText('Calle:  '.$mascota['calle'],10);
  $pdf->ezText(utf8_decode('Número:  '.$mascota['numero']),10);
  $pdf->ezText('Piso:  '.$mascota['piso'],10);
  $pdf->ezText("\n", 5);
  $pdf->ezText("__________________ Datos animal __________________", 12);
  $pdf->ezText("\n", 5);
  $pdf->ezText(utf8_decode('Número Patentamiento / Chip:  '.$mascota['numero_chip']),10);
  $pdf->ezText('Nombre:    '.$mascota['nombre'],10);
  $pdf->ezText('Especie: '.$mascota['especie'],10);
  $pdf->ezText('Raza: '.$mascota['raza'],10);
  $pdf->ezText('Pelaje: '.$mascota['pelaje'],10);
  $pdf->ezText(utf8_decode('Tamaño: '.$mascota['tamanio']),10);
  $pdf->ezText('Sexo:       '.$mascota['sexo'],10);
  $pdf->ezText(utf8_decode('Carácter: '.$mascota['caracter']),10);
  $pdf->ezText(utf8_decode('Condición: '.$mascota['condicion']),10);

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
