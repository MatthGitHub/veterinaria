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
$documento=$_POST['documento'];

//DATOS PROPIETARIO
$sql = "SELECT * FROM personas WHERE documento = '$documento'";
$propietario = mysql_query($sql,$link_mysql);

$nombre = mysql_result($propietario,0,"nombre");
$apellido = mysql_result($propietario,0,"apellido");
$telefono = mysql_result($propietario,0,"telefono");
$barrio = mysql_result($propietario,0,"barrio");
$calle = mysql_result($propietario,0,"calle");
$numero = mysql_result($propietario,0,"numero");
$piso = mysql_result($propietario,0,"piso");
$depto = mysql_result($propietario,0,"depto");
$email = mysql_result($propietario,0,"email");


//DATOS MASCOTAS
$sql="SELECT numero_chip,e.nombre,sexo,caracter, tamanio, condicion,especie, raza, pelaje
      FROM ejemplares e
      JOIN ejemplares_personas ep ON e.id_ejemplar = ep.fk_id_ejemplar
      JOIN personas p ON p.id_persona = ep.fk_id_persona
      JOIN especies esp ON esp.id_especie = e.fk_id_especie
      JOIN razas r ON r.id_raza = e.fk_id_raza
      JOIN pelajes pel ON pel.id_pelaje = e.fk_id_pelaje
      WHERE documento = '$documento'";

$mascotas=mysql_query($sql,$link_mysql);


$pdf->ezImage("img.jpg", 0, 60, 'none', 'left');



$titles = 'Mascotas por propietario';

$pdf->ezText('<b>Municipalidad de San Carlos de Bariloche</b>',14,array('justification'=>'center'));
$pdf->ezText("\n", 5);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("\n", 10);
$pdf->ezText($titles,14);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("Datos propietario ________________________________________________________", 10);
$pdf->ezText('Nombre y Apellido:  '.$nombre.' '.$apellido,12);
$pdf->ezText('Documento:  '.$documento,12);
$pdf->ezText('Telefono'.$telefono,12);
$pdf->ezText('Correo:  '.$email,12);
$pdf->ezText('Barrio:  '.$barrio,12);
$pdf->ezText('Calle:  '.$calle,12);
$pdf->ezText('Numero:  '.$numero,12);
$pdf->ezText('Piso:  '.$piso,12);
$pdf->ezText("\n", 5);
$pdf->ezText("Datos mascotas ________________________________________________________", 10);
while($mascota = mysql_fetch_array($mascotas)){
  $pdf->ezText('Numero Chip:  '.$mascota['numero_chip'],12);
  $pdf->ezText('Nombre:    '.$mascota['nombre'],12);
  $pdf->ezText("\n", 10);
  $pdf->ezText('Sexo:       '.$mascota['sexo'],12);
  $pdf->ezText('Caracter: '.$mascota['caracter'],12);
  $pdf->ezText('Tamanio: '.$mascota['tamanio'],12);
  $pdf->ezText("\n", 10);
  $pdf->ezText('Condicion: '.$mascota['condicion'],12);
  $pdf->ezText('Especie: '.$mascota['especie'],12);
  $pdf->ezText('Raza: '.$mascota['raza'],12);
  $pdf->ezText('Pelaje: '.$mascota['pelaje'],12);
  $pdf->ezText("_______________________________________________________________________________________", 10);
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
