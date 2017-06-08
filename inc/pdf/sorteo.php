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




//------------------------------------------------------------

$query_tabla_firmantes="select * from sorteo";
$recordset_tabla_firmantes=mssql_query($query_tabla_firmantes,$link);

//---------------------------------------------------
while($participante = mssql_fetch_array($recordset_tabla_firmantes)) {
$enc="Padron: ".$participante["PADRON"]."         Nomenclatura: ".$participante["NOMENCLATURA"];
$pdf->ezText($enc, 10);
$encargado="Encargado: ".$participante["ENCARGADO"];
$titular="Titular: ".$participante["TITULAR"]."/n";
$linea="________________________________________________________";
$pdf->ezText($encargado, 10);
$pdf->ezText($titular, 10);
$pdf->ezText($linea, 10);
}





// Fin armado de matrices-----------------------------------

$txttit= "Listado de electores con firmas repetidas \n";


 


$pdf->ezText($txttit, 12);



$pdf->ezText("\n\n\n", 10);

$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);

$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
$pdf->ezStream();

?>