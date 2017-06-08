<?php
include("../conecta.php");
require_once("class.ezpdf.php");


//Configuración de página-----------------

$pdf =& new Cezpdf('a4');

$pdf->selectFont('../fonts/courier.afm');

$pdf->ezSetCmMargins(1,1,1.5,1.5);

//Fin configuración de página-----------------


include("../funciones.php");
$link=conecta_sqls();


if (isset($_GET["txt_libro"])){
	$libro=$_GET["txt_libro"];
}


$query_libros="select id_libro,nro from je_regfirmas_libros where cerrado='1'";

$recordset_libros=mssql_query($query_libros,$link);



$txt_titulo="Estadísticas por libro";
$pdf->ezText($txt_titulo, 16);
$pdf->ezText("\n\n", 10);


//-----------------------------------------------

while($libro = mssql_fetch_assoc($recordset_libros)){

$query_total_firmas_validas="select count(distinct elector) as tot_firmas from je_regfirmas_registro where
firma='1'
and anulado='0'
and libro=".$libro["id_libro"];

$recordset_total_firmas_validas=mssql_query($query_total_firmas_validas,$link);
$total_firmas_validas=mssql_result($recordset_total_firmas_validas,0,"tot_firmas");

//------
$query_total_firmantes_nopadron="select count(distinct elector) as tot_firmantes from je_regfirmas_registro where firma='1' and anulado='1' and libro=".$libro["id_libro"];
$recordset_total_firmantes_nopadron=mssql_query($query_total_firmantes_nopadron,$link);
$total_firmantes_nopadron=mssql_result($recordset_total_firmantes_nopadron,0,"tot_firmantes");
//---------
$query_total_firmantes="select count(distinct elector) as tot_firmantes from je_regfirmas_registro where firma='1' and libro=".$libro["id_libro"];
$recordset_total_firmantes=mssql_query($query_total_firmantes,$link);
$total_firmantes=mssql_result($recordset_total_firmantes,0,"tot_firmantes");
//-------


$nombre_libro= "Libro Nro:".$libro["nro"];
$pdf->ezText($nombre_libro, 14);

$txt_firmas_validas="Total de firmas validas:".$total_firmas_validas;
$pdf->ezText($txt_firmas_validas, 12);

$txt_firmas_nopadron="Total de firmas no empadronados:".$total_firmantes_nopadron;
$pdf->ezText($txt_firmas_nopadron, 12);

$txt_firmantes="Total de firmantes:".$total_firmantes;
$pdf->ezText($txt_firmantes, 12);




$linea="______________________________________________________";
$pdf->ezText($linea, 12);


}



$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>