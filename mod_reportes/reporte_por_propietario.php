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
$sql="SELECT  e.id_ejemplar, numero_chip,e.nombre,e.sexo,e.anio_nacimiento,caracter, tamanio, condicion,especie, raza, pelaje, chs.fecha_alta
  FROM ejemplares e 
  JOIN ejemplares_personas ep ON e.id_ejemplar = ep.fk_id_ejemplar 
  JOIN personas p ON p.id_persona = ep.fk_id_persona 
  JOIN especies esp ON esp.id_especie = e.fk_id_especie 
  JOIN razas r ON r.id_raza = e.fk_id_raza 
  JOIN pelajes pel ON pel.id_pelaje = e.fk_id_pelaje 
  JOIN chipeados chs ON chs.fk_id_ejemplar = e.id_ejemplar WHERE documento = '$documento'";


$mascotas=mysql_query($sql,$link_mysql);

//$pdf->ezImage($image="bariloche_municipio.jpg", $pad = 0,$width = 200,$resize = 'none',$just = 'left',$border = '');
//$pdf->ezImage("img.jpg", 0, 60, 'none', 'left');

$titles = 'Animales por propietario';

$pdf->ezText('<b>Sistema Veterinaria y Zoonosis - MSCB</b>',14,array('justification'=>'center'));
$pdf->ezText("\n", 5);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("\n", 10);
$pdf->ezText($titles,14);
$pdf->ezText("_______________________________________________________________________________________", 10);
$pdf->ezText("\n", 5);
$pdf->ezText("_________________ Datos propietario _________________", 12);
$pdf->ezText("\n", 5);
$pdf->ezText('Nombre y Apellido:  '.$nombre.' '.$apellido,10);
$pdf->ezText('Documento:  '.$documento,10);
$pdf->ezText(utf8_decode('Teléfono'.$telefono),10);
$pdf->ezText('Correo:  '.$email,10);
$pdf->ezText('Barrio:  '.$barrio,10);
$pdf->ezText('Calle:  '.$calle,10);
$pdf->ezText(utf8_decode('Número:  '.$numero),10);
$pdf->ezText('Piso:  '.$piso,10);
$pdf->ezText("\n", 5);
$pdf->ezText("_________________ Datos animales _________________", 12);
$pdf->ezText("\n", 5);
$i = 1;
while($mascota = mysql_fetch_array($mascotas)){
  $pdf->ezText("\n", 3);
  $pdf->ezText("_________________ Animal ".$i." _________________", 11);
  $pdf->ezText("\n", 3);
  $pdf->ezText(utf8_decode('Número Patentamiento / Chip:  '.$mascota['numero_chip']),10);
  $pdf->ezText('Patentamiento:  '.fecha_normal_mysql($mascota['fecha_alta']),10);
  $pdf->ezText('Nombre:    '.$mascota['nombre'],10);
  $pdf->ezText(utf8_decode('Año Nacimiento: '.fecha_normal_mysql($mascota['anio_nacimiento'])),10);
  $pdf->ezText("\n", 3);
  $pdf->ezText('Especie: '.$mascota['especie'],10);
  $pdf->ezText('Raza: '.$mascota['raza'],10);
  $pdf->ezText('Pelaje: '.$mascota['pelaje'],10);
  $pdf->ezText(utf8_decode('Tamaño: '.$mascota['tamanio']),10);
  $pdf->ezText('Sexo:       '.$mascota['sexo'],10);
  $pdf->ezText(utf8_decode('Carácter: '.$mascota['caracter']),10);
  $pdf->ezText(utf8_decode('Condición: '.$mascota['condicion']),10);


  $sql_vacunas = "SELECT vac.nombre_vacuna, vac_ej.fecha_aplicacion FROM ejemplares e JOIN vacunas_ejemplares vac_ej ON vac_ej.fk_ejemplar = e.id_ejemplar JOIN vacunas vac ON vac.id_vacuna = vac_ej.fk_vacuna WHERE e.id_ejemplar = '".$mascota['id_ejemplar']."' ";

  $vacunas=mysql_query($sql_vacunas,$link_mysql);

  $pdf->ezText("\n", 5);
  $pdf->ezText(utf8_decode("_________________ Vacunas al día de la fecha _________________"), 11);
  $pdf->ezText("\n", 5);

  while($vacuna = mysql_fetch_array($vacunas)){
    $pdf->ezText('Vacuna:  '.$vacuna['nombre_vacuna'],10);
    $pdf->ezText(utf8_decode('Fecha aplicación:    '.$vacuna['fecha_aplicacion']),10);
    $pdf->ezText("\n", 3);
    $pdf->ezText("-------------------------------------------------------", 10);
  }
  $i++;
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
